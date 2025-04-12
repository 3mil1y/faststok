<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;

class UserController extends Controller {
    public function login($errorMessage = null) {
        $title = "Login";
        $error = ($errorMessage === 'invalidCredentials') ? 'E-mail ou senha incorretos, por favor tente novamente!' : null;
        $this->view("login", compact("title", "error"));
    }
}