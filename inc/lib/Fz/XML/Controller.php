<?php

require_once 'lib/Fz/Controller.php';
require_once 'Model.php';

class Fz_XML_Controller extends Fz_Controller 
{
	private $_view_path; 
	
	public function __construct($model)
	{
		parent::__construct($model);
		$this->request($this->model->get_request_params());
	}
	
	  ///////////////////////////////////////////////////////////////////
	// API
	
	public function request($request)
	{
		$data = $this->model->get_data($request);

		if(isset($data['redirect']))
		{
			$this->redirect($data['redirect']);
			return;
		}
		elseif(!isset($data['view']))
		{
			$this->abort();
		}
		
		$this->render($this->_view_path.$data['view'], $data);
	}
	
	public function set_view_path($path)
	{
		$this->_view_path = $path;
	}
}

/* EOF */