<?php



require 'resolver.php';

$app = new Resolver;

require 'app/routes.php';

$app->router->run();
