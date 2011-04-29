<?php
if (! defined('BASEPATH')) exit('No direct script access');

class Sass_router{
	
	public $config = array();
	
	public function __construct()
	{
		define('HAML_SASS_ROOT', dirname(__DIR__));
		require_once( HAML_SASS_ROOT . '/config/haml_sass.php' );
		$this->config = $config[ 'sass' ];
	}
	
	public function check_for_sass()
	{
		
		$request = ( $_SERVER['REQUEST_URI']);
		if( strpos( $request, "/".$this->config['router_trigger']."/" ))
		{
			list($uri, $sass_file ) = explode( '/'.$this->config['router_trigger'].'/', $request );
			
			$sass_file = $this->config['sass_dir'].'/'.$sass_file;
			$sass_file = str_replace( '//', '/', $sass_file );
			$sass_file = str_replace( '.css', '.sass', $sass_file );
			
			if( file_exists( $sass_file ))
			{
				$this->load_sass_file( $sass_file );
			}
			else
			{
				show_404();
			}
		}
	}
	
	public function load_sass_file( $file )
	{
		
		require_once( HAML_SASS_ROOT . '/vendor/sass/SassParser.php' );
		$this->_check_cache();
		
		header("Content-Type: text/css");
		header("Expires: " . gmdate("D, j M Y H:i:s", time() + time('d')) . " GMT");
		header("Cache-Control: cache"); // HTTP/1.1
		header("Pragma: cache");        // HTTP/1.0
		
		$parser = new SassParser( $this->config[ 'parser_options']);
		echo $parser->toCss( $file );
		exit();
	}
	
	protected function _check_cache()
	{
		
		if( !is_dir( $this->config['cache_dir'] ))
		{
			if( !mkdir( $this->config['cache_dir'], DIR_READ_MODE ))
			{
				show_error( 'Haml_Saas Spark could not create the cache dir for Saas in ' . $this->config['cache_dir'] . '. <strong>Please make sure that application cache dir is writable 0755 should be sufficient.</strong>' );
			}
		}
		
	}
	
} // end Sass_router