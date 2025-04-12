<?php
namespace App\Components\Form;

use App\Entities\Product;

class ProdutoForm extends BaseForm {
    protected const CLASSES = [
        'container' => 'max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg',
        'header' => 'mb-8 text-center',
        'title' => 'text-3xl font-bold text-gray-900 mb-2',
        'subtitle' => 'text-gray-600',
        'form' => 'space-y-6',
        'form_group' => 'grid grid-cols-1 md:grid-cols-2 gap-6',
        'input_group' => 'space-y-2',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'select' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'textarea' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'button_group' => 'flex justify-end space-x-4 mt-8',
        'button_primary' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'button_secondary' => 'inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
    ];

    public static function render(string $action, array $params = []): string {
        $product = $params['product'] ?? null;
        $title = $product ? 'Editar Produto' : 'Cadastrar Produto';
        $sectors = range('A', 'H');
        $floors = range(1, 5);
        $positions = range(1, 12);

        return "
        <form action='{$action}' method='POST' class='" . self::CLASSES['form'] . "'>
            <h2 class='" . self::CLASSES['title'] . "'>{$title}</h2>

            " . ($product ? "<input type='hidden' name='id' value='{$product->getId()}'>" : "") . "

            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Informações do Produto</h3>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateTextInput('name', 'Nome do Produto', 
                        $product ? $product->getName() : '', 
                        ['required' => true]
                    ) . "
                    
                    " . self::generateTextInput('barcode', 'Código de Barras',
                        $product ? $product->getBarcode() : '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateTextInput('quantity', 'Quantidade',
                        $product ? (string)$product->getQuantity() : '',
                        [
                            'type' => 'number',
                            'min' => '0',
                            'required' => true
                        ]
                    ) . "
                    
                    " . self::generateTextInput('expiryDate', 'Data de Validade',
                        $product ? $product->getExpiryDate() : '',
                        [
                            'type' => 'date',
                            'required' => true
                        ]
                    ) . "
                </div>
            </div>

            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Localização</h3>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateSelect('sector', 'Setor',
                        array_combine($sectors, $sectors),
                        $product ? $product->getLocation()->getSector() : '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateSelect('floor', 'Andar',
                        array_combine($floors, $floors),
                        $product ? (string)$product->getLocation()->getFloor() : '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateSelect('position', 'Posição',
                        array_combine($positions, $positions),
                        $product ? (string)$product->getLocation()->getPosition() : '',
                        ['required' => true]
                    ) . "
                </div>
            </div>

            <div class='" . self::CLASSES['button_group'] . "'>
                <a href='/product/list' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "'>
                    Cancelar
                </a>
                <button type='submit' 
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    " . ($product ? 'Atualizar' : 'Cadastrar') . "
                </button>
            </div>
        </form>";
    }
}