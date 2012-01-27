<?php

class Fz_Controller
{
	public $model;
	
	public function __construct($model)
	{
		$this->model = $model;
	}
	
	  ///////////////////////////////////////////////////////////////////
	// API
	
	public function request($params)
	{
		// override
	}
	
	public function render($file, $data)
	{
		if(!file_exists($file))
			$this->abort();
		
		extract($data);
		include $file;
	}
	
	public function redirect($url)
	{
		if(!isset($url))
			$this->abort();
		
		header('Location: '.$url);
	}

	public function abort() 
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
}

/* EOF */