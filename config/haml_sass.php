<?php
if (! defined('BASEPATH')) exit('No direct script access');

/**
* location for the cached haml files
* no trailing slashes on any of the paths please !!!!!!
*/
$config['haml']['cache_dir'] = APPPATH.'cache/haml_cache';
/**
* haml parser options, please see 
* @link http://code.google.com/p/phamlp/wiki/HamlOptions 
* for complete list of options supported
*/
$config['haml']['parser_options'] = array( 	'style'=>'expanded', 
											'ugly'=>false,
											'escapeHtml'=>true,
											'style'=>'expanded',
											'format'=>'html5',
											'preserve'=>array('div','p')
										);
/**
* where the sass_router should look for your sass files
*/
$config['sass']['sass_dir'] = APPPATH.'views/sass';	
																	
/**
* location for the cached sass files
*/											
$config['sass']['cache_dir'] = APPPATH.'cache/haml_cache';									
/**
* sass parser options, please see 
* @link http://code.google.com/p/phamlp/wiki/SassOptions
* for complete list of options supported
*/
$config['sass']['parser_options'] = array( 	'cache'=>TRUE,
											// leave this blank
											'filename'=>array(),
											// location to cache the files to
											'cache_location'=>APPPATH.'cache/sass_cache',
											// where to write the compiled css to
											//'css_location'=>APPPATH.'cache/saas_cache',
											'template_location'=> APPPATH.'views/sass',
											'load_paths'=>array( APPPATH.'views/saas')
											);
											
/**
* to configure the sass parsing without going through the entire CI stack
* you must enable a pre_system hook
* learn more about hooks here
* @link http://codeigniter.com/user_guide/general/hooks.html
* you must set $config['enable_hooks'] = TRUE; in your application/config/config.php as well 
*/

/**
* the word that triggers the sass router
* be carefull, use something that you wont want as a controller action
*/
$config['sass']['router_trigger'] = 'css';


/**
* You must have hooks enabled in your **application/config/config.php** file for this to work.
* $config['enable_hooks'] = TRUE;
* Now place the snipped you got from the **haml\_sass.php** config file into your application/config/hooks.php file. Be sure to change 1.0 to whatever the current version of the spark is.
*
$hook['pre_system'] = array(
                                'class'    => 'Sass_router',
                                'function' => 'check_for_sass',
                                'filename' => 'sass_router.php',
                                'filepath' => '../sparks/haml_sass/1.0/libraries',
								'params'=>array()
                           );
*/
