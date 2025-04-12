<?php
namespace App\Components\Lists;

use App\Entities\User;

class UserList {
    private const CLASSES = [
        'container' => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6',
        'card' => 'bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300',
        'header' => 'px-4 py-3 bg-gray-50 border-b',
        'title' => 'text-lg font-semibold text-gray-900',
        'body' => 'p-4 space-y-3',
        'info_group' => 'flex justify-between text-sm',
        'label' => 'text-gray-600',
        'value' => 'text-gray-900 font-medium',
        'footer' => 'px-4 py-3 bg-gray-50 border-t flex justify-end space-x-2',
        'button' => 'px-3 py-1 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2',
        'button_primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'button_danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'badge' => 'px-2 py-1 text-xs font-medium rounded-full',
        'badge_admin' => 'bg-purple-100 text-purple-800',
        'badge_user' => 'bg-blue-100 text-blue-800'
    ];

    private static function generateRoleBadge(string $role): string {
        $class = $role === 'admin' ? self::CLASSES['badge_admin'] : self::CLASSES['badge_user'];
        $label = $role === 'admin' ? 'Administrador' : 'Usuário';
        
        return "<span class='" . self::CLASSES['badge'] . " {$class}'>
            {$label}
        </span>";
    }

    private static function generateUserCard(User $user): string {
        return "
        <div class='" . self::CLASSES['card'] . "'>
            <div class='" . self::CLASSES['header'] . "'>
                <h3 class='" . self::CLASSES['title'] . "'>{$user->getName()}</h3>
            </div>
            
            <div class='" . self::CLASSES['body'] . "'>
                <div class='" . self::CLASSES['info_group'] . "'>
                    <span class='" . self::CLASSES['label'] . "'>Tipo:</span>
                    " . self::generateRoleBadge($user->getRole()) . "
                </div>
            </div>
            
            <div class='" . self::CLASSES['footer'] . "'>
                <a href='/user/edit/{$user->getId()}' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    Editar
                </a>
                <button onclick='confirmDeleteUser({$user->getId()})'
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_danger'] . "'>
                    Excluir
                </button>
            </div>
        </div>";
    }

    public static function render(array $users): string {
        if (empty($users)) {
            return "<div class='text-center text-gray-600 py-8'>Nenhum usuário encontrado.</div>";
        }

        $cards = '';
        foreach ($users as $user) {
            $cards .= self::generateUserCard($user);
        }

        return "
        <div class='" . self::CLASSES['container'] . "'>
            {$cards}
        </div>
        <script>
            function confirmDeleteUser(id) {
                if (confirm('Tem certeza que deseja excluir este usuário?')) {
                    window.location.href = '/user/delete/' + id;
                }
            }
        </script>";
    }
}
