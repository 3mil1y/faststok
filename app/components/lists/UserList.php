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
                <h3 class='" . self::CLASSES['title'] . "'>{$user->getLogin()}</h3>
            </div>
            
            <div class='" . self::CLASSES['body'] . "'>
                <div class='" . self::CLASSES['info_group'] . "'>
                    <span class='" . self::CLASSES['label'] . "'>Tipo:</span>
                    " . self::generateRoleBadge($user->getRole()) . "
                </div>
            </div>
            
            <div class='" . self::CLASSES['footer'] . "'>
                <a href='admin/editUser/{$user->getId()}' 
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
        <div id='deleteUserPopup' class='hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40'>
            <div class='fixed inset-0 z-50 overflow-y-auto'>
                <div class='flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0'>
                    <div class='relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg'>
                        <div class='bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4'>
                            <div class='sm:flex sm:items-start'>
                                <div class='mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10'>
                                    <svg class='h-6 w-6 text-red-600' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/>
                                    </svg>
                                </div>
                                <div class='mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left'>
                                    <h3 class='text-lg font-medium leading-6 text-gray-900'>Excluir Usuário</h3>
                                    <div class='mt-2'>
                                        <p class='text-sm text-gray-500'>Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id='deleteUserForm' method='POST' class='bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6'>
                            <input type='hidden' name='userId' id='deleteUserId'>
                            <button type='submit' class='" . self::CLASSES['button'] . " " . self::CLASSES['button_danger'] . "'>
                                Excluir
                            </button>
                            <button type='button' onclick='hideDeleteUserPopup()' class='" . self::CLASSES['button'] . " bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3'>
                                Cancelar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function confirmDeleteUser(id) {
                document.getElementById('deleteUserId').value = id;
                document.getElementById('deleteUserPopup').classList.remove('hidden');
                document.getElementById('deleteUserForm').action = 'admin/deleteUser/' + id;
                document.body.style.overflow = 'hidden';
            }

            function hideDeleteUserPopup() {
                document.getElementById('deleteUserPopup').classList.add('hidden');
                document.body.style.overflow = '';
            }
        </script>";
    }
}
