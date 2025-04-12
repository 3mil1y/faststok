<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;

class AdminController extends Controller {
    public function list($errorMessage = null) {
        $title = "Lista de Usuários";
        $users = UserModel::list() ?? [];
        $this->view("userList", compact("title", "users"));
    }

    public function createUser() {
        $this->view("createUser");
    }
}