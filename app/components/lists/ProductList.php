<?php
namespace App\Components\Lists;

use App\Entities\Product;

class ProductList {
    private const CLASSES = [
        'container' => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mx-auto',
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
        'button_secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500',
        'button_danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'badge' => 'px-2 py-1 text-xs font-medium rounded-full',
        'badge_warning' => 'bg-yellow-100 text-yellow-800',
        'badge_danger' => 'bg-red-100 text-red-800',
        'badge_success' => 'bg-green-100 text-green-800'
    ];

    private static function generateStockBadge(int $quantity): string {
        if ($quantity <= 5) {
            return "<span class='" . self::CLASSES['badge'] . " " . self::CLASSES['badge_danger'] . "'>
                Estoque Crítico
            </span>";
        } elseif ($quantity <= 10) {
            return "<span class='" . self::CLASSES['badge'] . " " . self::CLASSES['badge_warning'] . "'>
                Estoque Baixo
            </span>";
        }
        return "<span class='" . self::CLASSES['badge'] . " " . self::CLASSES['badge_success'] . "'>
            Estoque Normal
        </span>";
    }

    private static function generateProductCard(Product $product): string {
        return "
        <div class='" . self::CLASSES['card'] . "'>
            <div class='" . self::CLASSES['header'] . "'>
                <h3 class='" . self::CLASSES['title'] . "'>{$product->getName()}</h3>
            </div>
            
            <div class='" . self::CLASSES['body'] . "'>
                <div class='" . self::CLASSES['info_group'] . "'>
                    <span class='" . self::CLASSES['label'] . "'>Código:</span>
                    <span class='" . self::CLASSES['value'] . "'>{$product->getBarcode()}</span>
                </div>
                
                <div class='" . self::CLASSES['info_group'] . "'>
                    <span class='" . self::CLASSES['label'] . "'>Quantidade:</span>
                    <div class='flex items-center space-x-2'>
                        <span class='" . self::CLASSES['value'] . "'>{$product->getQuantity()}</span>
                        " . self::generateStockBadge($product->getQuantity()) . "
                    </div>
                </div>
                
                <div class='" . self::CLASSES['info_group'] . "'>
                    <span class='" . self::CLASSES['label'] . "'>Validade:</span>
                    <span class='" . self::CLASSES['value'] . "'>{$product->getExpiryDate()}</span>
                </div>
                
                <div class='" . self::CLASSES['info_group'] . "'>
                    <span class='" . self::CLASSES['label'] . "'>Localização:</span>
                    <span class='" . self::CLASSES['value'] . "'>{$product->getLocationString()}</span>
                </div>
            </div>
            
            <div class='" . self::CLASSES['footer'] . "'>
                
                <a href='product/decrease/{$product->getId()}'
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "'>
                    Baixa
                </a>
                
            </div>
        </div>";
    }


    /*
    <button onclick='confirmDelete({$product->getId()})'
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_danger'] . "'>
                    Excluir
                </button>
                <a href='/product/edit/{$product->getId()}' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    Editar
                </a>

    */
    public static function render(array $products): string {
        if (empty($products)) {
            return "<div class='text-center text-gray-600 py-8'>Nenhum produto encontrado.</div>";
        }

        $cards = '';
        foreach ($products as $product) {
            $cards .= self::generateProductCard($product);
        }

        return "
        <div class='" . self::CLASSES['container'] . "'>
            {$cards}
        </div>
        <script>
            function confirmDelete(id) {
                if (confirm('Tem certeza que deseja excluir este produto?')) {
                    window.location.href = '/product/delete/' + id;
                }
            }
        </script>";
    }
}