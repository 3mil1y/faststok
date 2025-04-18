<?php
namespace Componentes;

use Produto\Produto;
use Endereco\Endereco;

//Probably will be removed  ( i dont now why i create this)

class FormProd {
    private const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'titulo' => 'text-3xl font-semibold text-center mb-6',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'grid_2' => 'grid grid-cols-2 gap-4',
        'grid_3' => 'grid grid-cols-3 gap-4',
        'button_save' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md',
        'button_delete' => 'mt-4 px-6 py-2 bg-red-600 text-white rounded-md'
    ];
    
    private string $action;

    public function __construct(string $action) {
        $this->action = $action;
    }

    private function gerarCampoInput(string $id, string $label, string $valor, bool $required = true, string $tipo = 'text'): string {
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <input type='{$tipo}' id='{$id}' name='{$id}' value='{$valor}' " . ($required ? 'required' : '') . " class='" . self::CLASSES['input'] . "'>
        </div>";
    }

    private function gerarCamposEndereco(Endereco $endereco): string {
        return "<div class='" . self::CLASSES['grid_3'] . "'>
            " . $this->gerarCampoInput('setor', 'Setor', $endereco->getSetor()) . "
            " . $this->gerarCampoInput('andar', 'Andar', $endereco->getAndar()) . "
            " . $this->gerarCampoInput('posicao', 'Posição', $endereco->getPosicao()) . "
        </div>";
    }

    private function gerarBotoes(): string {
        return "<button type='submit' class='" . self::CLASSES['button_save'] . "'>Salvar Produto</button>
                <button type='submit' class='" . self::CLASSES['button_delete'] . "'>Excluir Produto</button>";
    }

    public function gerarFormularioEdicao(Produto $produto = null): string {
        $nome = $produto ? $produto->getNome() : '';
        $codBarras = $produto ? $produto->getCodBarras() : '';
        $quantidade = $produto ? $produto->getQuantidade() : '';
        $validade = $produto ? $produto->getValidade() : '';
        $endereco = $produto ? $produto->getEndereco() : new Endereco('', '', '');
        
        return "<form action='{$this->action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Altere um Produto</h1>
            " . $this->gerarCampoInput('nome', 'Nome', $nome) . "
            " . $this->gerarCampoInput('codBarras', 'Código de Barras', $codBarras) . "
            
            <div class='" . self::CLASSES['grid_2'] . "'>
                " . $this->gerarCampoInput('quantidade', 'Quantidade', $quantidade, true, 'number') . "
                " . $this->gerarCampoInput('validade', 'Validade', $validade, true, 'date') . "
            </div>
            
            " . $this->gerarCamposEndereco($endereco) . "
            
            " . $this->gerarBotoes() . "
        </form>";
    }
}

/* Código original
namespace Componentes;

use Produto\Produto;
use Endereco\Endereco;

class FormProd {
    private string $action;

    public function __construct(string $action) {
        $this->action = $action;
    }

    public function gerarFormularioEdicao(Produto $produto = null): string {
        $nome = $produto ? $produto->getNome() : '';
        $codBarras = $produto ? $produto->getCodBarras() : '';
        $quantidade = $produto ? $produto->getQuantidade() : '';
        $validade = $produto ? $produto->getValidade() : '';
        $endereco = $produto ? $produto->getEndereco() : '';
        
        return "
        <form action='{$this->action}' method='post' class='w-1/2 mx-auto my-6 space-y-6'>
        <h1 class='text-3xl font-semibold text-center mb-6'>Altere um Produto</h1>
            <div>
                <label for='nome' class='block text-sm font-medium text-gray-700'>Nome:</label>
                <input type='text' id='nome' name='nome' value='{$nome}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div>
                <label for='codBarras' class='block text-sm font-medium text-gray-700'>Código de Barras:</label>
                <input type='text' id='codBarras' name='codBarras' value='{$codBarras}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div class='grid grid-cols-2 gap-4'>
                <div>
                    <label for='quantidade' class='block text-sm font-medium text-gray-700'>Quantidade:</label>
                    <input type='number' id='quantidade' name='quantidade' value='{$quantidade}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
                <div>
                    <label for='validade' class='block text-sm font-medium text-gray-700'>Validade:</label>
                    <input type='date' id='validade' name='validade' value='{$validade}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
            </div>

            <div class='grid grid-cols-3 gap-4'>
                <div>
                    <label for='setor' class='block text-sm font-medium text-gray-700'>Setor:</label>
                    <input type='text' id='setor' name='setor' value='{$endereco->getSetor()}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
                <div>
                    <label for='andar' class='block text-sm font-medium text-gray-700'>Andar:</label>
                    <input type='text' id='andar' name='andar' value='{$endereco->getAndar()}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
                <div>
                    <label for='posicao' class='block text-sm font-medium text-gray-700'>Posição:</label>
                    <input type='text' id='posicao' name='posicao' value='{$endereco->getPosicao()}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                </div>
            </div>

            <button type='submit' class='mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'>Salvar Produto</button>
            <button type='submit' class='mt-4 px-6 py-2 bg-red-600 text-white rounded-md'>Excluir Produto</button>
        </form>
        ";
    }
}
*/