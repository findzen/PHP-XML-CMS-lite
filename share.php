<?php

ini_set('log_errors', '1');
ini_set('display_errors', '0');
ini_set('include_path', './inc');

require_once 'inc/Share.php';

$share = new Share('inc/App/data/share.xml', 'App/view/share.phtml');

/* EOF */