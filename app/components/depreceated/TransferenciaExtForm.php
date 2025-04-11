<?php
namespace Components;

use Components\FormTransferencia;

class FormTransferenciaExt extends FormTransferencia {
    private static function gerarCampoSelect(string $id, string $label, string $opcoes): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$opcoes}
            </select>
        </div>";
    }

    public static function render(string $action): string {
        $opcoes = self::createOptions();

        $campoSetor = self::gerarCampoSelect('setor', 'Setor', $opcoes['opcoesSetor']);
        $campoAndar = self::gerarCampoSelect('andar', 'Andar', $opcoes['opcoesAndar']);
        $campoPosicao = self::gerarCampoSelect('posicao', 'Posição', $opcoes['opcoesPosicao']);

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Transferir Endereço</h1>

            <div class='" . self::CLASSES['grid'] . "'>
                {$campoSetor}
                {$campoAndar}
                {$campoPosicao}
            </div>

            <button type='submit' class='" . self::CLASSES['button'] . "'>Transferir Produto</button>
        </form>";
    }
}

/* Código original
namespace Components;

use Components\FormTransferencia;

class FormTransferenciaExt extends FormTransferencia{
    public static function gerar($action) {
        $opcoes = FormTransferenciaExt::createOptions();

        return "
        <form action='{$action}' method='post' class='w-1/2 mx-auto my-6 space-y-6'>
            <h1 class='text-3xl font-semibold text-center mb-6'>Transferir Endereço</h1>

            <div class='grid grid-cols-3 gap-4'>
                <div>
                    <label for='setor' class='block text-sm font-medium text-gray-700'>Setor:</label>
                    <select id='setor' name='setor' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoes['opcoesSetor']}
                    </select>
                </div>
                <div>
                    <label for='andar' class='block text-sm font-medium text-gray-700'>Andar:</label>
                    <select id='andar' name='andar' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoes['opcoesAndar']}
                    </select>
                </div>
                <div>
                    <label for='posicao'
                    */