<?php
namespace App\Components\Table;

use App\Entities\Product;

class ProductTable {
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
        'th' => 'py-3.5 px-3 text-left text-sm font-semibold text-gray-900',
        'tbody' => 'divide-y divide-gray-200 bg-white',
        'td' => 'whitespace-nowrap py-4 px-3 text-sm text-gray-500',
        'row_actions' => 'flex items-center space-x-2',
        'action_button' => 'text-sm text-gray-500 hover:text-gray-700',
        'action_button_edit' => 'text-blue-600 hover:text-blue-800',
        'action_button_delete' => 'text-red-600 hover:text-red-800'
    ];

    public static function render(array $products): string {
        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h1 class='" . self::CLASSES['title'] . "'>Lista de Produtos</h1>
                    <div class='" . self::CLASSES['actions'] . "'>
                        <a href='/product/create' class='" . self::CLASSES['button_primary'] . "'>
                            Novo Produto
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
                                        <th class='" . self::CLASSES['th'] . "'>Código de Barras</th>
                                        <th class='" . self::CLASSES['th'] . "'>Quantidade</th>
                                        <th class='" . self::CLASSES['th'] . "'>Validade</th>
                                        <th class='" . self::CLASSES['th'] . "'>Localização</th>
                                        <th class='" . self::CLASSES['th'] . "'>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class='" . self::CLASSES['tbody'] . "'>
                                    " . self::generateTableRows($products) . "
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>";
    }

    private static function generateTableRows(array $products): string {
        $rows = '';
        foreach ($products as $product) {
            $rows .= "<tr>
                <td class='" . self::CLASSES['td'] . "'>{$product->getName()}</td>
                <td class='" . self::CLASSES['td'] . "'>{$product->getBarcode()}</td>
                <td class='" . self::CLASSES['td'] . "'>{$product->getQuantity()}</td>
                <td class='" . self::CLASSES['td'] . "'>{$product->getExpiryDate()}</td>
                <td class='" . self::CLASSES['td'] . "'>{$product->getLocationString()}</td>
                <td class='" . self::CLASSES['td'] . "'>
                    <div class='" . self::CLASSES['row_actions'] . "'>
                        <a href='/product/edit/{$product->getId()}' class='" . self::CLASSES['action_button_edit'] . "'>
                            Editar
                        </a>
                        <a href='/product/decrease/{$product->getId()}' class='" . self::CLASSES['action_button'] . "'>
                            Baixa
                        </a>
                        <button onclick='confirmDelete({$product->getId()})' class='" . self::CLASSES['action_button_delete'] . "'>
                            Excluir
                        </button>
                    </div>
                </td>
            </tr>";
        }
        return $rows;
    }
}