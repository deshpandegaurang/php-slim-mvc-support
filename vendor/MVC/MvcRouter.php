<?php

namespace MVC;

class MvcRouter{

	protected $routes;
	protected $request;

	public function __construct(){

		$env = \Slim\Environment::getInstance();
        $this->request = new \Slim\Http\Request($env);
        $this->path = "";


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

	public function run( $method , $path , $route_string ){

	    $not_found = true;
	    
	    $this->registerRoute( $method , $path , $route_string );

	    $url = $this->request->getResourceUri();
	    $method = $this->request->getMethod();
	         
        if ($this->path->matches($url)) {
            if ($this->path->supportsHttpMethod($method) || $this->path->supportsHttpMethod("ANY")) {
                call_user_func_array($this->path->getCallable(), array_values($this->path->getParams()));
                $not_found = false;
            }
        }
    	 
	    if ($not_found) {
	        echo "404 - route not found";
	    }
	}
}