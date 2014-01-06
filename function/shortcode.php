<?php
add_shortcode( 'getapi', 'getjsonapi_shortcode' );
function getjsonapi_shortcode($atts) {
	$sh_meta = shortcode_atts(
		array(
			'type'=>'cycle',
			'limit'=>'5',
			'url'=>'',
		), $atts);
	
	$type = strtoupper($sh_meta['type']);
	$limit = $sh_meta['limit'];
	$url = $sh_meta['url'];
	switch ($type){
		case "CYCLE":
		  	return getjsonapi_cycle($limit,$url);
		break;
		case "LIST":
		  	return getjsonapi_list($limit,$url);
		break;
		default:
			return __("Invalid Shortcode","getjsonapi");
	}
}