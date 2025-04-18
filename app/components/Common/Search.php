<?php
namespace App\Components\Common;

use App\entities\Product;
use App\entities\Location;

// Needs refactoring to remove the commented code and unused
// and to follow PSR standards for class names and namespaces.

class Search {
    private const CLASSES = [
        'container' => 'flex items-center justify-center min-h-screen bg-gray-200',
        'form_container' => 'p-4 bg-white rounded-2xl shadow-lg w-full max-w-md',
        'titulo' => 'text-xl font-semibold mb-3',
        'select' => 'w-full p-2 border rounded-lg mb-3 bg-gray-100',
        'input' => 'w-full p-2 border rounded-lg bg-gray-100',
        'input_group' => 'mt-3',
        'button' => 'w-full mt-3 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700',
        'error' => 'rounded-md bg-red-50 p-4 mt-4',
        'error_text' => 'text-sm text-red-700'
    ];

    private static function gerarSelectTipoPesquisa(): string {
        return "<select class='" . self::CLASSES['select'] . "' name='searchType'>
            <option value='' selected disabled>Selecione o tipo de pesquisa</option>
            <option value='name'>Nome do Produto</option>
            <option value='barCode'>Código de Barras</option>
            <option value='location'>Endereço</option>
        </select>";
    }

    private static function gerarCampoInput(): string {
        return "<input type='text' class='" . self::CLASSES['input'] . "' id='campoPesquisa' name='query' placeholder='Digite sua pesquisa...' required/>";
    }

    private static function gerarCamposEndereco(): string {
    return "<div class='" . self::CLASSES['input_group'] . "' id='enderecoFields' style='display: none;'>
        <input type='text' name='sector' pattern='[A-H]+' maxlength='1' class='" . self::CLASSES['input'] . " mb-2' placeholder='Setor (A - H)' required/>
        <input type='number' min='1' max='5' step='1' name='floor' class='" . self::CLASSES['input'] . " mb-2' placeholder='Andar' required/>
        <input type='number' min='1' max='12' step='1' name='position' class='" . self::CLASSES['input'] . "' placeholder='Posição' required/>
    </div>";
}
    private static function gerarBotaoBuscar(): string {
        return "<button type='submit' class='" . self::CLASSES['button'] . "'>Buscar</button>";
    }

    private static function gerarScript(): string {
        return "<script>
            document.querySelector('select[name=\"searchType\"]').addEventListener('change', function() {
                const isLocation = this.value === 'location';
                document.getElementById('enderecoFields').style.display = isLocation ? 'block' : 'none';
                document.getElementById('campoPesquisa').style.display = isLocation ? 'none' : 'block';

                // Manipula o atributo required corretamente
                document.getElementById('campoPesquisa').required = !isLocation;
                document.querySelector('input[name=\"sector\"]').required = isLocation;
                document.querySelector('input[name=\"floor\"]').required = isLocation;
                document.querySelector('input[name=\"position\"]').required = isLocation;
            });
        </script>";
    }

    public static function render(string $action, string $error = null): string {
        $errorMessage = ($error != null) ? "
                <div class='" . self::CLASSES['error'] . "'>
                    <p class='" . self::CLASSES['error_text'] . "'>{$error}</p>
                </div>" : "";

        return "<div class='" . self::CLASSES['container'] . "'>
            <div class='" . self::CLASSES['form_container'] . "'>
                <h2 class='" . self::CLASSES['titulo'] . "'>Pesquisa</h2>
                ".$errorMessage."
                <form method='POST' action='{$action}'>
                    " . self::gerarSelectTipoPesquisa() . "
                    " . self::gerarCampoInput() . "
                    " . self::gerarCamposEndereco() . "
                    " . self::gerarBotaoBuscar() . "
                </form>
            </div>
        </div>
        " . self::gerarScript();
    }
}

/* Código original
namespace Components;

use Produto\Produto;
use Endereco\Endereco;

class Pesquisa {

    public static function gerarCampoPesquisa($action): string {
        $form = "
        <div class='flex items-center justify-center min-h-screen bg-gray-200'>
            <div class='p-4 bg-white rounded-2xl shadow-lg w-full max-w-md'>
                <h2 class='text-xl font-semibold mb-3'>Pesquisa</h2>
                <form method='POST' action='{$action}'>
                    <select class='w-full p-2 border rounded-lg mb-3 bg-gray-100' name='searchType'>
                        <option value='nome'>Nome do Produto</option>
                        <option value='codBarras'>Código de Barras</option>
                        <option value='endereco'>Endereço</option>
                    </select>
                    <input type='text' class='w-full p-2 border rounded-lg bg-gray-100' id='campoPesquisa' name='query' placeholder='Digite sua pesquisa...'/>
                    <div class='mt-3' id='enderecoFields' style='display: none;'>
                        <input type='text' name='setor' class='w-full p-2 border rounded-lg bg-gray-100 mb-2' placeholder='Setor'/>
                        <input type='number' name='andar' class='w-full p-2 border rounded-lg bg-gray-100 mb-2' placeholder='Andar'/>
                        <input type='number' name='posicao' class='w-full p-2 border rounded-lg bg-gray-100' placeholder='Posição'/>
                    </div>
                    <button type='submit' class='w-full mt-3 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700'>Buscar</button>
                </form>
            </div>
        </div>
        <script>
            document.querySelector('select[name=\"searchType\"]').addEventListener('change', function() {
                document.getElementById('enderecoFields').style.display = this.value === 'endereco' ? 'block' : 'none';
                document.getElementById('campoPesquisa').style.display = this.value === 'endereco' ? 'none' : 'block';
            });
        </script>";
        
        return $form;
    }
    
    // public function pesquisar(array $produtos, string $tipo, ?string $query, ?string $setor, ?int $andar, ?int $posicao): array {
    //     $resultado = [];

    //     foreach ($produtos as $produto) {
    //         if ($tipo === 'nome' && stripos($produto->getNome(), $query) !== false) {
    //             $resultado[] = $produto;
    //         } elseif ($tipo === 'codBarras' && $produto->getCodBarras() === $query) {
    //             $resultado[] = $produto;
    //         } elseif ($tipo === 'endereco') {
    //             $endereco = $produto->getEndereco();
    //             if (
    //                 ($setor && stripos($endereco->getSetor(), $setor) !== false) ||
    //                 ($andar && $endereco->getAndar() == $andar) ||
    //                 ($posicao && $endereco->getPosicao() == $posicao)
    //             ) {
    //                 $resultado[] = $produto;
    //             }
    //         }
    //     }

    //     return $resultado;
    // }
}
*/