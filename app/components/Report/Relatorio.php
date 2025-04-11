<?php
namespace Components\Report;

use Produto\Produto;
use Endereco\Endereco;

class Relatorio {
    private const CLASSES = [
        'container' => 'p-4 bg-white rounded-2xl shadow-lg w-full max-w-4xl mx-auto',
        'titulo' => 'text-xl font-semibold mb-3 text-center',
        'tabela' => 'w-full table-auto border-collapse',
        'header_row' => 'bg-gray-200',
        'header_cell' => 'p-2 border-b',
        'row' => 'border-b',
        'cell' => 'p-2'
    ];

    private static function gerarCabecalhoTabela(): string {
        $colunas = ['Nome', 'Código de Barras', 'Validade', 'Quantidade', 'Localização'];
        
        $cabecalho = "<thead><tr class='" . self::CLASSES['header_row'] . "'>";
        
        foreach ($colunas as $coluna) {
            $cabecalho .= "<th class='" . self::CLASSES['header_cell'] . "'>{$coluna}</th>";
        }
        
        $cabecalho .= "</tr></thead>";
        
        return $cabecalho;
    }

    private static function gerarLinhaProduto(Produto $produto): string {
        return "<tr class='" . self::CLASSES['row'] . "'>
            <td class='" . self::CLASSES['cell'] . "'>{$produto->getNome()}</td>
            <td class='" . self::CLASSES['cell'] . "'>{$produto->getCodBarras()}</td>
            <td class='" . self::CLASSES['cell'] . "'>{$produto->getValidade()}</td>
            <td class='" . self::CLASSES['cell'] . "'>{$produto->getQuantidade()}</td>
            <td class='" . self::CLASSES['cell'] . "'>{$produto->getEnderecoStrg()}</td>
        </tr>";
    }

    public static function render(array $produtos, string $titulo = "Relatório Genérico"): string {
        $relatorio = "<div class='" . self::CLASSES['container'] . "'>
            <h2 class='" . self::CLASSES['titulo'] . "'>{$titulo}</h2>
            <table class='" . self::CLASSES['tabela'] . "'>
                " . self::gerarCabecalhoTabela() . "
                <tbody>";
        
        foreach ($produtos as $produto) {
            $relatorio .= self::gerarLinhaProduto($produto);
        }

        $relatorio .= "</tbody>
            </table>
        </div>";

        return $relatorio;
    }
}

/* Código original
namespace Components;

use Produto\Produto;
use Endereco\Endereco;

class Relatorio {

    public static function gerar(array $produtos, string $titulo = "Relatório Genérico"): string {
        $relatorio = "
        <div class='p-4 bg-white rounded-2xl shadow-lg w-full max-w-4xl mx-auto'>
            <h2 class='text-xl font-semibold mb-3 text-center'>".$titulo."</h2>
            <table class='w-full table-auto border-collapse'>
                <thead>
                    <tr class='bg-gray-200'>
                        <th class='p-2 border-b'>Nome</th>
                        <th class='p-2 border-b'>Código de Barras</th>
                        <th class='p-2 border-b'>Validade</th>
                        <th class='p-2 border-b'>Quantidade</th>
                        <th class='p-2 border-b'>Localização</th>
                    </tr>
                </thead>
                <tbody>";

        
        foreach ($produtos as $produto) {

            $relatorio .= "<tr class='border-b'>
                <td class='p-2'>{$produto->getNome()}</td>
                <td class='p-2'>{$produto->getCodBarras()}</td>
                <td class='p-2'>{$produto->getValidade()}</td>
                <td class='p-2'>{$produto->getQuantidade()}</td>
                <td class='p-2'>{$produto->getEnderecoStrg()}</td>
            </tr>";
        }

        $relatorio .= "
                </tbody>
            </table>
        </div>";

        return $relatorio;
    }
}
*/