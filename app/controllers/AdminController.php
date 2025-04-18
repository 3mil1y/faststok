<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;
use App\entities\User;

class AdminController extends Controller {
    public function list($errorMessage = null) {
        $title = "Lista de Usuários";
        $users = UserModel::list() ?? [];
        
        $this->view("userList", compact("title", "users"));
    }

    public function createUser($errorMessage = null) {
        if(self::isPost()){
            if(UserModel::getByLogin(self::input("login")) !== null){
                $errorMessage = "Usuário já cadastrado.";
                $title = "Criação de Usuários";
                $action = "admin/createUser";
                $this->view("createUser", compact("errorMessage", "title", "action"));
                return;
            }

            UserModel::create(new User(self::input("login"), self::input("password"),
                (self::input("role") == null ? "user":"admin")));

            $title = "Lista de Usuários";
            $this->redirect("admin/list", compact("title"));
            return;
        }

        //If we reach here, it means user Creation failed
        $title = "Criação de Usuários";
        $action = "admin/createUser";
        
        $this->view("createUser", compact("title", "action", "errorMessage"));
    }

    public function editUser($id) {
    if(self::isPost()){
        $user = UserModel::getById($id);
        $user->setLogin(self::input("login"));
        $user->setRole(self::input("role"));

        UserModel::update($user);

        $title = "Lista de Usuários";
            $this->redirect("admin/list", compact("title"));
            return;
        }

        //errors neds to be implemented in the view and treated in controller

        $title = "Editar Usuário";
        $action = "admin/editUser/$id";
        $user = UserModel::getById($id);
        
        $this->view("editUser", compact("title", "action", "user"));
    }

    public function deleteUser($id) {
        if(self::isGet()){
            self::redirect("admin/list");
            return;
        }

            //errors neds to be implemented in the view and treated in controller
            try{
            UserModel::delete($id);

            $title = "Lista de Usuários";
            $this->redirect("admin/list", compact("title"));
            return;
            } catch(Exception $e){
                $errorMessage = "Erro ao deletar usuário: " . $e->getMessage();
                $this->view("admin/list", compact("errorMessage"));
                return;
            }
    }

    //Decidir forma de implementar essa porra

    // public function deleteUser($id) {
    //     $title = "Deletar Usuário";
    //     $action = "validations/deleteUser/$id";
    //     $user = UserModel::getById($id);
        
    //     $this->view("deleteUser", compact("title", "action", "user"));
    // }
}