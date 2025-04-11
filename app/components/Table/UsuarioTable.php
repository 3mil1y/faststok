<?php
namespace Components\Table;

class UsuarioTable {
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
        'th' => 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
        'tbody' => 'divide-y divide-gray-200 bg-white',
        'tr' => 'hover:bg-gray-50',
        'td' => 'whitespace-nowrap px-3 py-4 text-sm text-gray-500',
        'actions_cell' => 'whitespace-nowrap px-3 py-4 text-sm text-gray-500',
        'action_button' => 'text-blue-600 hover:text-blue-900 mr-3',
        'delete_button' => 'text-red-600 hover:text-red-900',
        'empty_state' => 'text-center py-12',
        'empty_state_text' => 'text-gray-500 text-sm',
        'badge_admin' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800',
        'badge_user' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800'
    ];

    public static function render(array $usuarios = []): string {
        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h1 class='" . self::CLASSES['title'] . "'>Usuários</h1>
                    <div class='" . self::CLASSES['actions'] . "'>
                        <a href='/usuario/cadastrar' class='" . self::CLASSES['button_primary'] . "'>
                            <svg class='-ml-1 mr-2 h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z' clip-rule='evenodd' />
                            </svg>
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
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Nome</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>E-mail</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Tipo</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class='" . self::CLASSES['tbody'] . "'>" .
                                    self::gerarLinhasTabela($usuarios) . "
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>";
    }

    private static function gerarLinhasTabela(array $usuarios): string {
        if (empty($usuarios)) {
            return "
                <tr>
                    <td colspan='4' class='" . self::CLASSES['empty_state'] . "'>
                        <p class='" . self::CLASSES['empty_state_text'] . "'>Nenhum usuário encontrado</p>
                    </td>
                </tr>";
        }

        $linhas = '';
        foreach ($usuarios as $usuario) {
            $badge_class = $usuario['tipo'] === 'admin' ? self::CLASSES['badge_admin'] : self::CLASSES['badge_user'];
            $badge_text = $usuario['tipo'] === 'admin' ? 'Administrador' : 'Usuário';

            $linhas .= "
                <tr class='" . self::CLASSES['tr'] . "'>
                    <td class='" . self::CLASSES['td'] . "'>{$usuario['nome']}</td>
                    <td class='" . self::CLASSES['td'] . "'>{$usuario['email']}</td>
                    <td class='" . self::CLASSES['td'] . "'>
                        <span class='" . $badge_class . "'>{$badge_text}</span>
                    </td>
                    <td class='" . self::CLASSES['actions_cell'] . "'>
                        <a href='/usuario/editar/{$usuario['id']}' class='" . self::CLASSES['action_button'] . "'>
                            <svg class='h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z' />
                            </svg>
                        </a>
                        <a href='/usuario/excluir/{$usuario['id']}' class='" . self::CLASSES['delete_button'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>
                            <svg class='h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd' />
                            </svg>
                        </a>
                    </td>
                </tr>";
        }
        return $linhas;
    }
} 