<?php
namespace App\Components\Form;

use App\entities\User;

class EditUser{
    protected const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'title' => 'text-3xl font-semibold text-center mb-6',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'input_readonly' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md bg-gray-200',
        'select' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'grid' => 'grid grid-cols-2 gap-4',
        'button' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'
    ];

    private static function generateInputField(string $id, string $label, string $value, bool $readonly = false): string {
        $class = $readonly ? self::CLASSES['input_readonly'] : self::CLASSES['input'];
        
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <input type='text' id='{$id}' name='{$id}' value='{$value}'" . 
            ($readonly ? ' readonly' : ' required') . 
            " class='{$class}'>
        </div>";
    }

    private static function generateSelectField(string $id, string $label, string $selectedValue): string {
        $options = [
            'admin' => 'Admin',
            'usuario' => 'Usuário'
        ];
        
        $optionsHtml = '';
        foreach ($options as $value => $text) {
            $selected = ($selectedValue === $value) ? ' selected' : '';
            $optionsHtml .= "<option value='{$value}'{$selected}>{$text}</option>";
        }
        
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$optionsHtml}
            </select>
        </div>";
    }

    public static function render(string $action, User $user = null): string {
        $login = $user ? $user->getLogin() : '';
        $id = $user ? $user->getId() : '';
        $role = $user ? $user->getRole() : '';

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['title'] . "'>Altere um Usuário</h1>
            
            " . self::generateInputField('login', 'Login', $login) . "
            
            <div class='" . self::CLASSES['grid'] . "'>
                " . self::generateInputField('id', 'ID', $id, true) . "
                " . self::generateSelectField('role', 'Permissão', $role) . "
            </div>
            
            <button type='submit' class='" . self::CLASSES['button'] . "'>Salvar Usuário</button>
        </form>";
    }
}
