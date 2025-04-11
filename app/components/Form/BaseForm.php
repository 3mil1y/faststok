<?php
namespace Components\Form;

abstract class BaseForm {
    protected const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'titulo' => 'text-3xl font-semibold text-center mb-6',
        'grid' => 'grid grid-cols-3 gap-4',
        'label' => 'block text-sm font-medium text-gray-700',
        'select' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'button' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md'
    ];

    protected static function gerarCampoSelect(string $id, string $label, string $opcoes): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$opcoes}
            </select>
        </div>";
    }

    protected static function gerarOpcoes(array $valores, string $textoInicial): string {
        $opcoes = "<option value='' disabled selected>{$textoInicial}</option>";
        foreach ($valores as $valor) {
            $opcoes .= "<option value='{$valor}'>{$valor}</option>";
        }
        return $opcoes;
    }
    
    abstract public static function render(string $action, array $params = []): string;
} 