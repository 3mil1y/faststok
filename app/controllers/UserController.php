<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\SessionManager;
use App\Models\UserModel;

class UserController extends Controller {
    public function login($errorMessage = null) {
        if (SessionManager::isAuthenticated()) {
            $this->redirect("products/home");
            return;
        }

        if(self::isPost()){
            $login = $_POST["login"];
            $password = $_POST["password"];

            if (UserModel::validateLogin($login, $password)) {
                $user = UserModel::getByLogin($login);
                SessionManager::setUser($user);
                $this->redirect("product/home");
                return;
            } else {
                $errorMessage = 'invalidCredentials';
            }
        }

        // If we reach here, it means login failed
        // Show the login form again with an error message
        $title = "Login";
        $error = ($errorMessage === 'invalidCredentials') ? 'Login ou senha incorretos, por favor tente novamente!' : "";
        $action = "user/login";
        $this->view("login", compact("title", "action", "error"));
    }

    public function logout() {
        SessionManager::logout();
        $this->redirect("user/login");
    }
}