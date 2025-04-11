<?php
namespace Components\Form;

abstract class TransferenciaForm extends BaseForm {
    protected static function createOptions(): array {
        $setores = range('A', 'H');
        $andares = range(1, 5);
        $posicoes = range(1, 12);

        $opcoesSetor = self::gerarOpcoes($setores, 'Selecione um setor');
        $opcoesAndar = self::gerarOpcoes($andares, 'Selecione um andar');
        $opcoesPosicao = self::gerarOpcoes($posicoes, 'Selecione uma posição');

        return compact("opcoesSetor", "opcoesAndar", "opcoesPosicao");
    }
} 