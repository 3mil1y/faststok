<?php
require_once "../app/core/autoloader.php"; // Autoload das classes
require_once "../app/core/Router.php";   // Roteador

use App\Core\DatabaseConfig;
use App\Core\Router;

DatabaseConfig::init();
Router::run();
?>