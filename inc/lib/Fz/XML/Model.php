<?php

require_once 'lib/Fz/Model.php';
require_once 'lib/Fz/utils/simpleXMLToArray.php';

class Fz_XML_Model extends Fz_Model
{
	private $_sitemap_xml;
	private $_content_xml;
	
	public function __construct($sitemap_xml_path, $content_xml_path)
	{
		if(!file_exists($sitemap_xml_path) || !file_exists($content_xml_path))
			die('File not found');
		
		$this->_sitemap_xml = new SimpleXMLElement(file_get_contents($sitemap_xml_path));
		$this->_content_xml = new SimpleXMLElement(file_get_contents($content_xml_path));
		
		parent::__construct();
	}
	
	  ///////////////////////////////////////////////////////////////////
	// API
	
	public function get_data($params) 
	{
		if($params[0] == '')
			$params[0] = '/';
		
		$match = $this->_get_sitemap_match($params);
		
		if(!isset($match))
			return null;
		
		if(isset($match->attributes()->redirect))
			return array('redirect' => 'http://'.$this->get_base_href().$match->attributes()->redirect);
		
		$id 	= $match->attributes()->id;
		$data 	= $this->_get_data($id);
		
		if(!isset($data))
			return null;

		$data['base_href'] 	= $this->get_base_href();
		$data['href'] 		= $this->get_href();
		$data['ajax']		= $this->is_ajax_request();
		$data['global']		= $this->_get_global_data();
		$data['nav'] 		= $this->_get_nav();
		
		return $data;
	}
	
	  ///////////////////////////////////////////////////////////////////
	// PRIVATE
	
	private function _get_nav()
	{
		$match 	= $this->_sitemap_xml->xpath('/*');
		$data 	= simpleXMLToArray($match[0]);
		
		return $this->_parse_href($data['page']);
	}
	
	private function _parse_href(&$nav)
	{
		// for relative urls: if href is root ('/'), make blank. Otherwise add trailing slash
		$href = $nav['href'] === '/' ? '' : $nav['href'].'/';

		if(!isset($nav['page']) || !is_array($nav['page']))
			return $nav;

		// pass reference to child so value is updated in $nav array
		foreach($nav['page'] as &$child)
		{
			$child['href'] = $href.$child['href'];
			
			if(isset($child['page']))
				$this->_parse_href($child);
		}
		
		return $nav;
	}
	
	private function _get_sitemap_match($params)
	{
		$xpath = ($params[0] === '/' && count($params) === 1) ? '/' : '//*[@href="/"]';
		
		foreach($params as $path)
			$xpath .= '/*[@href="'.$path.'"]';
		
		$match = $this->_sitemap_xml->xpath($xpath);
		
		if(!isset($match[0]))
			return null;
		
		return $match[0];
	}
	
	private function _get_data($id) 
	{
		// xpath
		$xpath = '//*[@id="'.$id.'"]';
		$match = $this->_content_xml->xpath($xpath);
				
		if(!isset($match[0]))
			return null;
	
		return simpleXMLToArray($match[0]);
	}
	
	private function _get_global_data() 
	{
		// xpath
		$xpath = '//global';
		$match = $this->_content_xml->xpath($xpath);
				
		if(!isset($match[0]))
			return null;
	
		return simpleXMLToArray($match[0]);
	}
	
}

/* EOF */