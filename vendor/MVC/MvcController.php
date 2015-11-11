<?php
	
	namespace MVC;
 
	Class MvcController extends \Slim\Slim{

	    protected $data;
	 
	    public function __construct(){

	        $config = require "config.php" ;
	        
	        if (isset($config['model'])) {
	            
	            $this->data = $config['model'];
	        }
	        
	        parent::__construct($config);
	    }
	}