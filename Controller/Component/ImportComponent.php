<?php
class ImportComponent extends Component {

	function parseQifDate($dateString)
	{
		$date = null;
		// Try to parse using default php parser.
		$parsedDate = strtotime($dateString);
		if( $parsedDate)
			$date = strftime("%Y-%m-%d",$parsedDate);

		if(!$date)
		{
			// Default parser failed, must be using QIF's bizarre format.
			$matches = array();
			if(preg_match("/(\\d\\d?)\\/\\s?(\\d\\d?)'\\s?(\\d+)/",$dateString,$matches))
			{
				// Adjust year.
				if($matches[3] < 70)
					$matches[3] += 2000;
				else if($matches[3] < 100)
					$matches[3] += 1900;
				$date = sprintf("%04d-%02d-%02d",$matches[3],$matches[1],$matches[2]);
			}
		}

		return $date;
	}

	function parseMoney($value)
	{
		// First we have to detect if the decimal mark is a point or a comma.
		if(preg_match("/\\.\\d\\d$/",$value))
			$money = preg_replace("/[^\\-\\+\\d\\.]/i","",$value);
		else if(preg_match("/,\\d\\d$/",$value))
                        $money = preg_replace("/[^\\-\\+\\d,]/i","",$value);
		else
			$money = preg_replace("/[^\\-\\+\\d]/i","",$value);

		return $money;
	}

    function &parsePrice(&$array) {
	$result = array();

	for($i = 0; $i < count($array); $i++)
	{
		$tokens = preg_split("/,/",$array[$i],-1,PREG_SPLIT_NO_EMPTY);
		
		$security = trim($tokens[0],"\"");
		$value = $tokens[1];
		$date = trim($tokens[2],"\"");

		$result[$security][$date] = $value;
	}

	return $result;
    }

    function &parseEntry(&$array) {
	$result = array();

	for($i = 0; $i < count($array); $i++)
	{
		$entry = array();
		$tokens = preg_split("/\n/",$array[$i],-1,PREG_SPLIT_NO_EMPTY);

		for($j = 0; $j < count($tokens); $j++)
		{
			// Split each line into the first letter and the rest.
			$key = substr($tokens[$j],0,1);
			$value = rtrim(substr($tokens[$j],1));

			// If the result already contains the key, make it into an array - if it isn't already.
			if(array_key_exists($key,$entry))
			{
				// If the value is not yet an array, transform it into an array.
				if(!is_array($entry[$key]))
				{
					$old_value = $entry[$key];
					$entry[$key] = array($old_value);
				}

				// Now we add the value to the array.
				array_push($entry[$key],$value);
			}
			else
			{
				$entry[$key] = $value;
			}
		}

		array_push($result, $entry);
	}

	return $result;
    }

    function &parseQif(&$text) {
	$tags = array();
	$categories = array();
	$securities = array();
	$memorized = array();
	$prices = array();
	$messages = array();
	$transactions = array();
	$accounts = array();
	$account = "";
	$autoswitch = 0;

	// First of all, split the file into distinct sections.
	$sections = preg_split("/\\s*(\\!\\w+:?\\w+)\\s*/",$text,-1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);

	for($i = 0; $i < count($sections); $i++)
		if(!preg_match("/^\\!/",$sections[$i]))
			$sections[$i] = preg_split("/\\s*\\^\\s*/",$sections[$i],-1,PREG_SPLIT_NO_EMPTY);

	// Now parse the distinct sections.
	for($i = 0; $i < count($sections); $i++)
	{
		// Each section should start with '!' and should not be an array.
		if(is_array($sections[$i]) || !preg_match("/^\\!/",$sections[$i]))
			continue;

		switch($sections[$i])
		{
		case "!Type:Tag":
			$i++;
			$tags = array_merge($tags,$sections[$i]);
			break;

		case "!Type:Cat":
			$i++;
			$categories = array_merge($categories,$sections[$i]);
			break;

		case "!Option:AutoSwitch":
			$autoswitch = 1;
			break;

		case "!Clear:AutoSwitch":
			$autoswitch = 0;
			$account = "";
			break;

		case "!Account":
			// Parse the next account to use.
			$i++;
			$accountData = $this->parseEntry($sections[$i]);
				
			if($autoswitch)
			{
				$account = $accountData[count($accountData) - 1]["N"];
			}

			for($j = 0; $j < count($accountData); $j++)
			{
				$accountName = $accountData[$j]["N"];
				if(!array_key_exists($accountName, $accounts))
					$accounts[$accountName] = $accountData[$j];
			}
			break;

		case "!Type:Security":
			$i++;
			$securities = array_merge($securities,$sections[$i]);
			break;

		case "!Type:Bank":
		case "!Type:CCard":
		case "!Type:Oth":
		case "!Type:Invst":
			$i++;

			// If no account is given, use an unnamed account.
			if($account == "")
				$account = "!UNNAMED";

			// If the transaction list does not exist for the current account, create.
			if(!array_key_exists($account,$transactions))
				$transactions[$account] = array();

			$currentTransactions = &$transactions[$account];
			$currentTransactions = array_merge($currentTransactions,$sections[$i]);
			break;

		case "!Type:Memorized":
			$i++;
			$memorized = array_merge($memorized,$sections[$i]);
			break;

		case "!Type:Prices":
			$i++;
			$currentPrices = $this->parsePrice($sections[$i]);
			foreach($currentPrices as $security=>$list)
			{
				foreach($list as $date=>$price)
					$prices[$security][$date] = $price;
			}
			break;

		default:
			array_push($messages,"Unknown tag \"".$sections[$i]."\"");
			break;
		}
	}
	
	$result["messages"] = $messages;
	$result["tags"] = $tags;
	$result["categories"] = $categories;
	$result["securities"] = $securities;
	$result["memorized"] = $memorized;
	$result["prices"] = $prices;
	$result["accounts"] = $accounts;
	$result["transactions"] = $transactions;
//	$result["sections"] = $sections;
        return $result;
    }

}

?>
