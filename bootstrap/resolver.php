<?
require 'vendor/autoload.php';

Class Resolver{

	public $router;
	public $slim;
	
	public function __construct(){

		$this->router = new \MVC\MvcRouter;
		$this->slim   = new \Slim\Slim();
	}
}