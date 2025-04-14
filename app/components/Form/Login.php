<?php
namespace App\Components\Form;

class Login {
    private const CLASSES = [
        'container' => 'min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8',
        'form_container' => 'max-w-md w-full space-y-8',
        'header' => 'text-center',
        'logo' => 'mx-auto h-12 w-auto text-blue-600',
        'title' => 'mt-6 text-3xl font-extrabold text-gray-900',
        'subtitle' => 'mt-2 text-sm text-gray-600',
        'form' => 'mt-8 space-y-6',
        'input_group' => 'rounded-md shadow-sm -space-y-px',
        'input_first' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm',
        'input_last' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm',
        'button' => 'group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'button_icon' => 'h-5 w-5 text-blue-500 group-hover:text-blue-400',
        'error' => 'rounded-md bg-red-50 p-4 mt-4',
        'error_text' => 'text-sm text-red-700'
    ];

    public static function render(string $action, string $error = ''): string {
        $errorMessage = '';
        if ($error) {
            $errorMessage = "
                <div class='" . self::CLASSES['error'] . "'>
                    <p class='" . self::CLASSES['error_text'] . "'>{$error}</p>
                </div>";
        }

        return "
        <div class='" . self::CLASSES['container'] . "'>
            <div class='" . self::CLASSES['form_container'] . "'>
                <div class='" . self::CLASSES['header'] . "'>
                    <svg class='" . self::CLASSES['logo'] . "' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'/>
                    </svg>
                    <h2 class='" . self::CLASSES['title'] . "'>FastStok</h2>
                    <p class='" . self::CLASSES['subtitle'] . "'>Faça login para acessar o sistema</p>
                </div>

                {$errorMessage}

                <form class='" . self::CLASSES['form'] . "' action='{$action}' method='POST'>
                    <div class='" . self::CLASSES['input_group'] . "'>
                        <input id='login' name='login' type='text' required 
                            class='" . self::CLASSES['input_first'] . "'
                            placeholder='Login'>
                            
                        <input id='password' name='password' type='password' required
                            class='" . self::CLASSES['input_last'] . "'
                            placeholder='Senha'>
                    </div>

                    <button type='submit' class='" . self::CLASSES['button'] . "'>
                        Entrar
                    </button>
                </form>
            </div>
        </div>";
    }
}