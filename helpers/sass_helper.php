<?php
if (! defined('BASEPATH')) exit('No direct script access');


function sass_link( $file, $rel='stylesheet', $type='text/css', $media='print' )
{
	$CI = &get_instance();
	$prefs = $CI->config->item('sass');
	$router = $prefs['router_trigger'];
	
	
	$link = array(
	          'href' => site_url( "$router/$file" ),
	          'rel' => $rel,
	          'type' => $type,
	          'media' => $media
			);
	
	return link_tag( $link );
	
}




