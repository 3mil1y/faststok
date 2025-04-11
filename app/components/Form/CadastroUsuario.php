<?php
namespace Components\Form;

class CadastroUsuario {
    private const CLASSES = [
        'container' => 'flex items-center justify-center min-h-screen bg-gray-200',
        'form_container' => 'p-4 bg-white rounded-2xl shadow-lg w-full sm:w-9/12 md:w-4/5 lg:w-1/3 max-w-md',
        'titulo' => 'text-xl font-semibold mb-3 text-center',
        'input' => 'w-full p-2 border rounded-lg mb-3 bg-gray-100',
        'checkbox_label' => 'flex items-center space-x-2 text-gray-700 mb-3 cursor-pointer',
        'checkbox' => 'w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-200',
        'button' => 'w-full mt-3 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700',
        'error' => 'text-red-600 text-sm mb-3'
    ];

    private static function gerarInput(string $type, string $name, string $placeholder): string {
        return "<input type='{$type}' name='{$name}' 
                class='" . self::CLASSES['input'] . "' 
                placeholder='{$placeholder}' required/>";
    }

    private static function gerarCheckbox(): string {
        return "
            <label class='" . self::CLASSES['checkbox_label'] . "'>
                <input type='checkbox' name='is_admin' value='1' 
                       class='" . self::CLASSES['checkbox'] . "'/>
                <span>Tornar usuário administrador</span>
            </label>";
    }

    public static function gerarMsgErro($error): string {
        return "<div class='" . self::CLASSES['error'] . "'>{$error}</div>";
    }

    public static function render(string $action, string $error = null): string {
        $errorMessage = $error ? self::gerarMsgErro($error) : '';
        
        return "
        <div class='" . self::CLASSES['container'] . "'>
            <div class='" . self::CLASSES['form_container'] . "'>
                <h2 class='" . self::CLASSES['titulo'] . "'>Cadastro</h2>
                {$errorMessage}
                <form action='{$action}' method='post'>
                    " . self::gerarInput('text', 'login', 'Nome de usuário') . "
                    " . self::gerarInput('password', 'senha', 'Senha') . "
                    " . self::gerarCheckbox() . "
                    <button type='submit' class='" . self::CLASSES['button'] . "'>Cadastrar</button>
                </form>
            </div>
        </div>";
    }
}

/* Código original
namespace Components;

class CadastroUsuario {

    public static function gerarMsgErro($error): string {
        return "<div class='text-red-600 text-sm mb-3'>{$error}</div>";
    }

    public static function gerarForm(string $action, string $error = null): string {
        $errorMessage = $error ? CadastroUsuario::gerarMsgErro($error) : '';

        $form = "
        <div class='flex items-center justify-center min-h-screen bg-gray-200'>
            <div class='p-4 bg-white rounded-2xl shadow-lg w-full sm:w-9/12 md:w-4/5 lg:w-1/3 max-w-md'>
                <h2 class='text-xl font-semibold mb-3 text-center'>Cadastro</h2>
                {$errorMessage}
                <form action='{$action}' method='post'>
                    <input type='text' name='login' class='w-full p-2 border rounded-lg mb-3 bg-gray-100' placeholder='Nome de usuário' required/>
                    <input type='password' name='senha' class='w-full p-2 border rounded-lg mb-3 bg-gray-100' placeholder='Senha' required/>
                    
                    <!-- Checkbox para definir usuário como admin -->
                    <label class='flex items-center space-x-2 text-gray-700 mb-3 cursor-pointer'>
                        <input type='checkbox' name='is_admin' value='1' class='w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-200'/>
                        <span>Tornar usuário administrador</span>
                    </label>

                    <button type='submit' class='w-full mt-3 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700'>Cadastrar</button>
                </form>
            </div>
        </div>";
        
        return $form;
    }
}
*/