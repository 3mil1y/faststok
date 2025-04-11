<?php
namespace Components\Form;

class PesquisaForm {
    private const CLASSES = [
        'container' => 'max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg',
        'header' => 'mb-8 text-center',
        'title' => 'text-3xl font-bold text-gray-900 mb-2',
        'subtitle' => 'text-gray-600',
        'form' => 'space-y-6',
        'form_group' => 'grid grid-cols-1 md:grid-cols-2 gap-6',
        'input_group' => 'space-y-2',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'select' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'button_group' => 'flex justify-end space-x-4 mt-8',
        'button_primary' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'button_secondary' => 'inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'error' => 'mt-2 text-sm text-red-600'
    ];

    public static function render(array $categorias = [], array $fornecedores = [], array $filtros = []): string {
        $nome = $filtros['nome'] ?? '';
        $categoria_id = $filtros['categoria_id'] ?? '';
        $fornecedor_id = $filtros['fornecedor_id'] ?? '';
        $data_inicio = $filtros['data_inicio'] ?? '';
        $data_fim = $filtros['data_fim'] ?? '';

        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h2 class='" . self::CLASSES['title'] . "'>Pesquisa de Produtos</h2>
                    <p class='" . self::CLASSES['subtitle'] . "'>Filtre os produtos por diferentes critérios</p>
                </div>

                <form class='" . self::CLASSES['form'] . "' action='/produto/pesquisar' method='GET'>
                    <div class='" . self::CLASSES['form_group'] . "'>
                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='nome' class='" . self::CLASSES['label'] . "'>Nome do Produto</label>
                            <input type='text' id='nome' name='nome' value='{$nome}' 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite o nome do produto' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='categoria_id' class='" . self::CLASSES['label'] . "'>Categoria</label>
                            <select id='categoria_id' name='categoria_id' class='" . self::CLASSES['select'] . "'>
                                <option value=''>Todas as categorias</option>
                                " . self::gerarOpcoesCategorias($categorias, $categoria_id) . "
                            </select>
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='fornecedor_id' class='" . self::CLASSES['label'] . "'>Fornecedor</label>
                            <select id='fornecedor_id' name='fornecedor_id' class='" . self::CLASSES['select'] . "'>
                                <option value=''>Todos os fornecedores</option>
                                " . self::gerarOpcoesFornecedores($fornecedores, $fornecedor_id) . "
                            </select>
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='data_inicio' class='" . self::CLASSES['label'] . "'>Data de Validade (Início)</label>
                            <input type='date' id='data_inicio' name='data_inicio' value='{$data_inicio}' 
                                class='" . self::CLASSES['input'] . "' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='data_fim' class='" . self::CLASSES['label'] . "'>Data de Validade (Fim)</label>
                            <input type='date' id='data_fim' name='data_fim' value='{$data_fim}' 
                                class='" . self::CLASSES['input'] . "' />
                        </div>
                    </div>

                    <div class='" . self::CLASSES['button_group'] . "'>
                        <button type='button' onclick='window.history.back()' class='" . self::CLASSES['button_secondary'] . "'>
                            Cancelar
                        </button>
                        <button type='submit' class='" . self::CLASSES['button_primary'] . "'>
                            <svg class='-ml-1 mr-2 h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z' clip-rule='evenodd' />
                            </svg>
                            Pesquisar
                        </button>
                    </div>
                </form>
            </div>";
    }

    private static function gerarOpcoesCategorias(array $categorias, string $selected_id): string {
        $options = '';
        foreach ($categorias as $categoria) {
            $selected = $categoria['id'] == $selected_id ? 'selected' : '';
            $options .= "<option value='{$categoria['id']}' {$selected}>{$categoria['nome']}</option>";
        }
        return $options;
    }

    private static function gerarOpcoesFornecedores(array $fornecedores, string $selected_id): string {
        $options = '';
        foreach ($fornecedores as $fornecedor) {
            $selected = $fornecedor['id'] == $selected_id ? 'selected' : '';
            $options .= "<option value='{$fornecedor['id']}' {$selected}>{$fornecedor['nome']}</option>";
        }
        return $options;
    }
} 