<?php

require_once 'lib/Fz/XML/Model.php';

class App_Model extends Fz_XML_Model 
{
	public function __construct($sitemap_xml_path, $content_xml_path)
	{
		parent::__construct($sitemap_xml_path, $content_xml_path);
	}
	
	  ///////////////////////////////////////////////////////////////////
	// API
	
	public function get_data($params) 
	{
		return parent::get_data($params);
	}
	
	  ///////////////////////////////////////////////////////////////////
	// PRIVATE
}

/* EOF */