<?php
namespace App\Components\Layout;

use App\Core\SessionManager;

class Header {
    private const CLASSES = [
        'header' => 'bg-gradient-to-r from-gray-800 to-gray-900 text-white p-4 shadow-md',
        'header_container' => 'max-w-7xl mx-auto flex justify-between items-center flex-wrap',
        'logo_container' => 'flex items-center mb-4 md:mb-0',
        'logo_text' => 'text-xl font-bold flex items-center',
        'logo_icon' => 'mx-auto h-12 w-auto text-blue-600',
        'nav_container' => 'w-full md:w-auto flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-4',
        'dropdown_container' => 'relative w-full md:w-auto',
        'dropdown_button' => 'flex items-center justify-between w-full md:w-auto px-4 py-2 text-white rounded-md transition-colors duration-200',
        'dropdown_menu' => 'absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg hidden z-50',
        'dropdown_item' => 'block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors duration-200',
        'mobile_menu_button' => 'md:hidden text-white p-2 rounded-md hover:bg-gray-700 transition-colors duration-200',
        'mobile_menu' => 'md:hidden w-full bg-gray-800 mt-2 rounded-md shadow-lg hidden',
        'mobile_menu_item' => 'block px-4 py-2 text-white hover:bg-gray-700 transition-colors duration-200'
    ];

    private const BUTTON_STYLES = [
        'admin' => 'text-white px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 transition-colors duration-200 shadow-sm',
        'enderecamento' => 'text-white px-4 py-2 rounded-md bg-purple-600 hover:bg-purple-700 transition-colors duration-200 shadow-sm',
        'relatorios' => 'text-white px-4 py-2 rounded-md bg-green-600 hover:bg-green-700 transition-colors duration-200 shadow-sm',
        'transfers' => 'text-white px-4 py-2 rounded-md bg-yellow-600 hover:bg-yellow-700 transition-colors duration-200 shadow-sm',
        'usuario' => 'text-white px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 transition-colors duration-200 shadow-sm'
    ];

    private static function generateLogo(): string {
        return "
            <div class='" . self::CLASSES['logo_container'] . "'>
                <div class='" . self::CLASSES['logo_text'] . "'>
                <a href='product/home'>
                   <svg class='" . self::CLASSES['logo_icon'] . "' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'/>
                    </svg>
                    </a>
                    <a href='product/home'>
                    <span>FastStok</span>
                    
                </a>
                </div>
            </div>";
    }

