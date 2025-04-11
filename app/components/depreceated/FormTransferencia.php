<?php
namespace Components;

class FormTransferencia {
    protected const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'titulo' => 'text-3xl font-semibold text-center mb-6',
        'grid' => 'grid grid-cols-3 gap-4',
        'label' => 'block text-sm font-medium text-gray-700',
        'select' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'button' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'
    ];

    protected static function gerarOpcoes(array $valores, string $textoInicial): string {
        $opcoes = "<option value='' disabled selected>{$textoInicial}</option>";
        foreach ($valores as $valor) {
            $opcoes .= "<option value='{$valor}'>{$valor}</option>";
        }
        return $opcoes;
    }

    public static function createOptions(): array {
        $setores = range('A', 'H');
        $andares = range(1, 5);
        $posicoes = range(1, 12);

        $opcoesSetor = self::gerarOpcoes($setores, 'Selecione um setor');
        $opcoesAndar = self::gerarOpcoes($andares, 'Selecione um andar');
        $opcoesPosicao = self::gerarOpcoes($posicoes, 'Selecione uma posição');

        return compact("opcoesSetor", "opcoesAndar", "opcoesPosicao");
    }
}

/* Código original
namespace Components;

class FormTransferencia {
    public static function createOptions(){
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

        return compact("opcoesSetor","opcoesAndar","opcoesPosicao");
    }
}   
*/