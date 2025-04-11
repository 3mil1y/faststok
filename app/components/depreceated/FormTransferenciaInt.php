<?php
namespace Components;

class FormTransferenciaInt extends FormTransferencia {
    private static function gerarCampoSelect(string $id, string $label, string $opcoes): string {
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

    public static function gerar($action): string {
        $opcoes = self::createOptions();

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Transferir Endereço</h1>

            " . self::gerarGrupoSelecao('origem', 'Setor de', $opcoes) . "
            
            " . self::gerarGrupoSelecao('destino', 'Setor de', $opcoes) . "

            <button type='submit' class='" . self::CLASSES['button'] . "'>Transferir Produto</button>
        </form>";
    }
}

/* Código original
namespace Components;

class FormTransferenciaInt extends FormTransferencia{
    public static function gerar($action) {
        $opcoes = FormTransferenciaInt::createOptions();

        $opcoesSetor = $opcoes['opcoesSetor'];
        $opcoesAndar = $opcoes['opcoesAndar'];
        $opcoesPosicao = $opcoes['opcoesPosicao'];

        return "
        <form action='{$action}' method='post' class='w-1/2 mx-auto my-6 space-y-6'>
            <h1 class='text-3xl font-semibold text-center mb-6'>Transferir Endereço</h1>

            <div class='grid grid-cols-3 gap-4'>
                <div>
                    <label for='setorOrigem' class='block text-sm font-medium text-gray-700'>Setor de Origem:</label>
                    <select id='setorOrigem' name='setorOrigem' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesSetor}
                    </select>
                </div>
                <div>
                    <label for='andarOrigem' class='block text-sm font-medium text-gray-700'>Andar de Origem:</label>
                    <select id='andarOrigem' name='andarOrigem' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesAndar}
                    </select>
                </div>
                <div>
                    <label for='posicaoOrigem' class='block text-sm font-medium text-gray-700'>Posição de Origem:</label>
                    <select id='posicaoOrigem' name='posicaoOrigem' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesPosicao}
                    </select>
                </div>
            </div>

            <div class='grid grid-cols-3 gap-4'>
                <div>
                    <label for='setorDestino' class='block text-sm font-medium text-gray-700'>Setor de Destino:</label>
                    <select id='setorDestino' name='setorDestino' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesSetor}
                    </select>
                </div>
                <div>
                    <label for='andarDestino' class='block text-sm font-medium text-gray-700'>Andar de Destino:</label>
                    <select id='andarDestino' name='andarDestino' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesAndar}
                    </select>
                </div>
                <div>
                    <label for='posicaoDestino' class='block text-sm font-medium text-gray-700'>Posição de Destino:</label>
                    <select id='posicaoDestino' name='posicaoDestino' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesPosicao}
                    </select>
                </div>
            </div>

            <button type='submit' class='mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'>Transferir Produto</button>
        </form>
        ";
    }
}
*/