    private static function generateDropdowns($role): string {
        $adminMenu = ($role === 'admin') ? "
            <div class='" . self::CLASSES['dropdown_container'] . "'>
                <button onclick='toggleDropdown(\"adminDropdown\")' class='" . self::CLASSES['dropdown_button'] . " bg-blue-600 hover:bg-blue-700'>
                    Admin
                </button>
                <div id='adminDropdown' class='" . self::CLASSES['dropdown_menu'] . "'>
                    <a href='admin/list' class='" . self::CLASSES['dropdown_item'] . "'>Listar Usuários</a>
                    <a href='admin/createUser' class='" . self::CLASSES['dropdown_item'] . "'>Adicionar Usuário</a>
                </div>
            </div>" : "";

        return "
            <div class='hidden md:flex items-center space-x-4'>
                <!-- Endereçamento Dropdown -->
                <div class='" . self::CLASSES['dropdown_container'] . "'>
                    <button onclick='toggleDropdown(\"enderecamentoDropdown\")' class='" . self::CLASSES['dropdown_button'] . " bg-purple-600 hover:bg-purple-700'>
                        Endereçamento
                    </button>
                    <div id='enderecamentoDropdown' class='" . self::CLASSES['dropdown_menu'] . "'>
                        <a href='product/home' class='" . self::CLASSES['dropdown_item'] . "'>Listar Produto</a>
                        <a href='product/search' class='" . self::CLASSES['dropdown_item'] . "'>Buscar Produto</a>
                        <a href='product/create' class='" . self::CLASSES['dropdown_item'] . "'>Endereçar Produto</a>
                        <a href='product/continueCreate' class='" . self::CLASSES['dropdown_item'] . "'>Endereçamento Continuo de Produto</a>
                    </div>
                </div>

                <!-- Relatórios Dropdown -->
                <div class='" . self::CLASSES['dropdown_container'] . "'>
                    <button onclick='toggleDropdown(\"relatoriosDropdown\")' class='" . self::CLASSES['dropdown_button'] . " bg-green-600 hover:bg-green-700'>
                        Relatórios
                    </button>
                    <div id='relatoriosDropdown' class='" . self::CLASSES['dropdown_menu'] . "'>
                        <a href='report/expiry' class='" . self::CLASSES['dropdown_item'] . "'>Validade</a>
                        <a href='report/stock' class='" . self::CLASSES['dropdown_item'] . "'>Baixo Estoque</a>
                    </div>
                </div>

                <!-- Transferências Dropdown -->
                <div class='" . self::CLASSES['dropdown_container'] . "'>
                    <button onclick='toggleDropdown(\"transfersDropdown\")' class='" . self::CLASSES['dropdown_button'] . " bg-yellow-600 hover:bg-yellow-700'>
                        Transferências
                    </button>
                    <div id='transfersDropdown' class='" . self::CLASSES['dropdown_menu'] . "'>
                        <a href='transfer/internal' class='" . self::CLASSES['dropdown_item'] . "'>Internas</a>
                        <a href='transfer/external' class='" . self::CLASSES['dropdown_item'] . "'>Saída</a>
                        <a href='transfer/continueInternal' class='" . self::CLASSES['dropdown_item'] . "'>Interna Contínua</a>
                        <a href='transfer/continueExternal' class='" . self::CLASSES['dropdown_item'] . "'>Saída Contínua</a>
                    </div>
                </div>
                " . $adminMenu . "
                <!-- Usuário Dropdown -->
                <div class='" . self::CLASSES['dropdown_container'] . "'>
                    <button onclick='toggleDropdown(\"usuarioDropdown\")' class='" . self::CLASSES['dropdown_button'] . " bg-blue-600 hover:bg-blue-700'>
                        Usuário
                    </button>
                    <div id='usuarioDropdown' class='" . self::CLASSES['dropdown_menu'] . "'>
                        <a href='user/logout' class='" . self::CLASSES['dropdown_item'] . "'>Sair</a>
                    </div>
                </div>
            </div>

            <script>
                function toggleDropdown(id) {
                    const dropdown = document.getElementById(id);
                    const allDropdowns = document.querySelectorAll('." . self::CLASSES['dropdown_menu'] . "');
                    
                    allDropdowns.forEach(menu => {
                        if (menu.id !== id) {
                            menu.classList.add('hidden');
                        }
                    });
                    
                    dropdown.classList.toggle('hidden');
                }

                // Close dropdowns when clicking outside
                document.addEventListener('click', function(event) {
                    const dropdowns = document.querySelectorAll('." . self::CLASSES['dropdown_menu'] . "');
                    const dropdownButtons = document.querySelectorAll('." . self::CLASSES['dropdown_button'] . "');
                    
                    if (!event.target.closest('." . self::CLASSES['dropdown_container'] . "')) {
                        dropdowns.forEach(dropdown => {
                            dropdown.classList.add('hidden');
                        });
                    }
                });
            </script>";
    }

    private static function generateMobileMenu($role): string {

        $adminMenu = ($role === 'admin') ? "
                <a href='/admin/list' class='" . self::CLASSES['mobile_menu_item'] . "'>Listar Usuários</a>
                <a href='/admin/createUser' class='" . self::CLASSES['mobile_menu_item'] . "'>Adicionar Usuário</a>" : "";

        return "
            <button id='mobile-menu-button' class='" . self::CLASSES['mobile_menu_button'] . "' aria-label='Menu'>
                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                    <line x1='3' y1='12' x2='21' y2='12'></line>
                    <line x1='3' y1='6' x2='21' y2='6'></line>
                    <line x1='3' y1='18' x2='21' y2='18'></line>
                </svg>
            </button>
            <div id='mobile-menu' class='" . self::CLASSES['mobile_menu'] . "'>
                <a href='/product/home' class='" . self::CLASSES['mobile_menu_item'] . "'>Home</a>
                <a href='/product/search' class='" . self::CLASSES['mobile_menu_item'] . "'>Produtos</a>
                <a href='/product/create' class='" . self::CLASSES['mobile_menu_item'] . "'>Endereçar Produto</a>
                <a href='/product/continueCreate' class='" . self::CLASSES['mobile_menu_item'] . "'>Endereçamento Continuo de Produto</a>
                <a href='/product/search' class='" . self::CLASSES['mobile_menu_item'] . "'>Pesquisar</a>
                <a href='/report/expiry' class='" . self::CLASSES['mobile_menu_item'] . "'>Relatório de Validade</a>
                <a href='/report/stock' class='" . self::CLASSES['mobile_menu_item'] . "'>Relatório de Estoque</a>
                <a href='/transfer/internal' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferências Internas</a>
                <a href='/transfer/external' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferências de Saída</a>
                <a href='/transfer/continueInternal' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferência Interna Contínua</a>
                <a href='/transfer/continueExternal' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferência de Saída Contínua</a>  
                " . $adminMenu . "
                <a href='/user/logout' class='" . self::CLASSES['mobile_menu_item'] . "'>Sair</a>
            </div>
            <script>
                document.getElementById('mobile-menu-button').addEventListener('click', function() {
                    document.getElementById('mobile-menu').classList.toggle('hidden');
                });
            </script>";
    }

