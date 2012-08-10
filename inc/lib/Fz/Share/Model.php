<?php

require_once __DIR__ . '/../Model.php';

class Share_Model extends Fz_Model
{
	const OPEN_GRAPH 	= 'open-graph';
	const TWITTER 		= 'twitter';
	const DEFAULT_ID 	= 'default';
	
	private $_xml;
	
	public function __construct($file) 
	{
		if(!file_exists($file))
			die('File not found'.$file);
		
		$this->_xml = new SimpleXMLElement(file_get_contents($file));
		parent::__construct();
	}
	
	 ///////////////////////////////////////////////////////////////////
	// API
	
	public function get_open_graph_data($id = null) 
	{
		return $this->_get_data(self::OPEN_GRAPH, $id);
	}
	
	public function get_twitter_data($id = null) 
	{
		return $this->_get_data(self::TWITTER, $id);
	}
	
	public function get_facebook_url($url)
	{
		return 'http://facebook.com/sharer.php?u='.urlencode($url);
	}
	
	public function get_twitter_url($text, $url)
	{
		return 'http://twitter.com/intent/tweet?text='.urlencode($text).'&url='.urlencode($url);
	}
	
	 ///////////////////////////////////////////////////////////////////
	// PRIVATE
	
	private function _get_data($type, $id = null) 
	{
		$id 	= isset($id) ? $id : self::DEFAULT_ID;
		$data 	= array();
		
		// xpath
		$xpath = '//*[@id="'.$id.'"]/'.$type;
		$match = $this->_xml->xpath($xpath);
		
		if(!isset($match[0]))
			return null;
		
		foreach($match[0] as $child)
			$data[$child->getName()] = (string) $child[0];
		
		return $data;
	}
}