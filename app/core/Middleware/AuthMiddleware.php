<?php
namespace App\Core\Middleware;

use App\Core\Middleware;
use App\Core\SessionManager;

class AuthMiddleware implements Middleware {
    private $publicRoutes = [
        '/test/faststok/user/login',
        '/test/faststok/validations/login',
    ];

    public function handle() {
        // Get current URL path
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Check if current path is in public routes
        if (in_array($currentPath, $this->publicRoutes)) {
            return;
        }

        // Check if user is authenticated
        if (!SessionManager::isAuthenticated()) {
            header('Location: /test/faststok/user/login');
            exit();
        }
    }
}