<?php
namespace App\Components\Common;

//Maybe will be removed later

class LoadingSpinner {
    private const CLASSES = [
        'overlay' => 'fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50',
        'container' => 'fixed inset-0 z-50 flex items-center justify-center',
        'spinner_container' => 'transform -translate-y-1/2 sm:px-6 sm:px-0 sm:max-w-sm',
        'spinner_content' => 'relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-center shadow-xl transition-all sm:p-6',
        'spinner' => 'animate-spin h-12 w-12 text-blue-600',
        'text' => 'mt-4 text-sm font-medium text-gray-900'
    ];

    public static function render(string $message = 'Carregando...'): string {
        return "
        <div id='loadingSpinner' class='hidden'>
            <div class='" . self::CLASSES['overlay'] . "'></div>
            <div class='" . self::CLASSES['container'] . "'>
                <div class='" . self::CLASSES['spinner_container'] . "'>
                    <div class='" . self::CLASSES['spinner_content'] . "'>
                        <svg class='" . self::CLASSES['spinner'] . "' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>
                            <circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle>
                            <path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z'></path>
                        </svg>
                        <p class='" . self::CLASSES['text'] . "'>" . htmlspecialchars($message) . "</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
        class LoadingSpinner {
            static show(message = 'Carregando...') {
                const spinner = document.getElementById('loadingSpinner');
                const textElement = spinner.querySelector('p');
                textElement.textContent = message;
                spinner.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            static hide() {
                const spinner = document.getElementById('loadingSpinner');
                spinner.classList.add('hidden');
                document.body.style.overflow = '';
            }

            static async withLoading(promise, message = 'Carregando...') {
                try {
                    this.show(message);
                    return await promise;
                } finally {
                    this.hide();
                }
            }
        }
        </script>";
    }
}