<?php
namespace Components\Form;

class TransferenciaExtForm extends TransferenciaForm {
    protected static function gerarCampoSelect(string $id, string $label, string $opcoes): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$opcoes}
            </select>
        </div>";
    }

    private static function gerarGrupoSelecao(string $prefixo, string $titulo, array $opcoes): string {
        return "<div class='" . self::CLASSES['grid'] . "'>
            " . self::gerarCampoSelect($prefixo . 'Setor', $titulo . ' Setor', $opcoes['opcoesSetor']) . "
            " . self::gerarCampoSelect($prefixo . 'Andar', $titulo . ' Andar', $opcoes['opcoesAndar']) . "
            " . self::gerarCampoSelect($prefixo . 'Posicao', $titulo . ' Posição', $opcoes['opcoesPosicao']) . "
        </div>";
    }

    public static function render(string $action, array $params = []): string {
        $opcoes = self::createOptions();

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Transferir Endereço</h1>

            " . self::gerarGrupoSelecao('origem', 'Origem', $opcoes) . "

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