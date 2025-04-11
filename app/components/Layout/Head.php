<?php
namespace Components\Layout;

class Head {
    public static function render(string $titulo): string {
        return '<!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>'.$titulo.'</title>

                <base href="/test/">

                <link rel="stylesheet" href="public/css/tail.css">
            </head>
            <body class="bg-gray-200">';
    }
}