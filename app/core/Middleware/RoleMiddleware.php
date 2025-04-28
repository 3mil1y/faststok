<?php
namespace App\Core\Middleware;

use App\Core\Middleware;
use App\Core\SessionManager;

class RoleMiddleware implements Middleware {
    private $adminOnlyRoutes = [
        '/faststok/admin/list',
        '/faststok/admin/createUser',
        '/faststok/admin/editUser',
        '/faststok/product/deleteByStock',
    ];
    public function handle() {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Check if the current route requires admin privileges
        if (in_array($currentPath, $this->adminOnlyRoutes)) {
            if (!SessionManager::isAuthenticated()) {
                header('Location: /faststok/user/login');
                exit();
            }
            
            if (!SessionManager::isAdmin()) {
                header('Location: /faststok/product/home');
                exit();
            }
        }
    }
}