<?php
require_once "../app/core/autoloader.php"; // Autoload das classes

use App\Core\Database\DatabaseConfig;
use App\Core\Router;
use App\Core\Middleware\AuthMiddleware;
use App\Core\Middleware\RoleMiddleware;

// Register the middlewares
Router::addMiddleware(AuthMiddleware::class);
Router::addMiddleware(RoleMiddleware::class);

// DatabaseConfig::init();
Router::run();
?>