<?php
namespace Components\Form;

class ProdutoForm {
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
        'textarea' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'button_group' => 'flex justify-end space-x-4 mt-8',
        'button_primary' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'button_secondary' => 'inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'error' => 'mt-2 text-sm text-red-600'
    ];

    public static function render(array $categorias = [], array $fornecedores = [], array $produto = null): string {
        $nome = $produto['nome'] ?? '';
        $descricao = $produto['descricao'] ?? '';
        $categoria_id = $produto['categoria_id'] ?? '';
        $fornecedor_id = $produto['fornecedor_id'] ?? '';
        $quantidade = $produto['quantidade'] ?? '';
        $preco = $produto['preco'] ?? '';
        $data_validade = $produto['data_validade'] ?? '';

        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h2 class='" . self::CLASSES['title'] . "'>Cadastro de Produto</h2>
                    <p class='" . self::CLASSES['subtitle'] . "'>Preencha os dados do produto abaixo</p>
                </div>

                <form class='" . self::CLASSES['form'] . "' action='/produto/salvar' method='POST'>
                    <div class='" . self::CLASSES['form_group'] . "'>
                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='nome' class='" . self::CLASSES['label'] . "'>Nome do Produto</label>
                            <input type='text' id='nome' name='nome' value='{$nome}' required 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite o nome do produto' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='categoria_id' class='" . self::CLASSES['label'] . "'>Categoria</label>
                            <select id='categoria_id' name='categoria_id' required class='" . self::CLASSES['select'] . "'>
                                <option value=''>Selecione uma categoria</option>
                                " . self::gerarOpcoesCategorias($categorias, $categoria_id) . "
                            </select>
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='fornecedor_id' class='" . self::CLASSES['label'] . "'>Fornecedor</label>
                            <select id='fornecedor_id' name='fornecedor_id' required class='" . self::CLASSES['select'] . "'>
                                <option value=''>Selecione um fornecedor</option>
                                " . self::gerarOpcoesFornecedores($fornecedores, $fornecedor_id) . "
                            </select>
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='quantidade' class='" . self::CLASSES['label'] . "'>Quantidade</label>
                            <input type='number' id='quantidade' name='quantidade' value='{$quantidade}' required 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite a quantidade' min='0' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='preco' class='" . self::CLASSES['label'] . "'>Preço</label>
                            <input type='number' id='preco' name='preco' value='{$preco}' required 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite o preço' min='0' step='0.01' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='data_validade' class='" . self::CLASSES['label'] . "'>Data de Validade</label>
                            <input type='date' id='data_validade' name='data_validade' value='{$data_validade}' required 
                                class='" . self::CLASSES['input'] . "' />
                        </div>
                    </div>

                    <div class='" . self::CLASSES['input_group'] . "'>
                        <label for='descricao' class='" . self::CLASSES['label'] . "'>Descrição</label>
                        <textarea id='descricao' name='descricao' rows='3' 
                            class='" . self::CLASSES['textarea'] . "' 
                            placeholder='Digite a descrição do produto'>{$descricao}</textarea>
                    </div>

                    <div class='" . self::CLASSES['button_group'] . "'>
                        <button type='button' onclick='window.history.back()' class='" . self::CLASSES['button_secondary'] . "'>
                            Cancelar
                        </button>
                        <button type='submit' class='" . self::CLASSES['button_primary'] . "'>
                            Salvar Produto
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