<?php
namespace Components\Common;

class Popup {
    private const CLASSES = [
        'container' => 'fixed inset-0 flex items-center justify-center z-50',
        'overlay' => 'absolute inset-0 bg-black opacity-50',
        'modal' => 'bg-white rounded-lg p-4 shadow-lg w-full max-w-md',
        'close' => 'absolute top-2 right-2 text-gray-500 hover:text-gray-700',
        'title' => 'text-lg font-semibold mb-2',
        'content' => 'text-gray-700 mb-4',

        'button' => 'bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700',
        'button_close' => 'bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700',
    ];

    private static function gerarOverlay(): string {
        return "<div class='" . self::CLASSES['overlay'] . "'></div>";
    }

    private static function gerarModal(string $titulo, string $conteudo): string {
        return "<div class='" . self::CLASSES['modal'] . "'>
            <div class='" . self::CLASSES['close'] . "'>    
                <button class='" . self::CLASSES['button_close'] . "' onclick='closePopup()'>&times;</button>
            </div>
            <div class='" . self::CLASSES['title'] . "'>
                <h2>" . $titulo . "</h2>
            </div>
            <div class='" . self::CLASSES['content'] . "'>
                " . $conteudo . "
            </div>
            <div class='" . self::CLASSES['button_container'] . "'>
                <button class='" . self::CLASSES['button'] . "' onclick='closePopup()'> close </button>
            </div>
        </div>";
    }

    private static function gerarScript(): string {
        return "<script>
            function closePopup() {
                document.querySelector('.popup').style.display = 'none';
            }
        </script>";
    }

    public static function render(string $titulo, string $conteudo): string {
        return "<div class='" . self::CLASSES['container'] . "'>
            " . self::gerarOverlay() . "
            " . self::gerarModal($titulo, $conteudo) . "
        </div>";
    }
    
}