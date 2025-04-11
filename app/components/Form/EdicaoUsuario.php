<?php
namespace Componentes;

use Usuario\Usuario;

class EdicaoUsuario {
    private const CLASSES = [
        'form' => 'w-1/2 mx-auto my-6 space-y-6',
        'titulo' => 'text-3xl font-semibold text-center mb-6',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'input_readonly' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md bg-gray-200',
        'select' => 'mt-1 p-2 block w-full border border-gray-300 rounded-md',
        'grid' => 'grid grid-cols-2 gap-4',
        'button' => 'mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'
    ];
    
    private string $action;

    public function __construct(string $action) {
        $this->action = $action;
    }

    private function gerarCampoInput(string $id, string $label, string $valor, bool $readonly = false): string {
        $classe = $readonly ? self::CLASSES['input_readonly'] : self::CLASSES['input'];
        
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <input type='text' id='{$id}' name='{$id}' value='{$valor}'" . 
            ($readonly ? ' readonly' : ' required') . 
            " class='{$classe}'>
        </div>";
    }

    private function gerarCampoSelect(string $id, string $label, string $valorSelecionado): string {
        $options = [
            'admin' => 'Admin',
            'usuario' => 'Usuário'
        ];
        
        $optionsHtml = '';
        foreach ($options as $value => $text) {
            $selected = ($valorSelecionado === $value) ? ' selected' : '';
            $optionsHtml .= "<option value='{$value}'{$selected}>{$text}</option>";
        }
        
        return "<div>
            <label for='{$id}' class='" . self::CLASSES['label'] . "'>{$label}:</label>
            <select id='{$id}' name='{$id}' required class='" . self::CLASSES['select'] . "'>
                {$optionsHtml}
            </select>
        </div>";
    }

    public function gerarFormularioEdicao(Usuario $usuario = null): string {
        $login = $usuario ? $usuario->getLogin() : '';
        $id = $usuario ? $usuario->getId() : '';
        $permissao = $usuario ? $usuario->getPermissao() : '';

        return "<form action='{$this->action}' method='post' class='" . self::CLASSES['form'] . "'>
            <h1 class='" . self::CLASSES['titulo'] . "'>Altere um Usuário</h1>
            
            " . $this->gerarCampoInput('login', 'Login', $login) . "
            
            <div class='" . self::CLASSES['grid'] . "'>
                " . $this->gerarCampoInput('id', 'ID', $id, true) . "
                " . $this->gerarCampoSelect('permissao', 'Permissão', $permissao) . "
            </div>
            
            <button type='submit' class='" . self::CLASSES['button'] . "'>Salvar Usuário</button>
        </form>";
    }
}

/* Código original
namespace Componentes;

use Usuario\Usuario;

class EdicaoUsuario {
    private string $action;

    public function __construct(string $action) {
        $this->action = $action;
    }

    public function gerarFormularioEdicao(Usuario $usuario = null): string {
        $login = $usuario ? $usuario->getLogin() : '';
        $id = $usuario ? $usuario->getId() : '';
        $permissao = $usuario ? $usuario->getPermissao() : '';

        return "r
        <form action='{$this->action}' method='post' class='w-1/2 mx-auto my-6 space-y-6'>
        <h1 class='text-3xl font-semibold text-center mb-6'>Altere um Usuário</h1>
            <div>
                <label for='login' class='block text-sm font-medium text-gray-700'>Login:</label>
                <input type='text' id='login' name='login' value='{$login}' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
            </div>

            <div class='grid grid-cols-2 gap-4'>
                <div>
                    <label for='id' class='block text-sm font-medium text-gray-700'>ID:</label>
                    <input type='text' id='id' name='id' value='{$id}' readonly class='mt-1 p-2 block w-full border border-gray-300 rounded-md bg-gray-200'>
                </div>
                <div>
                    <label for='permissao' class='block text-sm font-medium text-gray-700'>Permissão:</label>
                    <select id='permissao' name='permissao' required class='mt-1 p-2 block w-full border border-gray-300 rounded-md'>
                        <option value='admin'" . ($permissao === 'admin' ? ' selected' : '') . ">Admin</option>
                        <option value='usuario'" . ($permissao === 'usuario' ? ' selected' : '') . ">Usuário</option>
                    </select>
                </div>
            </div>

            <button type='submit' class='mt-4 px-6 py-2 bg-blue-600 text-white rounded-md'>Salvar Usuário</button>
            
        </form>
        ";
    }
    // <button type='submit' class='mt-4 px-6 py-2 bg-red-600 text-white rounded-md'>Excluir Usuário</button>
}
*/