<?php

ini_set('include_path', 'inc');

require_once 'App.php';

$app = new App('inc/app/data/sitemap.xml', 'inc/app/data/content.xml');

/* EOF */