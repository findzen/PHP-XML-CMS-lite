<?php

ini_set('log_errors' , '1');
ini_set('error_log' , '../log.txt');
ini_set('display_errors' , '0');

ini_set('include_path', './inc');
require_once 'App.php';

$app = new App('inc/App/data/sitemap.xml', 'inc/App/data/content.xml');

/* EOF */