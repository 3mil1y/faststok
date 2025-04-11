<?php
namespace Components\Form;

class TransferenciaIntForm extends TransferenciaForm {
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
            
            " . self::gerarGrupoSelecao('destino', 'Destino', $opcoes) . "

            <button type='submit' class='" . self::CLASSES['button'] . "'>Transferir Produto</button>
        </form>";
    }
} 