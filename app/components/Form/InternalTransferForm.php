<?php
namespace App\Components\Form;

use App\Entities\Product;

class InternalTransferForm extends TransferForm {
    public static function render(string $action, array $params = []): string {
        $options = self::createLocationOptions();
        $error = ($params['errorMessage'] == null) ? null : "<p class='" . self::CLASSES['error'] . "'>{$params['errorMessage']}</p>";
        $successMessage = ($params['successMessage'] == null) ? null : "<p class='" . self::CLASSES['success'] . "'>{$params['successMessage']}</p>";

        return "
        <form action='{$action}' method='POST' class='" . self::CLASSES['form'] . "'>
            <h2 class='" . self::CLASSES['title'] . "'>Transferência Interna de Produtos</h2>
            {$error}
            {$successMessage}
            
            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Localização de Origem</h3>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateSelect('originSector', 'Setor',
                        $options['sectors'],
                        '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateSelect('originFloor', 'Andar',
                        $options['floors'],
                        '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateSelect('originPosition', 'Posição',
                        $options['positions'],
                        '',
                        ['required' => true]
                    ) . "
                </div>
                <p class='" . self::CLASSES['hint'] . "'>Selecione a localização atual dos produtos</p>
            </div>

            <div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Localização de Destino</h3>
                <div class='" . self::CLASSES['grid'] . "'>
                    " . self::generateSelect('destinationSector', 'Setor',
                        $options['sectors'],
                        '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateSelect('destinationFloor', 'Andar',
                        $options['floors'],
                        '',
                        ['required' => true]
                    ) . "
                    
                    " . self::generateSelect('destinationPosition', 'Posição',
                        $options['positions'],
                        '',
                        ['required' => true]
                    ) . "
                </div>
                <p class='" . self::CLASSES['hint'] . "'>Selecione a nova localização para os produtos</p>
            </div>

            <div class='" . self::CLASSES['button_group'] . "'>
                <a href='/transfer' 
                   class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "'>
                    Cancelar
                </a>
                <button type='submit' 
                        class='" . self::CLASSES['button'] . " " . self::CLASSES['button_primary'] . "'>
                    Realizar Transferência
                </button>
            </div>
        </form>
        
        <script>
            document.querySelector('form').addEventListener('submit', function(e) {
                const origin = {
                    sector: document.querySelector('select[name=originSector]').value,
                    floor: document.querySelector('select[name=originFloor]').value,
                    position: document.querySelector('select[name=originPosition]').value
                };
                
                const destination = {
                    sector: document.querySelector('select[name=destinationSector]').value,
                    floor: document.querySelector('select[name=destinationFloor]').value,
                    position: document.querySelector('select[name=destinationPosition]').value
                };
                
                if (origin.sector === destination.sector && 
                    origin.floor === destination.floor && 
                    origin.position === destination.position) {
                    e.preventDefault();
                    alert('A localização de origem e destino não podem ser iguais.');
                }
            });
        </script>";
    }
}

/* Campo de Detalhes da Transferência - implementar mais tarde*/

/* 
<div class='" . self::CLASSES['section'] . "'>
                <h3 class='" . self::CLASSES['section_title'] . "'>Detalhes da Transferência</h3>
                " . self::generateTextarea('notes', 'Observações',
                    '',
                    [
                        'placeholder' => 'Adicione informações relevantes sobre a transferência (opcional)'
                    ]
                ) . "
            </div>
*/