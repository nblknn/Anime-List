<?php

declare (strict_types = 1);

require_once __DIR__ . '/Router.php';

$router = new Router();
echo $router->route();
