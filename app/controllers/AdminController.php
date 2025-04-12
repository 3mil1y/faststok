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

    public function createUser($errorMessage = null) {
        $title = "Lista de Usuários";
        $action = "validations/createUser";
        
        $this->view("createUser", compact("title", "action", "errorMessage"));
    }

    public function editUser($id) {
        $title = "Editar Usuário";
        $action = "validations/editUser/$id";
        $user = UserModel::getById($id);
        
        $this->view("editUser", compact("title", "action", "user"));
    }

    //Decidir forma de implementar essa porra

    // public function deleteUser($id) {
    //     $title = "Deletar Usuário";
    //     $action = "validations/deleteUser/$id";
    //     $user = UserModel::getById($id);
        
    //     $this->view("deleteUser", compact("title", "action", "user"));
    // }
}