<?php
require_once "../app/core/autoloader.php"; // Autoload das classes
require_once "../app/core/Router.php";   // Roteador

use core\dbConfig;

DbConfig::init();
Router::run();
?>