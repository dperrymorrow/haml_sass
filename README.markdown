# Haml Sass
## Lets you implement the popular haml sass rendering engine in CI 

Thanks to [Phamlp](http://code.google.com/p/phamlp/) this is available to PHP projects.

**What is Haml & Sass?**  
Haml and Sass have been used in Ruby for sometime to simplify templates (Haml) and make CSS more intelligent, flexible and manageable (Sass); now they come to PHP in PHamlP.

## Configuration -- sparks/haml_sass_/x.x/config/haml_sass.php
Most of the configuration variables are self explanatory.

- The haml parser options can be fully explored here [haml parser options](http://code.google.com/p/phamlp/wiki/HamlOptions)

- The sass parser options can be fully explored here [sass parser options](http://code.google.com/p/phamlp/wiki/SassOptions)

One item that probally needs explanation is the sass\_dir variable. This is where sass will look for sass files that are included into other sass files using the @include operator. This is also the director that the sass\_router will look for your sass files when bypassing Codeigniter entirely with a pre\_system hook should you use that method of loading your sass files.

    $config['sass']['sass_dir'] = APPPATH.'views/sass';	

## Rendering a haml template from your controller

    function haml_test()
	{
		// load the spark (x.x represents the version)
		$this->load->spark( 'haml_sass/x.x');
		// set your data like you would for any view
		$data['server'] = $_SERVER;
		// specify your haml file to render
		$this->haml_sass->parse_haml( 'haml_test.haml', $data );
	}

If you would like the output returned as a string, specify the optional third parameter to true,

    $output = $this->haml_sass->parse_haml( 'haml_test.haml', $data, TRUE );

## Rendering Sass files
There are two ways to render your sass. 

- Simplest way is to render through a controller action, but this goes through the entire CI stack which is not ideal for making a css request.
- The best option is to use the hook that is commented out in the haml\_sass.php config file. This will use a trigger to bypass CI and hit the sass\_router.php file included with this spark. 

## Easiest Example First
    
	// load the spark
	$this->load->spark( 'haml_sass/x.x');
	// parse and output your sass file
	$this->haml_sass->parse_sass( 'sass/sass_test.sass' );
	
## More Advanced (but better performance)
In **sparks/haml\_sass/x.x/config/haml\_sass.php** config file you will find an example hook to paste into your hooks. Place this code snippet into your **application/config/hooks.php** file. 

You must have hooks enabled in your **application/config/config.php** file for this to work.

    $config['enable_hooks'] = TRUE;

Now place the snipped you got from the **haml\_sass.php** config file into your application/config/hooks.php file. Be sure to change 1.0 to whatever the current version of the spark is.

    $hook['pre_system'] = array(
	                                'class'    => 'Sass_router',
	                                'function' => 'check_for_sass',
	                                'filename' => 'sass_router.php',
	                                'filepath' => '../sparks/haml_sass/1.0/libraries',
									'params'=>array()
	                           );

Now you need to specify the router trigger that will fire the sass router to look for a sass file instead of a CI controller/action. In **sparks/haml\_sass/x.x/config/haml\_sass.php** config file you will see the variable router\_trigger, this is the string that will trigger the sass router.

    $config['sass']['router_trigger'] = 'css';

now when you hit your app at http://sparks.local:8888/index.php/css/sass_test.sass your sass router will look for sass_test.sass and render it, if not found it will 404. This is all run before all the overhead of Codeigniter.

When using the sass router method of loading sass, the spark has a helper for you to make your link tags. There is no need to load it, its autoloaded with the spark. It is very similar to the html link\_tag helper method.

     sass_link( $file, $rel='stylesheet', $type='text/css', $media='print' )


- [Log Issues or Suggestions](https://github.com/dperrymorrow/haml_sass/issues)
- [Follow me on Twitter](http://twitter.com/dperrymorrow)
