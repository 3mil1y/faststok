<?php
spl_autoload_register(function ($nomeClasse) {
    if (class_exists($nomeClasse, false)) {
        return;
    }

    $directory = '../app/';
    $caminho = $directory . str_replace('\\', DIRECTORY_SEPARATOR, $nomeClasse) . '.php';


    if (file_exists($caminho)) {
        include $caminho;
    } else {
        echo $caminho."\n";
        throw new Exception("A classe: {$nomeClasse} não foi encontrada em {$caminho}.");
    }
});