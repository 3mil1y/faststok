<?php


namespace Components\Lists;

use Produto\Produto;
use Endereco\Endereco;

class ProductList {
    private const STYLES = [
        'container' => 'max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 mt-[4vh]',
        'header' => 'flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2',
        'title' => 'text-xl sm:text-2xl font-bold text-gray-900',
        'actions' => 'flex flex-col sm:flex-row gap-2',
        'button_primary' => 'inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto',
        'button_secondary' => 'inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto',
        'table_container' => 'mt-4 sm:mt-6',
        'table_wrapper' => 'overflow-x-auto -mx-2 sm:-mx-4 lg:-mx-8',
        'table_inner' => 'inline-block min-w-full py-1 sm:py-2 align-middle',
        'table' => 'min-w-full divide-y divide-gray-300',
        'thead' => 'bg-gray-50',
        'th' => 'px-2 py-2 sm:px-3 sm:py-3 text-left text-xs sm:text-sm font-semibold text-gray-900',
        'tbody' => 'divide-y divide-gray-200 bg-white',
        'tr' => 'hover:bg-gray-50',
        'td' => 'whitespace-nowrap px-2 py-2 sm:px-3 sm:py-3 text-xs sm:text-sm text-gray-500',
        'td_hidden_mobile' => 'whitespace-nowrap px-2 py-2 sm:px-3 sm:py-3 text-xs sm:text-sm text-gray-500 hidden sm:table-cell',
        'actions_cell' => 'whitespace-nowrap px-2 py-2 sm:px-3 sm:py-3 text-xs sm:text-sm text-gray-500',
        'action_button' => 'inline-flex items-center px-2 py-1 sm:px-3 sm:py-1.5 border border-transparent text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'delete_button' => 'text-red-600 hover:text-red-900',
        'empty_state' => 'text-center py-8 sm:py-12',
        'empty_state_text' => 'text-gray-500 text-xs sm:text-sm'
    ];

    private static function generateTableHeader(): string {
        $columns = [
            ['text' => 'Nome', 'class' => self::STYLES['th']],
            ['text' => 'Código de Barras', 'class' => self::STYLES['th'] . ' hidden sm:table-cell'],
            ['text' => 'Quantidade', 'class' => self::STYLES['th']],
            ['text' => 'Validade', 'class' => self::STYLES['th']],
            ['text' => 'Endereço', 'class' => self::STYLES['th']],
            ['text' => 'Ações', 'class' => self::STYLES['th']]
        ];
        
        $header = "<thead class='" . self::STYLES['thead'] . "'><tr>";
        
        foreach ($columns as $column) {
            $header .= "<th scope='col' class='" . $column['class'] . "'>{$column['text']}</th>";
        }
        
        $header .= "</tr></thead>";
        
        return $header;
    }

    private static function generateProductRow(Produto $product): string {
        return "
            <tr class='" . self::STYLES['tr'] . "'>
                <td class='" . self::STYLES['td'] . "'>" . htmlspecialchars($product->getNome()) . "</td>
                <td class='" . self::STYLES['td_hidden_mobile'] . "'>" . htmlspecialchars($product->getCodBarras()) . "</td>
                <td class='" . self::STYLES['td'] . "'>" . htmlspecialchars($product->getQuantidade()) . "</td>
                <td class='" . self::STYLES['td'] . "'>" . htmlspecialchars($product->getValidade()) . "</td>
                <td class='" . self::STYLES['td'] . "'>" . htmlspecialchars(($product->getEndereco())->getEnderecoStrg()) . "</td>
                <td class='" . self::STYLES['actions_cell'] . "'>
                    <a href='baixarProduto.php?id=" . htmlspecialchars($product->getIdProduto()) . "' 
                       class='" . self::STYLES['action_button'] . "'>
                        Baixar
                    </a>
                </td>
            </tr>";
    }

    private static function generateEmptyState(): string {
        return "
            <tr>
                <td colspan='6' class='" . self::STYLES['empty_state'] . "'>
                    <p class='" . self::STYLES['empty_state_text'] . "'>Nenhum produto encontrado</p>
                </td>
            </tr>";
    }

    public static function render(array $products): string {
        $html = "
            <div class='" . self::STYLES['container'] . "'>
                <div class='" . self::STYLES['header'] . "'>
                    <h1 class='" . self::STYLES['title'] . "'>Produtos</h1>
                    <div class='" . self::STYLES['actions'] . "'>
                        <a href='produto/cadastrar' class='" . self::STYLES['button_primary'] . "'>
                            <svg class='-ml-1 mr-1 h-4 w-4 sm:h-5 sm:w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z' clip-rule='evenodd' />
                            </svg>
                            Novo Produto
                        </a>
                        <a href='produto/pesquisar' class='" . self::STYLES['button_secondary'] . "'>
                            <svg class='-ml-1 mr-1 h-4 w-4 sm:h-5 sm:w-5 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z' clip-rule='evenodd' />
                            </svg>
                            Pesquisar
                        </a>
                    </div>
                </div>

                <div class='" . self::STYLES['table_container'] . "'>
                    <div class='" . self::STYLES['table_wrapper'] . "'>
                        <div class='" . self::STYLES['table_inner'] . "'>
                            <table class='" . self::STYLES['table'] . "'>
                                " . self::generateTableHeader() . "
                                <tbody class='" . self::STYLES['tbody'] . "'>" . 
                                    (!empty($products) ? implode('', array_map([self::class, 'generateProductRow'], $products)) : self::generateEmptyState()) . "
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>";

        return $html;
    }
}
// namespace Components;

// use Produto\Produto;
// use Endereco\Endereco;

// class ListaProd{

//     public static function gerarListaProdutos(array $produtos): string {
//         $tabela = "
//         <table class='table-auto w-full border-collapse border border-gray-300'>
//             <thead>
//                 <tr class='bg-gray-200'>
//                     <th class='border border-gray-300 px-4 py-2'>Nome</th>
//                     <th class='border border-gray-300 px-4 py-2'>Código de Barras</th>
//                     <th class='border border-gray-300 px-4 py-2'>Quantidade</th>
//                     <th class='border border-gray-300 px-4 py-2'>Validade</th>
//                     <th class='border border-gray-300 px-4 py-2'>Endereço</th>
//                     <th class='border border-gray-300 px-4 py-2'>Ações</th>
//                 </tr>
//             </thead>
//             <tbody>";

//     if($produtos != []){
//             foreach ( $produtos as $produto) {
//                 $tabela .= "
//                     <tr class='hover:bg-gray-100'>
//                         <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($produto->getNome()) . "</td>
//                         <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($produto->getCodBarras()) . "</td>
//                         <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($produto->getQuantidade()) . "</td>
//                         <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($produto->getValidade()) . "</td>
//                         <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars(($produto->getEndereco())->getEnderecoStrg()) . "</td>
//                         <td class='border border-gray-300 px-4 py-2'>
//                             <a href='baixarProduto.php?id=" . htmlspecialchars($produto->getIdProduto()) . "' 
//                             class='bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600'>
//                             Baixar
//                             </a>
//                         </td>
//                     </tr>";
//             }
//     }else{
//         $tabela.= "
//                     <tr class='hover:bg-gray-100'>
//                         <td class='border border-gray-300 px-4 py-2'>Foram encontrados 0 zeros produtos cadastrados!</td>
//                     </tr>";
//     }



//         $tabela .= "
//             </tbody>
//         </table>";

//         return $tabela;
//     }
// }