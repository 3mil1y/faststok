<?php
namespace App\Components\Form;

class createProduct {
    private const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'title' => 'text-3xl font-semibold text-center mb-6',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'select' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'grid_2' => 'grid grid-cols-2 gap-4',
        'grid_3' => 'grid grid-cols-3 gap-4',
        'button' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'
    ];

    private static function generateOptions(array $values, string $initialText): string {
        $options = "<option value='' disabled selected>{$initialText}</option>";
        foreach ($values as $value) {
            $options .= "<option value='{$value}'>{$value}</option>";
        }
        return $options;
    }

    private static function generateInputField(string $id, string $label, string $type = 'text'): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <input type='{$type}' id='{$id}' name='{$id}' required class='" . self::CLASSES['input'] . "'>
        </div>";
    }

    private static function generateSelectField(string $id, string $label, string $options): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$options}
            </select>
        </div>";
    }

    public static function render($action = ''): string {
        $sectors = range('A', 'H');
        $floors = range(1, 5);
        $positions = range(1, 12);

        $sectorOptions = self::generateOptions($sectors, 'Selecione um setor');
        $floorOptions = self::generateOptions($floors, 'Selecione um andar');
        $positionOptions = self::generateOptions($positions, 'Selecione uma posição');

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['title'] . "'>Cadastre um novo Produto</h1>
            
            " . self::generateInputField('name', 'Nome') . "
            
            " . self::generateInputField('barCode', 'Código de Barras', 'number') . "
            
            <div class='" . self::CLASSES['grid_2'] . "'>
                " . self::generateInputField('quantity', 'Quantidade', 'number') . "
                " . self::generateInputField('expirationDate', 'Validade', 'date') . "
            </div>
            
            <div class='" . self::CLASSES['grid_3'] . "'>
                " . self::generateSelectField('sector', 'Setor', $sectorOptions) . "
                " . self::generateSelectField('floor', 'Andar', $floorOptions) . "
                " . self::generateSelectField('position', 'Posição', $positionOptions) . "
            </div>
            
            <button type='submit' class='" . self::CLASSES['button'] . "'>Salvar Produto</button>
        </form>";
    }
}
