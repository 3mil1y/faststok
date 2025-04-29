<?php

namespace App\Components\Form;

class DeleteLowStock {
    private const CLASSES = [
        'form' => 'space-y-6 bg-white p-6 rounded-lg shadow-md max-w-md mx-auto mt-16',
        'title' => 'text-2xl font-bold text-gray-900 mb-4 text-center',
        'subtitle' => 'text-sm text-gray-600 mb-6 text-center',
        'button_danger' => 'w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 focus:ring-2 focus:ring-red-500 font-semibold',
    ];

    public static function render(string $action): string {
        return "
            <form action='{$action}' method='POST' class='" . self::CLASSES['form'] . "'>
                <h2 class='" . self::CLASSES['title'] . "'>Deletar Produtos com Estoque Zerado</h2>
                <p class='" . self::CLASSES['subtitle'] . "'>Essa ação é irreversível. Verifique se há algum endereço em movimento antes de realizar a alteração.</p>
                <p class='text-center text-red-700 mb-4'>Tem certeza que deseja deletar todos os produtos com estoque zerado?</p>
                <button type='submit' class='" . self::CLASSES['button_danger'] . "'>
                    Deletar Estoque Baixo
                </button>
            </form>";
    }
}
?>
