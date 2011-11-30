function updateAll(response,url)
{
	// Get the list of elements.
	$('<div/>').html(response.responseText).children().each(
		function()
		{
			// Get the document's element with the id of the elementi and replace its contents.
			$('#'+$(this).attr('id')).html($(this).html());
		}
	);

	// Update the url in the browser.
	//window.history.pushState({"url":url},"",url);
	window.history.replaceState({"url":url},"",url);
}

function go(url)
{
	$('#main_display').hide();
	$('#loading_div').show();
	$.ajax({
		url:url,
		complete:function(xhr) {updateAll(xhr,url); $('#loading_div').hide(); $('#main_display').show().effect('highlight');}
	});
}