    public static function render(): string {
        $role = (!SessionManager::isAdmin()) ? 'user' : 'admin';

        return "
            <header class='" . self::CLASSES['header'] . "'>
                <div class='" . self::CLASSES['header_container'] . "'>
                    " . self::generateLogo() . "
                    " . self::generateMobileMenu($role) . "
                    " . self::generateDropdowns($role) . "
                </div>
            </header>";
    }
}

// namespace Components;

// class Cabecalho {

//     public static function exibirCabecalho(bool $isAdmin = false): string {
//         $adminButton = $isAdmin ? "
//             <div class='relative'>
//                 <button class='text-white px-4 py-2 rounded bg-blue-600 hover:bg-blue-700' onclick='toggleDropdown(\"adminDropdown\")'>
//                     Alterações
//                 </button>
//                 <div id='adminDropdown' class='absolute right-0 mt-2 w-24 bg-white border rounded-md shadow-lg hidden z-50'>
//                     <a href='usuarios/lista.php' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Listar Usuários</a>
//                     <a href='usuarios/cadastro.php' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Adicionar Usuário</a>
//                 </div>
//             </div>
//         " : "";

//         return "
//         <header class='bg-gray-800 text-white p-4 flex justify-between items-center flex-wrap'>
//             <div class='flex items-center mb-4 md:mb-0'>
//                 <div class='text-xl font-bold flex items-center'>
//                      <span class='mr-2'>
//                             <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
//                                 <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5h18M3 5a2 2 0 012-2h14a2 2 0 012 2M3 5a2 2 0 012 2v12a2 2 0 012 2h12a2 2 0 012-2V7a2 2 0 012-2' />
//                             </svg>
//                         </span>
//                     <a href='produto/listar'>   
//                         FastStok
//                     </a>
//                 </div>
//             </div>
//             <div class='flex items-center space-x-4 flex-wrap md:flex-nowrap'>
//                 <!-- Endereçamento Dropdown -->
//                 <div class='relative'>
//                     <button class='text-white px-4 py-2 rounded bg-purple-600 hover:bg-purple-700' onclick='toggleDropdown(\"enderecamentoDropdown\")'>
//                         Endereçamento
//                     </button>
//                     <div id='enderecamentoDropdown' class='absolute right-0 mt-2 w-24 bg-white border rounded-md shadow-lg hidden z-50'>
//                         <a href='produto/pesquisar' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Buscar Endereços</a>
//                         <a href='produto/cadastrar' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Endereçar Produto</a>
//                     </div>
//                 </div>
//                 <!-- Relatórios Dropdown -->
//                 <div class='relative'>
//                     <button class='text-white px-4 py-2 rounded bg-green-600 hover:bg-green-700' onclick='toggleDropdown(\"relatoriosDropdown\")'>
//                         Relatórios
//                     </button>
//                     <div id='relatoriosDropdown' class='absolute right-0 mt-2 w-24 bg-white border rounded-md shadow-lg hidden z-50'>
//                         <a href='relatorio/validade' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Validade</a>
//                         <a href='relatorio/estoque' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Baixo Estoque</a>
//                     </div>
//                 </div>
//                 <!-- Transferências Dropdown -->
//                 <div class='relative'>
//                     <button class='text-white px-4 py-2 rounded bg-yellow-600 hover:bg-yellow-700' onclick='toggleDropdown(\"transferenciasDropdown\")'>
//                         Transferências
//                     </button>
//                     <div id='transferenciasDropdown' class='absolute right-0 mt-2 w-24 bg-white border rounded-md shadow-lg hidden z-50'>
//                         <a href='transferencia/interna' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Internas</a>
//                         <a href='transferencia/saida' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Saída</a>
//                     </div>
//                 </div>
//                 $adminButton
//                 <!-- Usuário Dropdown -->
//                 <div class='relative'>
//                     <button class='text-white px-4 py-2 rounded bg-blue-600 hover:bg-blue-700' onclick='toggleDropdown(\"usuarioDropdown\")'>
//                         Usuário
//                     </button>
//                     <div id='usuarioDropdown' class='absolute right-0 mt-2 w-24 bg-white border rounded-md shadow-lg hidden z-50'>
//                         <a href='validacoes/logout.php' class='block px-4 py-2 text-gray-800 hover:bg-gray-200'>Logout</a>
//                     </div>
//                 </div>
//             </div>
//         </header>

//         <script>
//             function toggleDropdown(id) {
//                 const dropdown = document.getElementById(id);
//                 dropdown.classList.toggle('hidden');
//             }
//         </script>
//         ";
//     }
// }


?>

