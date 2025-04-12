<?php
namespace App\Components\Form;

use App\Entities\Product;

class DecreaseProduct extends BaseForm {
    public static function render(string $action, array $params = []): string {
        $product = $params['product'] ?? null;
        if (!$product) {
            return "<div class='text-center text-red-600'>Produto não encontrado</div>";
        }

        return "
        <form action='{$action}' method='POST' class='" . self::CLASSES['form'] . "'>
            <h2 class='" . self::CLASSES['title'] . "'>Baixa de Produto</h2>
            
            <input type='hidden' name='productId' value='{$product->getId()}'>

            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Informações do Produto</h3>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateTextInput('name', 'Nome do Produto',
                        $product->getName(),
                        ['readonly' => true]
                    ) . "
                    
                    " . self::generateTextInput('barcode', 'Código de Barras',
                        $product->getBarcode(),
                        ['readonly' => true]
                    ) . "
                    
                    " . self::generateTextInput('quantity', 'Quantidade Atual',
                        (string)$product->getQuantity(),
                        [
                            'type' => 'number',
                            'readonly' => true
                        ]
                    ) . "
                    
                    " . self::generateTextInput('locationString', 'Localização',
                        $product->getLocationString(),
                        ['readonly' => true]
                    ) . "
                </div>
            </div>

            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Quantidade a Retirar</h3>
                " . self::generateTextInput('decreaseAmount', 'Quantidade',
                    '',
                    [
                        'type' => 'number',
                        'min' => '1',
                        'max' => $product->getQuantity(),
                        'required' => true
                    ]
                ) . "
                <p class='" . self::CLASSES['hint'] . "'>
                    Quantidade máxima disponível: {$product->getQuantity()}
                </p>
            </div>

            

            <div class='" . self::CLASSES['button_group'] . "'>
                <a href='/product/list' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "'>
                    Cancelar
                </a>
                <button type='submit' 
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    Confirmar Baixa
                </button>
            </div>
        </form>
        
        <script>
            document.querySelector('form').addEventListener('submit', function(e) {
                const amount = parseInt(document.querySelector('input[name=decreaseAmount]').value);
                const max = parseInt(document.querySelector('input[name=quantity]').value);
                
                if (amount > max) {
                    e.preventDefault();
                    alert('A quantidade a retirar não pode ser maior que a quantidade disponível.');
                }
            });
        </script>";
    }
}


//Motivo da baixa - implementar mais tarde

/*
<div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Motivo da Baixa</h3>
                " . self::generateTextarea('reason', 'Motivo',
                    '',
                    ['required' => true]
                ) . "
            </div>
*/