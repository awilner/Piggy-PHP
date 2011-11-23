<?php
class NavMenuComponent extends Component
{
	var $name = 'NavMenu';

	var $components = array('Session');

	var $menuModel = null;

	function initialize($controller)
	{
		$this->menuModel = ClassRegistry::init('NavMenu');
	}

	//function tabs()
	//{
	//	return $this->menuModel->definition();
	//}

	function menu($type = null)
	{
	//	if( $type == null )
	//		$type = $this->Session->read('NavMenu.type');

	//	if( $tab == null )
	//		$tab = $this->Session->read('NavMenu.tab');

		// Now get the appropriate nav menu.
		return $this->menuModel->menu($type);
	}

	function checkType($type)
	{
		return $this->menuModel->checkType($type);
	}

	//function checkTab($type, $tab)
	//{
	//	return $this->menuModel->checkTab($type, $tab);
	//}
}
?>
