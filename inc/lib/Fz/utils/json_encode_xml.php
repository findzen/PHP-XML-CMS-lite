<?php

require_once 'xml_to_array.php';
require_once 'json_format.php';

function json_encode_xml( $file, $pretty_print = true )
{
	$data 	= xml_to_array( new SimpleXMLElement( file_get_contents( $file ) ) );
	$json	= json_encode( $data );

	return $pretty_print ? json_format( $json ) : $json;
}

/* EOF */