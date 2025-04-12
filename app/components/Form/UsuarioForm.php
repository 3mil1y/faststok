<?php
namespace App\Components\Form;

use App\Entities\User;

class UserForm extends BaseForm {
    private const CLASSES = [
        'container' => 'max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg',
        'header' => 'mb-8 text-center',
        'title' => 'text-3xl font-bold text-gray-900 mb-2',
        'subtitle' => 'text-gray-600',
        'form' => 'space-y-6',
        'form_group' => 'grid grid-cols-1 md:grid-cols-2 gap-6',
        'input_group' => 'space-y-2',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'select' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'button_group' => 'flex justify-end space-x-4 mt-8',
        'button_primary' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'button_secondary' => 'inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'error' => 'mt-2 text-sm text-red-600'
    ];

    public static function render(string $action, array $params = []): string {
        $user = $params['user'] ?? null;
        $title = $user ? 'Editar Usuário' : 'Novo Usuário';
        $roles = [
            'user' => 'Usuário',
            'admin' => 'Administrador'
        ];

        return "
        <form action='{$action}' method='POST' class='" . self::CLASSES['form'] . "'>
            <h2 class='" . self::CLASSES['title'] . "'>{$title}</h2>

            " . ($user ? "<input type='hidden' name='id' value='{$user->getId()}'>" : "") . "

            <div class='" . self::CLASSES['section'] . "'>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateTextInput('name', 'Nome',
                        $user ? $user->getName() : '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateTextInput('email', 'Email',
                        $user ? $user->getEmail() : '',
                        [
                            'type' => 'email',
                            'required' => true
                        ]
                    ) . "
                    
                    " . self::generateTextInput('password', 'Senha',
                        '',
                        [
                            'type' => 'password',
                            'required' => !$user,
                            'minlength' => '6',
                            'placeholder' => $user ? 'Deixe em branco para manter a senha atual' : ''
                        ]
                    ) . "
                    
                    " . self::generateSelect('role', 'Tipo de Usuário',
                        $roles,
                        $user ? $user->getRole() : 'user',
                        ['required' => true]
                    ) . "
                </div>
            </div>

            <div class='" . self::CLASSES['button_group'] . "'>
                <a href='/user/list' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "'>
                    Cancelar
                </a>
                <button type='submit' 
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    " . ($user ? 'Atualizar' : 'Criar') . " Usuário
                </button>
            </div>
        </form>
        
        <script>
            document.querySelector('form').addEventListener('submit', function(e) {
                const password = document.querySelector('input[name=password]');
                const isEdit = document.querySelector('input[name=id]') !== null;
                
                if (!isEdit && password.value.length < 6) {
                    e.preventDefault();
                    alert('A senha deve ter no mínimo 6 caracteres');
                }
            });
        </script>";
    }
}