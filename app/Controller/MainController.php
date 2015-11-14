<?php
 
namespace Controller;
 
Class MainController extends \MVC\MvcController{

    public function index(){

        echo $this->data->message;
    }
 
    public function test(){

        echo "Test Page";
    }

    public function testVariable( $variable ){

        echo $variable;
    }
}