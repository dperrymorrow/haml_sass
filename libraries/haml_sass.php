<?php

if (! defined('BASEPATH')) exit('No direct script access');

class Haml_sass{

	
	public $haml_parser = null;
	public $haml_settings = array();
	public $saas_settings = array();
	public $haml_cache = '';
	public $sass_cache = '';
	//php 5 constructor
	function __construct() {
		
		if( !defined('HAML_SASS_ROOT'))
		{
			define('HAML_SASS_ROOT', dirname(__DIR__));
		}
		
		$this->CI = &get_instance();
		$vendor_path = HAML_SASS_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR;
		
		require_once( $vendor_path.'haml'.DIRECTORY_SEPARATOR.'HamlParser.php' );
		require_once( $vendor_path.'sass'.DIRECTORY_SEPARATOR.'SassParser.php' );
		
		$this->haml_settings = $this->CI->config->item('haml');
		$this->sass_settings = $this->CI->config->item('sass');
		
		$this->haml_cache = $this->haml_settings['cache_dir'];
		$this->sass_cache = $this->sass_settings['cache_dir'];
		
		$this->haml_parser = new HamlParser( $this->haml_settings['parser_options'] );
		$this->sass_parser = new SassParser( $this->sass_settings['parser_options'] );
		$this->_setup_cache();
	}
	
	protected function _setup_cache()
	{
		
		if( !is_dir( $this->haml_cache ))
		{
			if( !mkdir( $this->haml_cache, DIR_READ_MODE ))
			{
				show_error( 'Haml_Saas Spark could not create the cache dir for Haml in ' . $this->haml_cache . '. <strong>Please make sure that application cache dir is writable 0755 should be sufficient.</strong>' );
			}
		}
		
		if( !is_dir( $this->sass_cache ))
		{
			if( !mkdir( $this->sass_cache, DIR_READ_MODE ))
			{
				show_error( 'Haml_Saas Spark could not create the cache dir for Saas in ' . $this->sass_cache . '. <strong>Please make sure that application cache dir is writable 0755 should be sufficient.</strong>' );
			}
		}
		
	}
	
	
	public function parse_sass( $file )
	{
		
		$file = $this->CI->load->_ci_view_path . $file;
		$this->CI->output->set_header("Content-type:text/css");
		$this->CI->output->set_output( $this->sass_parser->toCss( $file, TRUE ));
	}
	
	public function parse_haml( $file, $data, $return=FALSE )
	{
		// ... save the original view path, and set to our Foo Bar package view folder
		$orig_view_path = $this->CI->load->_ci_view_path;
		$this->CI->load->_ci_view_path = $this->haml_cache . DIRECTORY_SEPARATOR;
		// ... then return the view path to the application's original view path

		$php_file = $this->haml_parser->parse( APPPATH."views".DIRECTORY_SEPARATOR."$file", $this->haml_cache, 0755, '.haml', '.php' );
		$arr = explode( '/', $php_file );
		$php_file = $arr[ count( $arr ) -1  ];
		
		$output = $this->CI->load->view( $php_file, $data, TRUE );
		$this->CI->load->_ci_view_path = $orig_view_path;
		
		if( $return)
		{
			return $output;
		}
		else
		{
			$this->CI->output->set_output($output);
		}
	}
	

}