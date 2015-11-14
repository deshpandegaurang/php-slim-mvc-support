<?php

$app->router->run( 'GET' , '/test' , 'MainController@test' );

$app->router->run( 'GET' , '/test/:variable' , 'MainController@testVariable' );

 
