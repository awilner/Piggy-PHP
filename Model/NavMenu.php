<?php
class NavMenu extends AppModel
{
	var $name = 'NavMenu';
	var $useTable = false;

	var $menuDefinition = array(
		'overview' => 'Overview',
		'transactions' => 'Transactions',
		'bills' => 'Bills',
		'portfolio'=> 'Portfolio'
	);

	var $menuMode = array(
		'general' => array('overview','bills','portfolio'),
		'checking' => array('overview','transactions','bills'),
		'investment' => array('overview','transactions','portfolio'),
		'credit' => array('overview','transactions'),
		'asset' => array('overview','transactions'),
		'liability' => array('overview','transactions')
	);

	function menu($type)
	{
		// If no type has been seti or the type is unknown, set the type as general.
		if( $type == null || !array_key_exists($type,$this->menuMode) )
			$type = 'general';

		// If no tab has been seti or the current type doesn't have the tab, set the tab as overview.
		//if( $tab == null || !in_array($tab,$this->menuMode[$type]) )
		//	$tab = 'overview';

		// Now assemble the structure to export.
		$menu = array();
		foreach($this->menuMode[$type] as $tab):
			$menu[$tab] = $this->menuDefinition[$tab];
		endforeach;
		return $menu;
	}

	function checkType($type)
	{
		// If no type has been seti or the type is unknown, set the type as general.
                if( $type == null || !array_key_exists($type,$this->menuMode) )
                        $type = 'general';

		return $type;
	}

	//function checkTab($type,$tab)
	//{
	//	$type = $this->checkType($type);

                // If no tab has been seti or the current type doesn't have the tab, set the tab as overview.
        //        if( $tab == null || !in_array($tab,$this->menuMode[$type]) )
        //                $tab = 'overview';

	//	return $tab;
	//}

}
?>
