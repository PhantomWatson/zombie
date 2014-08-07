<?php
class PagesController extends AppController {
	var $components = array();
	var $helpers = array();
	var $name = 'Pages';
	var $uses = array();
	
	function beforeFilter() {
		parent::beforeFilter();
	}
	
	function beforeRender() {
		parent::beforeRender();
	}
	
	function test() {
		
	}
}
?>