<?php

require_once 'UserAgent.php';

class Fz_Model
{
	public $user_agent;
	
	public function __construct() 
	{
		$this->user_agent = new Fz_UserAgent();
	}
	
	 ///////////////////////////////////////////////////////////////////
	// API
	
	public function get_href()
	{
		return $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	
	public function get_base_href()
	{
		$href = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		
		// add trailing slash if necessary
		if(substr($href, -1) != '/')
			$href .= '/';
		
		return $href;
	}
	
	public function get_request()
	{	
		$dir = dirname($_SERVER['PHP_SELF']);

		if($dir === '/')
		{
			// remove leading /
			$request = substr($_SERVER['REQUEST_URI'], 1);
		}
		else
		{
			// remove current directory from request uri
			$request = str_replace($dir.'/', '', $_SERVER['REQUEST_URI']);
		}
		
		return $request;
	}
	
	public function get_request_params($include_query_string = false)
	{
		$request = $this->get_request();
		
		if( !$include_query_string )
		{
			$request = preg_replace('/\?.*/', '', $request);
		}
		
		// split by '/'
		return explode('/', $request);
	}
	
	public function is_ajax_request()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}
	
	public function is_valid_string($val) 
	{
		return isset($val) && $val && $val != 'null' & $val != '';
	}
	
	public function sanitize_string($dirty)
	{
		return htmlentities($dirty, ENT_QUOTES);
	}
}

/* EOF */