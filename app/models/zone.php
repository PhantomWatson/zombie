<?php
class Zone extends AppModel {
	var $name = 'Zone';
	
	// Each method should return the path to a view file (e.g. '/zones/bar/intro')
	function bar($data = null) {
		switch ($data['action']) {
			case 'Commence to asswhooping':
				
				break;
			default:
			case 'Begin':
				return '/zones/bar/intro';
		}
		
	}
}
?>