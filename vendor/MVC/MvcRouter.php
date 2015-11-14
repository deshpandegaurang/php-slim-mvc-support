<?php

namespace MVC;

class MvcRouter{

	protected $routes;
	protected $request;

	public function __construct(){

		$env 				= \Slim\Environment::getInstance();
        $this->request  	= new \Slim\Http\Request($env);
        $this->path 		= "";
        $this->route_array  = array();
	}
	
	public function registerRoute( $method , $path , $route_string ){
 
        list($route_string, $method) = array( $route_string , $method );
       
        $func = $this->controllerMethodMap( $route_string );
 
        $r = new \Slim\Route( $path , $func );
        $r->setHttpMethods(strtoupper($method));
 
        $this->path = $r;
    
	}
	protected function controllerMethodMap($route_string){
	 
	    if (strpos($route_string, "@") !== false) {
	        
	        list($class, $route_string) = explode("@", $route_string);
	    }
	 
	    $function = ($route_string != "") ? $route_string : "index";
	 
	    $func = function () use ($class, $function) {

	        $class = '\Controller\\' . $class;
	        
	        $class = new $class();
	 
	        $args = func_get_args();
	 
	        return call_user_func_array(array($class, $function), $args);
	    
		};
	 
	    return $func;
	}

	public function run(){

		$route_array = $this->route_array;
		    
		$not_found = true;

		foreach( $route_array as $key => $value ){
		    
		    $this->registerRoute( $value['method'] , $value['path'] , $value['route_string'] );

		    $url = $this->request->getResourceUri();
		    $method = $this->request->getMethod();
		         
	        if ($this->path->matches($url)) {
	            if ($this->path->supportsHttpMethod($method) || $this->path->supportsHttpMethod("ANY")) {
	                call_user_func_array($this->path->getCallable(), array_values($this->path->getParams()));
	                $not_found = false;
	            }
	        }
	    }

	    if( $not_found ){

	    	$this->throwNotFound();
	    }    	 
	}

	public function register( $method , $path , $route_string ){
		
		$one_route 			 	   = array();
		
		$one_route['method'] 	   = $method;
		$one_route['path'] 		   = $path;
		$one_route['route_string'] = $route_string;

		$this->route_array[] 	   = $one_route;
	}

	public function throwNotFound(){

		echo "not found";
	}

}