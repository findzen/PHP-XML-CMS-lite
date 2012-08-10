<?php

require_once __DIR__ . '/../Controller.php';

class Share_Controller extends Fz_Controller 
{
	private $_path_to_view;
	
	public function __construct($model, $path_to_view)
	{
		$this->_path_to_view = $path_to_view;
		parent::__construct($model);
	}
	
	 ///////////////////////////////////////////////////////////////////
	// API
	
	public function request($params)
	{		
		$id = isset($params['id']) ? $params['id'] : null;
		
		// default to open graph
		if(isset($params['site']) && $params['site'] == 'twitter')
			$data = $this->model->get_twitter_data($id);
		else
			$data = $this->model->get_open_graph_data($id);

		if(!isset($data))
		{
			// nothing found... 404
			$this->abort();
		}
		else if($this->model->user_agent->is_facebook())
		{
			// Facebook will scrape value specified for og:url, so remove this value (even if Object Debugger doesn't like it)
			unset($data['url']);
			
			// render meta tags for Facebook crawler
			$this->render($this->_path_to_view, array('open_graph' => $data));
		}
		else if(!isset($params['site']))
		{
			// if no site is specified, redirect to this share's url
			$this->redirect($data['url']);
		}
		else
		{
			// redirect to share url
			$this->redirect($this->_get_redirect($params['site'], $data, $id));
		}
	}
	
	 ///////////////////////////////////////////////////////////////////
	// PRIVATE
	
	private function _get_redirect($site, $data, $id)
	{
		switch($site)
		{
			case 'facebook':
				return $this->model->get_facebook_url($this->model->get_base_href().'sharer.php?id='.$id);
				break;
				
			case 'twitter':
				return $this->model->get_twitter_url($data['description'], $data['url']);
				break;
				
			default:
				return null;
		}
	}
}

/* EOF */