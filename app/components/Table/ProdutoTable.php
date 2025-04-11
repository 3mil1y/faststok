<?php
namespace Components\Table;

class ProdutoTable {
    private const CLASSES = [
        'container' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
        'header' => 'sm:flex sm:items-center sm:justify-between mb-6',
        'title' => 'text-2xl font-bold text-gray-900',
        'actions' => 'mt-4 sm:mt-0 flex space-x-3',
        'button_primary' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'button_secondary' => 'inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
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
        'search_container' => 'mt-4 sm:mt-0',
        'search_input' => 'block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'search_label' => 'sr-only'
    ];

    public static function render(array $produtos = []): string {
        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h1 class='" . self::CLASSES['title'] . "'>Produtos</h1>
                    <div class='" . self::CLASSES['actions'] . "'>
                        <a href='/produto/cadastrar' class='" . self::CLASSES['button_primary'] . "'>
                            <svg class='-ml-1 mr-2 h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z' clip-rule='evenodd' />
                            </svg>
                            Novo Produto
                        </a>
                        <a href='/produto/pesquisar' class='" . self::CLASSES['button_secondary'] . "'>
                            <svg class='-ml-1 mr-2 h-5 w-5 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z' clip-rule='evenodd' />
                            </svg>
                            Pesquisar
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
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Categoria</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Fornecedor</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Quantidade</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Preço</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Data de Validade</th>
                                        <th scope='col' class='" . self::CLASSES['th'] . "'>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class='" . self::CLASSES['tbody'] . "'>" .
                                    self::gerarLinhasTabela($produtos) . "
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>";
    }

    private static function gerarLinhasTabela(array $produtos): string {
        if (empty($produtos)) {
            return "
                <tr>
                    <td colspan='7' class='" . self::CLASSES['empty_state'] . "'>
                        <p class='" . self::CLASSES['empty_state_text'] . "'>Nenhum produto encontrado</p>
                    </td>
                </tr>";
        }

        $linhas = '';
        foreach ($produtos as $produto) {
            $linhas .= "
                <tr class='" . self::CLASSES['tr'] . "'>
                    <td class='" . self::CLASSES['td'] . "'>{$produto['nome']}</td>
                    <td class='" . self::CLASSES['td'] . "'>{$produto['categoria_nome']}</td>
                    <td class='" . self::CLASSES['td'] . "'>{$produto['fornecedor_nome']}</td>
                    <td class='" . self::CLASSES['td'] . "'>{$produto['quantidade']}</td>
                    <td class='" . self::CLASSES['td'] . "'>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>
                    <td class='" . self::CLASSES['td'] . "'>" . date('d/m/Y', strtotime($produto['data_validade'])) . "</td>
                    <td class='" . self::CLASSES['actions_cell'] . "'>
                        <a href='/produto/editar/{$produto['id']}' class='" . self::CLASSES['action_button'] . "'>
                            <svg class='h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z' />
                            </svg>
                        </a>
                        <a href='/produto/excluir/{$produto['id']}' class='" . self::CLASSES['delete_button'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
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