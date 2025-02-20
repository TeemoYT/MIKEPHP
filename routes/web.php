<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/Homecontrollers.php';

$router = new Router();
$nameProject = "MIKEPHP";

$router->get('/' . $nameProject . '/', [HomeController::class, 'index']);


$router->get('/' . $nameProject . '/about', function () {
    echo "Giới thiệu";
});

$router->get('/' . $nameProject . '/contact', function () {
    require_once __DIR__ . '/../views/login.php';
});

return $router;
