<?php
namespace App\Components\Layout;

class Head {
    public static function render(string $title): string {
        return "<!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
            <title>{$title} - FastStok</title>
            
            <!-- Tailwind CSS
            <script src='https://cdn.tailwindcss.com'></script>
             -->
            
            <base href='/test/faststok/'>


            <!-- Custom styles -->
            <link rel='stylesheet' href='/test/faststok/public/css/tail.css'>
            
            <!-- Custom JavaScript -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Flash messages
                    const flashMessage = document.getElementById('flash-message');
                    if (flashMessage) {
                        setTimeout(() => {
                            flashMessage.style.opacity = '0';
                            setTimeout(() => flashMessage.remove(), 300);
                        }, 5000);
                    }
                });
            </script>
        </head>";
    }
}