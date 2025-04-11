<?php
namespace Components\Form;

class LoginForm {
    private const CLASSES = [
        'container' => 'min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 py-12 px-4 sm:px-6 lg:px-8',
        'form_container' => 'max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg',
        'header' => 'text-center',
        'title' => 'text-3xl font-extrabold text-gray-900 mb-2',
        'subtitle' => 'text-sm text-gray-600',
        'form' => 'mt-8 space-y-6',
        'input_group' => 'space-y-4',
        'input_label' => 'block text-sm font-medium text-gray-700',
        'input' => 'appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-colors duration-200',
        'button' => 'group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm',
        'button_icon' => 'absolute left-0 inset-y-0 flex items-center pl-3',
        'error' => 'mt-2 text-sm text-red-600'
    ];

    public static function render(): string {
        return "
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['form_container'] . "'>
                    <div class='" . self::CLASSES['header'] . "'>
                        <h2 class='" . self::CLASSES['title'] . "'>FastStok</h2>
                        <p class='" . self::CLASSES['subtitle'] . "'>Sistema de Controle de Estoque</p>
                    </div>
                    <form class='" . self::CLASSES['form'] . "' action='/validacoes/login.php' method='POST'>
                        <div class='" . self::CLASSES['input_group'] . "'>
                            <div>
                                <label for='username' class='" . self::CLASSES['input_label'] . "'>Usuário</label>
                                <input id='username' name='username' type='text' required 
                                    class='" . self::CLASSES['input'] . "' 
                                    placeholder='Digite seu usuário' />
                            </div>
                            <div>
                                <label for='password' class='" . self::CLASSES['input_label'] . "'>Senha</label>
                                <input id='password' name='password' type='password' required 
                                    class='" . self::CLASSES['input'] . "' 
                                    placeholder='Digite sua senha' />
                            </div>
                        </div>

                        <div>
                            <button type='submit' class='" . self::CLASSES['button'] . "'>
                                <span class='" . self::CLASSES['button_icon'] . "'>
                                    <svg class='h-5 w-5 text-blue-500 group-hover:text-blue-400' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                        <path fill-rule='evenodd' d='M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z' clip-rule='evenodd' />
                                    </svg>
                                </span>
                                Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>";
    }
}

/* Código original
namespace Components;

class LoginForm {

    private static function gerarMsgErroDeLogin($error): string {
        return "<div class='text-red-600 text-sm mb-3'>{$error}</div>";
    }

    public static function gerar(string $action, string $error = null): string {
        $errorMessage = $error ? $this->gerarMsgErroDeLogin($error) : '';

        $form = "
        <div class='flex items-center justify-center min-h-screen bg-gray-200'>
            <div class='p-4 bg-white rounded-2xl shadow-lg w-full sm:w-9/12 md:w-4/5 lg:w-1/3 max-w-md'>
                <h2 class='text-xl font-semibold mb-3 text-center'>Login</h2>
                {$errorMessage}
                <form action='{$action}' method='post'>
                    <input type='text' name='login' class='w-full p-2 border rounded-lg mb-3 bg-gray-100' placeholder='Nome de usuário' required/>
                    <input type='password' name='senha' class='w-full p-2 border rounded-lg mb-3 bg-gray-100' placeholder='Senha' required/>
                    <button type='submit' class='w-full mt-3 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700'>Entrar</button>
                </form>
            </div>
        </div>";
        
        return $form;
    }
}
*/