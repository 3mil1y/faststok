<?php
namespace App\Components\Table;

use App\Entities\User;

class UserTable {
    private const CLASSES = [
        'container' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
        'header' => 'sm:flex sm:items-center sm:justify-between mb-6',
        'title' => 'text-2xl font-bold text-gray-900',
        'actions' => 'mt-4 sm:mt-0 flex space-x-3',
        'button_primary' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'table_container' => 'mt-8 flex flex-col',
        'table_wrapper' => '-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8',
        'table_inner' => 'inline-block min-w-full py-2 align-middle md:px-6 lg:px-8',
        'table' => 'min-w-full divide-y divide-gray-300',
        'thead' => 'bg-gray-50',
        'th' => 'py-3.5 px-3 text-left text-sm font-semibold text-gray-900',
        'tbody' => 'divide-y divide-gray-200 bg-white',
        'td' => 'whitespace-nowrap py-4 px-3 text-sm text-gray-500',
        'row_actions' => 'flex items-center space-x-2',
        'action_button' => 'text-sm text-gray-500 hover:text-gray-700',
        'action_button_edit' => 'text-blue-600 hover:text-blue-800',
        'action_button_delete' => 'text-red-600 hover:text-red-800',
        'badge' => 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
        'badge_admin' => 'bg-green-100 text-green-800',
        'badge_user' => 'bg-gray-100 text-gray-800'
    ];

    public static function render(array $users): string {
        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h1 class='" . self::CLASSES['title'] . "'>Lista de Usuários</h1>
                    <div class='" . self::CLASSES['actions'] . "'>
                        <a href='/user/create' class='" . self::CLASSES['button_primary'] . "'>
                            Novo Usuário
                        </a>
                    </div>
                </div>

                <div class='" . self::CLASSES['table_container'] . "'>
                    <div class='" . self::CLASSES['table_wrapper'] . "'>
                        <div class='" . self::CLASSES['table_inner'] . "'>
                            <table class='" . self::CLASSES['table'] . "'>
                                <thead class='" . self::CLASSES['thead'] . "'>
                                    <tr>
                                        <th class='" . self::CLASSES['th'] . "'>Nome</th>
                                        <th class='" . self::CLASSES['th'] . "'>Email</th>
                                        <th class='" . self::CLASSES['th'] . "'>Tipo</th>
                                        <th class='" . self::CLASSES['th'] . "'>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class='" . self::CLASSES['tbody'] . "'>
                                    " . self::generateTableRows($users) . "
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>";
    }

    private static function generateTableRows(array $users): string {
        $rows = '';
        foreach ($users as $user) {
            $roleBadgeClass = $user->isAdmin() ? self::CLASSES['badge_admin'] : self::CLASSES['badge_user'];
            $roleText = $user->isAdmin() ? 'Administrador' : 'Usuário';

            $rows .= "<tr>
                <td class='" . self::CLASSES['td'] . "'>{$user->getName()}</td>
                <td class='" . self::CLASSES['td'] . "'>{$user->getEmail()}</td>
                <td class='" . self::CLASSES['td'] . "'>
                    <span class='" . self::CLASSES['badge'] . " {$roleBadgeClass}'>
                        {$roleText}
                    </span>
                </td>
                <td class='" . self::CLASSES['td'] . "'>
                    <div class='" . self::CLASSES['row_actions'] . "'>
                        <a href='/user/edit/{$user->getId()}' class='" . self::CLASSES['action_button_edit'] . "'>
                            Editar
                        </a>
                        <button onclick='confirmDeleteUser({$user->getId()})' class='" . self::CLASSES['action_button_delete'] . "'>
                            Excluir
                        </button>
                    </div>
                </td>
            </tr>";
        }
        return $rows;
    }
}