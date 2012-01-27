<?php

require_once 'App/Controller.php';
require_once 'App/Model.php';

class App 
{
	public function __construct($sitemap, $content)
	{
		$model		= new App_Model($sitemap, $content);
		$controller = new App_Controller($model);
	}
}