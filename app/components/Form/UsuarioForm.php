<?php
namespace Components\Form;

class UsuarioForm {
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

    public static function render(array $usuario = null): string {
        $nome = $usuario['nome'] ?? '';
        $email = $usuario['email'] ?? '';
        $senha = $usuario['senha'] ?? '';
        $tipo = $usuario['tipo'] ?? '';

        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <h2 class='" . self::CLASSES['title'] . "'>Cadastro de Usuário</h2>
                    <p class='" . self::CLASSES['subtitle'] . "'>Preencha os dados do usuário abaixo</p>
                </div>

                <form class='" . self::CLASSES['form'] . "' action='/usuario/salvar' method='POST'>
                    <div class='" . self::CLASSES['form_group'] . "'>
                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='nome' class='" . self::CLASSES['label'] . "'>Nome Completo</label>
                            <input type='text' id='nome' name='nome' value='{$nome}' required 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite o nome completo' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='email' class='" . self::CLASSES['label'] . "'>E-mail</label>
                            <input type='email' id='email' name='email' value='{$email}' required 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite o e-mail' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='senha' class='" . self::CLASSES['label'] . "'>Senha</label>
                            <input type='password' id='senha' name='senha' value='{$senha}' required 
                                class='" . self::CLASSES['input'] . "' 
                                placeholder='Digite a senha' />
                        </div>

                        <div class='" . self::CLASSES['input_group'] . "'>
                            <label for='tipo' class='" . self::CLASSES['label'] . "'>Tipo de Usuário</label>
                            <select id='tipo' name='tipo' required class='" . self::CLASSES['select'] . "'>
                                <option value=''>Selecione o tipo</option>
                                <option value='admin'" . ($tipo === 'admin' ? ' selected' : '') . ">Administrador</option>
                                <option value='usuario'" . ($tipo === 'usuario' ? ' selected' : '') . ">Usuário</option>
                            </select>
                        </div>
                    </div>

                    <div class='" . self::CLASSES['button_group'] . "'>
                        <button type='button' onclick='window.history.back()' class='" . self::CLASSES['button_secondary'] . "'>
                            Cancelar
                        </button>
                        <button type='submit' class='" . self::CLASSES['button_primary'] . "'>
                            Salvar Usuário
                        </button>
                    </div>
                </form>
            </div>";
    }
} 