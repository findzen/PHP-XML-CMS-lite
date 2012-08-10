<?php

ini_set('log_errors', '1');
ini_set('display_errors', '0');
ini_set('include_path', '../inc');

require_once 'lib/fz/Share.php';

$share = new Fz_Share( __DIR__.'/content.xml', __DIR__.'/template.phtml');

/* EOF */