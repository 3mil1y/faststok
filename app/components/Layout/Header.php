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
        'mobile_menu_button' => 'md:hidden text-white p-3 rounded-md hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400',
        'mobile_menu' => 'md:hidden w-full bg-gray-800 mt-2 rounded-md shadow-lg hidden transition-all duration-300 ease-in-out',
        'mobile_menu_item' => 'block w-full text-left px-5 py-3 text-white text-base font-medium hover:bg-gray-700 transition-colors duration-200 rounded-md',
        'mobile_menu_search_container' => 'w-full px-4 py-3',
        'mobile_menu_search_input' => 'w-full border rounded px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-blue-400',
        'mobile_menu_search_button' => 'w-full mt-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded transition-colors duration-200',
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
                    <a class='sm:block md:hidden lg:block' href='product/home'>
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
                    <a href='product/deleteByStock' class='" . self::CLASSES['dropdown_item'] . "'>Excluir Estoque Baixo</a>
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

    private static function generateSearch(): string {
        return "
            <div class='hidden md:flex items-center space-x-4 text-black'>
                <form action='product/search' method='POST' class='flex items-center'>
                    <input type='hidden' name='searchType' id='searchType' value='barCode'>
                    <input type='text' name='query' id='query' class='border rounded px-2 py-1' placeholder='Insira um Cód. Barras'>
                    <button type='submit' class='bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded'>🔍</button>
                </form>
            </div>";
    }

    private static function generateMobileMenu($role): string {
        $adminMenu = ($role === 'admin') ? "
                <a href='/admin/list' class='" . self::CLASSES['mobile_menu_item'] . "'>Listar Usuários</a>
                <a href='/admin/createUser' class='" . self::CLASSES['mobile_menu_item'] . "'>Adicionar Usuário</a>" : "";
        
        // Mobile search form
        $mobileSearch = "
            <div class='" . self::CLASSES['mobile_menu_search_container'] . "'>
                <form action='product/search' method='POST' class='flex flex-col gap-2'>
                    <input type='hidden' name='searchType' id='searchTypeMobile' value='barCode'>
                    <input type='text' name='query' id='queryMobile' class='" . self::CLASSES['mobile_menu_search_input'] . "' placeholder='Insira um Cód. Barras'>
                    <button type='submit' class='" . self::CLASSES['mobile_menu_search_button'] . "'>Pesquisar</button>
                </form>
            </div>";
        
        return "
            <button id='mobile-menu-button' class='" . self::CLASSES['mobile_menu_button'] . "' aria-label='Abrir menu de navegação' aria-controls='mobile-menu' aria-expanded='false' tabindex='0'>
                <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                    <line x1='3' y1='12' x2='21' y2='12'></line>
                    <line x1='3' y1='6' x2='21' y2='6'></line>
                    <line x1='3' y1='18' x2='21' y2='18'></line>
                </svg>
            </button>
            <nav id='mobile-menu' class='" . self::CLASSES['mobile_menu'] . "' aria-label='Menu de navegação mobile' tabindex='-1'>
                $mobileSearch
                <a href='/product/home' class='" . self::CLASSES['mobile_menu_item'] . "'>Home</a>
                <a href='/product/search' class='" . self::CLASSES['mobile_menu_item'] . "'>Produtos</a>
                <a href='/product/create' class='" . self::CLASSES['mobile_menu_item'] . "'>Endereçar Produto</a>
                <a href='/product/continueCreate' class='" . self::CLASSES['mobile_menu_item'] . "'>Endereçamento Contínuo de Produto</a>
                <a href='/product/search' class='" . self::CLASSES['mobile_menu_item'] . "'>Pesquisar</a>
                <a href='/report/expiry' class='" . self::CLASSES['mobile_menu_item'] . "'>Relatório de Validade</a>
                <a href='/report/stock' class='" . self::CLASSES['mobile_menu_item'] . "'>Relatório de Estoque</a>
                <a href='/transfer/internal' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferências Internas</a>
                <a href='/transfer/external' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferências de Saída</a>
                <a href='/transfer/continueInternal' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferência Interna Contínua</a>
                <a href='/transfer/continueExternal' class='" . self::CLASSES['mobile_menu_item'] . "'>Transferência de Saída Contínua</a>  
                $adminMenu
                <a href='/user/logout' class='" . self::CLASSES['mobile_menu_item'] . "'>Sair</a>
            </nav>
            <script>
                const menuBtn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');
                menuBtn.addEventListener('click', function(e) {
                    menu.classList.toggle('hidden');
                    menuBtn.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
                    if (!menu.classList.contains('hidden')) {
                        menu.focus();
                    }
                });
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!event.target.closest('#mobile-menu') && !event.target.closest('#mobile-menu-button')) {
                        menu.classList.add('hidden');
                        menuBtn.setAttribute('aria-expanded', 'false');
                    }
                });
                // Trap focus inside menu when open
                menu.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        menu.classList.add('hidden');
                        menuBtn.setAttribute('aria-expanded', 'false');
                        menuBtn.focus();
                    }
                });
            </script>";
    }
    private static function generateDesktopMenu($role): string {
        return self::generateSearch() . self::generateDropdowns($role);
    }

    public static function render(): string {
        $role = (!SessionManager::isAdmin()) ? 'user' : 'admin';

        return "
            <header class='" . self::CLASSES['header'] . "'>
                <div class='" . self::CLASSES['header_container'] . "'>
                    " . self::generateLogo() . "
                    " . self::generateMobileMenu($role) . "
                    " . self::generateDesktopMenu($role) . "
                </div>
            </header>";
    }
}
?>