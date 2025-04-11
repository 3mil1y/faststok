<?php
namespace Components\Form;

class CadastroProduto {
    private const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'titulo' => 'text-3xl font-semibold text-center mb-6',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'select' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'grid_2' => 'grid grid-cols-2 gap-4',
        'grid_3' => 'grid grid-cols-3 gap-4',
        'button' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'
    ];

    private static function gerarOpcoes(array $valores, string $textoInicial): string {
        $opcoes = "<option value='' disabled selected>{$textoInicial}</option>";
        foreach ($valores as $valor) {
            $opcoes .= "<option value='{$valor}'>{$valor}</option>";
        }
        return $opcoes;
    }

    private static function gerarCampoInput(string $id, string $label, string $tipo = 'text'): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <input type='{$tipo}' id='{$id}' name='{$id}' required class='" . self::CLASSES['input'] . "'>
        </div>";
    }

    private static function gerarCampoSelect(string $id, string $label, string $opcoes): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$opcoes}
            </select>
        </div>";
    }

    public static function render($action = ''): string {
        $setores = range('A', 'H');
        $andares = range(1, 5);
        $posicoes = range(1, 12);

        $opcoesSetor = self::gerarOpcoes($setores, 'Selecione um setor');
        $opcoesAndar = self::gerarOpcoes($andares, 'Selecione um andar');
        $opcoesPosicao = self::gerarOpcoes($posicoes, 'Selecione uma posição');

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Cadastre um novo Produto</h1>
            
            " . self::gerarCampoInput('nome', 'Nome') . "
            
            " . self::gerarCampoInput('codBarras', 'Código de Barras', 'number') . "
            
            <div class='" . self::CLASSES['grid_2'] . "'>
                " . self::gerarCampoInput('quantidade', 'Quantidade', 'number') . "
                " . self::gerarCampoInput('validade', 'Validade', 'date') . "
            </div>
            
            <div class='" . self::CLASSES['grid_3'] . "'>
                " . self::gerarCampoSelect('setor', 'Setor', $opcoesSetor) . "
                " . self::gerarCampoSelect('andar', 'Andar', $opcoesAndar) . "
                " . self::gerarCampoSelect('posicao', 'Posição', $opcoesPosicao) . "
            </div>
            
            <button type='submit' class='" . self::CLASSES['button'] . "'>Salvar Produto</button>
        </form>";
    }
}

/* Código original
namespace Components;

class CadastroProduto {
    public static function gerarForm($action = '') {
        $setores = range('A', 'H');
        $andares = range(1, 5);
        $posicoes = range(1, 12);

        $opcoesSetor = "<option value='' disabled selected>Selecione um setor</option>";
        foreach ($setores as $setor) {
            $opcoesSetor .= "<option value='{$setor}'>{$setor}</option>";
        }

        $opcoesAndar = "<option value='' disabled selected>Selecione um andar</option>";
        foreach ($andares as $andar) {
            $opcoesAndar .= "<option value='{$andar}'>{$andar}</option>";
        }

        $opcoesPosicao = "<option value='' disabled selected>Selecione uma posição</option>";
        foreach ($posicoes as $posicao) {
            $opcoesPosicao .= "<option value='{$posicao}'>{$posicao}</option>";
        }

        return "
        <form action='{$action}' method='post' class='w-1/2 mx-auto my-6 space-y-6'>
            <h1 class='text-3xl font-semibold text-center mb-6'>Cadastre um novo Produto</h1>
            <div>
                <label for='nome' class='block text-sm font-medium text-gray-700'>Nome:</label>
                <input type='text' id='nome' name='nome' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div>
                <label for='codBarras' class='block text-sm font-medium text-gray-700'>Código de Barras:</label>
                <input type='number' id='codBarras' name='codBarras' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div class='grid grid-cols-2 gap-4'>
                <div>
                    <label for='quantidade' class='block text-sm font-medium text-gray-700'>Quantidade:</label>
                    <input type='number' id='quantidade' name='quantidade' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
                <div>
                    <label for='validade' class='block text-sm font-medium text-gray-700'>Validade:</label>
                    <input type='date' id='validade' name='validade' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
            </div>

            <div class='grid grid-cols-3 gap-4'>
                <div>
                    <label for='setor' class='block text-sm font-medium text-gray-700'>Setor:</label>
                    <select id='setor' name='setor' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesSetor}
                    </select>
                </div>
                <div>
                    <label for='andar' class='block text-sm font-medium text-gray-700'>Andar:</label>
                    <select id='andar' name='andar' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesAndar}
                    </select>
                </div>
                <div>
                    <label for='posicao' class='block text-sm font-medium text-gray-700'>Posição:</label>
                    <select id='posicao' name='posicao' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        {$opcoesPosicao}
                    </select>
                </div>
            </div>

            <button type='submit' class='mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'>Salvar Produto</button>
        </form>
        ";
    }
}
*/