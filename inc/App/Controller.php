<?php

require_once 'lib/fz/xml/Controller.php';

class App_Controller extends Fz_XML_Controller 
{
	public function __construct($model)
	{
		// set path for views
		$this->set_view_path(dirname(__FILE__).'/view/');
		
		parent::__construct($model);
	}
	
	 ///////////////////////////////////////////////////////////////////
	// API
	
	public function request($request)
	{
		parent::request($request);
	}
	
	 ///////////////////////////////////////////////////////////////////
	// PRIVATE
}

/* EOF */