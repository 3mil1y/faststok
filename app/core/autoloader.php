<?php
spl_autoload_register(function ($className) {
    // Already loaded classes should be skipped
    if (class_exists($className, false)) {
        return;
    }

    // Convert namespace separators to directory separators
    $className = str_replace('App\\', '', $className);
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    
    // Build the full path
    $filePath = __DIR__ . "/../{$className}.php";

    if (file_exists($filePath)) {
        require_once $filePath;
    } else {
        // echo $caminho."\n";
        throw new Exception("A classe: {$className} não foi encontrada em {$filePath}.");
    }
});