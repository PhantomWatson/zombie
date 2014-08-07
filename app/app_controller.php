<?php
class AppController extends Controller {
	var $helpers = array(
		'Js' => array('Prototype'),
		'Form'
	);
	var $components = array(
		'RequestHandler',
		'Session',
		'Cookie' => array(
			'time' => '1 year',
			'name' => 'docs_zombie_hoedown',
			'secure' => false,
			'key' => null
		)
	);

	function beforeFilter() {
		/*
		$this->Cookie->name = 'docs_zombie_hoedown';
		$this->Cookie->time = '1 year';
		$this->Cookie->secure = false;
		$this->Cookie->key = null;
		*/
	}

	function beforeRender() {

	}
}
?>