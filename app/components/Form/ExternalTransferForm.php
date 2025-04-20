<?php
namespace App\Components\Form;

use App\Entities\Product;

class ExternalTransferForm extends TransferForm {
    public static function render(string $action, array $params = []): string {
        $options = self::createLocationOptions();
        $error = ($params['errorMessage'] == null) ? null : "<p class='" . self::CLASSES['error'] . "'>{$params['errorMessage']}</p>";
        $successMessage = ($params['successMessage'] == null) ? null : "<p class='" . self::CLASSES['success'] . "'>{$params['successMessage']}</p>";
        
        return "
        <form action='{$action}' method='POST' class='" . self::CLASSES['form'] . "'>
            <h2 class='" . self::CLASSES['title'] . "'>Transferência Externa de Produtos</h2>
            {$error}
            {$successMessage}
            
            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Localização do Produto</h3>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateSelect('sector', 'Setor',
                        $options['sectors'],
                        '',
                        ['required' => true],
                        'Escolha o setor de origem'
                    ) . "
                    
                    " . self::generateSelect('floor', 'Andar',
                        $options['floors'],
                        '',
                        ['required' => true],
                        'Escolha o andar de origem'
                    ) . "
                    
                    " . self::generateSelect('position', 'Posição',
                        $options['positions'],
                        '',
                        ['required' => true],
                        'Escolha a posição de origem'
                    ) . "
                </div>
                <p class='" . self::CLASSES['hint'] . "'>Selecione a localização a ser transferida</p>
            </div>

            <div class='" . self::CLASSES['button_group'] . "'>
                <a href='/transfer' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "'>
                    Cancelar
                </a>
                <button type='submit' 
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    Realizar Transferência Externa
                </button>
            </div>
        </form>
        
        <script>
            document.querySelector('form').addEventListener('submit', function(e) {
                const quantity = parseInt(document.querySelector('input[name=quantity]').value);
                
                if (quantity <= 0) {
                    e.preventDefault();
                    alert('A quantidade deve ser maior que zero.');
                }
            });
        </script>";
    }
}

//Detalhes da transferência - implementar mais tarde

/*
<div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Informações da Transferência</h3>
                <div class='space-y-4'>
                    " . self::generateTextInput('destination', 'Destino',
                        '',
                        [
                            'required' => true,
                            'placeholder' => 'Nome da empresa ou local de destino'
                        ]
                    ) . "
                    
                    " . self::generateTextInput('responsible', 'Responsável',
                        '',
                        [
                            'required' => true,
                            'placeholder' => 'Nome do responsável pelo recebimento'
                        ]
                    ) . "

                    " . self::generateTextInput('quantity', 'Quantidade',
                        '',
                        [
                            'type' => 'number',
                            'min' => '1',
                            'required' => true,
                            'placeholder' => 'Quantidade a ser transferida'
                        ]
                    ) . "
                    
                    " . self::generateTextarea('notes', 'Observações',
                        '',
                        [
                            'placeholder' => 'Informações adicionais sobre a transferência'
                        ]
                    ) . "
                </div>
                </div>
*/