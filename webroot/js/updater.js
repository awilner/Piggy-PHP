function updateAll(response,url)
{
	// First create an element that will contain all elemets to be updated.
	var list = new Element('div');
	list.update(response.responseText);

	// Get the list of elements.
	var children = list.childElements();
	children.each(
		function(element)
		{
			// Get the document's element with the id of the elementi and replace its contents.
			$(element.id).update(element.innerHTML);
		}
	);

	// Update the url in the browser.
	//window.history.pushState({"url":url},"",url);
	window.history.replaceState({"url":url},"",url);
}

function go(url)
{
	var jsRequest = new Ajax.Request(url, {onComplete:function (transport) {updateAll(transport,url); Element.hide('loading_div'); Element.show('main_display'); new Effect.Highlight('main_display')}, onCreate:function (transport) {Element.hide('main_display'); Element.show('loading_div')}});
}

