<?php

require_once 'lib/Fz/Share/Model.php';
require_once 'lib/Fz/Share/Controller.php';

class Share
{
	public function __construct($path_to_share_xml, $path_to_share_view)
	{
		$model		= new Share_Model($path_to_share_xml);
		$controller = new Share_Controller($model, $path_to_share_view);
		$controller->request($_GET);
	}
}