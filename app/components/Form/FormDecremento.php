<?php
namespace Components\Form;

use Produto\Produto;

class FormDecremento {
    private const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'titulo' => 'text-3xl font-semibold text-center mb-6',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'input_readonly' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md bg-gray-100',
        'button' => 'mt-4 px-6 py-2 bg-red-600 text-white rounded-md'
    ];

    private static function gerarCampoInput(string $id, string $label, string $valor, bool $readonly = false, string $tipo = 'text', array $atributos = []): string {
        $atributosStr = '';
        foreach ($atributos as $key => $value) {
            $atributosStr .= " {$key}='{$value}'";
        }
        
        $classe = $readonly ? self::CLASSES['input_readonly'] : self::CLASSES['input'];
        
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <input type='{$tipo}' id='{$id}' name='{$id}' value='{$valor}'" . 
            ($readonly ? ' readonly' : '') . 
            " class='{$classe}'{$atributosStr}>
        </div>";
    }

    private static function gerarCampoHidden(string $name, string $value): string {
        return "<input type='hidden' name='{$name}' value='{$value}'>";
    }

    public static function render(string $action, Produto $produto): string {
        $idProduto = $produto->getIdProduto();
        $produtoNome = $produto->getNome();
        $produtoCodBarras = $produto->getCodBarras();
        $produtoQuantidade = $produto->getQuantidade();
        $produtoEnderecoDescricao = $produto->getEnderecoStrg();

        return "<form action='{$action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Diminuir Quantidade do Produto</h1>
            
            " . self::gerarCampoHidden('idProduto', $idProduto) . "
            
            " . self::gerarCampoInput('produto', 'Produto', $produtoNome, true) . "
            
            " . self::gerarCampoInput('codBarras', 'Código de Barras', $produtoCodBarras, true) . "
            
            " . self::gerarCampoInput('quantidadeAtual', 'Quantidade Atual', $produtoQuantidade, true, 'number') . "
            
            " . self::gerarCampoInput('quantidade', 'Quantidade a Diminuir', '', false, 'number', [
                'required' => '',
                'min' => '1',
                'max' => $produtoQuantidade
            ]) . "
            
            " . self::gerarCampoInput('endereco', 'Endereço', $produtoEnderecoDescricao, true) . "
            
            <button type='submit' class='" . self::CLASSES['button'] . "'>Diminuir Quantidade</button>
        </form>";
    }
}

/* Código original
namespace Componentes;

Use Produto\Produto;

class FormDecremento {
    public static function gerar($action, Produto $produto) {
        // Acessando os dados do produto usando os métodos da classe Produto
        $idProduto = $produto->getIdProduto();
        $produtoNome = $produto->getNome();
        $produtoCodBarras = $produto->getCodBarras();
        $produtoQuantidade = $produto->getQuantidade();
        $produtoValidade = $produto->getValidade();
        $produtoEnderecoDescricao = $produto->getEnderecoStrg(); // Obtendo a descrição do endereço

        return "
        <form action='{$action}' method='post' class='w-1/2 mx-auto my-6 space-y-6'>
            <h1 class='text-3xl font-semibold text-center mb-6'>Diminuir Quantidade do Produto</h1>

               <!-- Campo oculto para armazenar o ID do produto -->
            <input type='hidden' name='idProduto' value='{$idProduto}'>

            <div>
                <label for='produto' class='block text-sm font-medium text-gray-700'>Produto:</label>
                <input type='text' id='produto' name='produto' value='{$produtoNome}' readonly class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div>
                <label for='codBarras' class='block text-sm font-medium text-gray-700'>Código de Barras:</label>
                <input type='text' id='codBarras' name='codBarras' value='{$produtoCodBarras}' readonly class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div>
                <label for='quantidade' class='block text-sm font-medium text-gray-700'>Quantidade Atual:</label>
                <input type='number' id='quantidadeAtual' name='quantidadeAtual' value='{$produtoQuantidade}' readonly class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div>
                <label for='quantidade' class='block text-sm font-medium text-gray-700'>Quantidade a Diminuir:</label>
                <input type='number' id='quantidade' name='quantidade' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md' min='1' max='{$produtoQuantidade}'>
            </div>

            <div>
                <label for='endereco' class='block text-sm font-medium text-gray-700'>Endereço:</label>
                <input type='text' id='endereco' name='endereco' value='{$produtoEnderecoDescricao}' readonly class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <button type='submit' class='mt-4 px-6 py-2 bg-red-600 text-white rounded-md'>Diminuir Quantidade</button>
        </form>
        ";
    }
}
*/