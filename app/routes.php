<?php

$app->router->register( 'GET' , '/test' , 'MainController@test' );

$app->router->register( 'GET' , '/test/:variable' , 'MainController@testVariable' );

 
