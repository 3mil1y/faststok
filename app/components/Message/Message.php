<?php
namespace App\Components\Message;

//Probably gonna be removed later

class Message {
    private const CLASSES = [
        'container' => 'fixed bottom-0 right-0 z-50 m-6 max-w-sm',
        'message' => 'rounded-lg p-4 mb-4 shadow-lg transform transition-all duration-300 ease-in-out',
        'content' => 'flex items-center',
        'icon' => 'flex-shrink-0 w-5 h-5 mr-3',
        'text' => 'text-sm font-medium',
        'close' => 'ml-auto -mx-1.5 -my-1.5 p-1.5 hover:opacity-75 focus:outline-none',
        'success' => 'bg-green-50 text-green-800',
        'error' => 'bg-red-50 text-red-800',
        'warning' => 'bg-yellow-50 text-yellow-800',
        'info' => 'bg-blue-50 text-blue-800'
    ];

    private static array $messages = [];
    private static int $messageId = 0;

    public static function render(): string {
        return "
        <div id='messageContainer' class='" . self::CLASSES['container'] . "'></div>
        
        <script>
        class Message {
            static container = document.getElementById('messageContainer');
            static autoHideTimeout = 5000;
            static animationDuration = 300;

            static show(message, type = 'info') {
                const messageId = Date.now();
                const element = this.createMessageElement(message, type, messageId);
                
                this.container.appendChild(element);
                
                // Animate in
                requestAnimationFrame(() => {
                    element.style.transform = 'translateX(0)';
                    element.style.opacity = '1';
                });

                // Auto hide after timeout
                setTimeout(() => this.hide(messageId), this.autoHideTimeout);
                
                return messageId;
            }

            static hide(messageId) {
                const element = document.getElementById(`message-${messageId}`);
                if (!element) return;

                element.style.transform = 'translateX(100%)';
                element.style.opacity = '0';

                setTimeout(() => {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                }, this.animationDuration);
            }

            static createMessageElement(message, type, id) {
                const element = document.createElement('div');
                element.id = `message-${id}`;
                element.className = '" . self::CLASSES['message'] . " ' + this.getTypeClass(type);
                element.style.transform = 'translateX(100%)';
                element.style.opacity = '0';

                element.innerHTML = `
                    <div class='" . self::CLASSES['content'] . "'>
                        ${this.getIcon(type)}
                        <div class='" . self::CLASSES['text'] . "'>${message}</div>
                        <button type='button' 
                                class='" . self::CLASSES['close'] . "'
                                onclick='Message.hide(${id})'>
                            <span class='sr-only'>Fechar</span>
                            <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                                <path fill-rule='evenodd' d='M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z' clip-rule='evenodd'></path>
                            </svg>
                        </button>
                    </div>
                `;

                return element;
            }

            static getTypeClass(type) {
                switch(type) {
                    case 'success': return '" . self::CLASSES['success'] . "';
                    case 'error': return '" . self::CLASSES['error'] . "';
                    case 'warning': return '" . self::CLASSES['warning'] . "';
                    default: return '" . self::CLASSES['info'] . "';
                }
            }

            static getIcon(type) {
                const iconClass = '" . self::CLASSES['icon'] . "';
                switch(type) {
                    case 'success':
                        return `<svg class='${iconClass}' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'></path>
                        </svg>`;
                    case 'error':
                        return `<svg class='${iconClass}' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' clip-rule='evenodd'></path>
                        </svg>`;
                    case 'warning':
                        return `<svg class='${iconClass}' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z' clip-rule='evenodd'></path>
                        </svg>`;
                    default:
                        return `<svg class='${iconClass}' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z' clip-rule='evenodd'></path>
                        </svg>`;
                }
            }

            static success(message) {
                return this.show(message, 'success');
            }

            static error(message) {
                return this.show(message, 'error');
            }

            static warning(message) {
                return this.show(message, 'warning');
            }

            static info(message) {
                return this.show(message, 'info');
            }
        }
        </script>";
    }

    public static function success(string $message): void {
        self::$messages[] = [
            'type' => 'success',
            'message' => $message,
            'id' => ++self::$messageId
        ];
    }

    public static function error(string $message): void {
        self::$messages[] = [
            'type' => 'error',
            'message' => $message,
            'id' => ++self::$messageId
        ];
    }

    public static function warning(string $message): void {
        self::$messages[] = [
            'type' => 'warning',
            'message' => $message,
            'id' => ++self::$messageId
        ];
    }

    public static function info(string $message): void {
        self::$messages[] = [
            'type' => 'info',
            'message' => $message,
            'id' => ++self::$messageId
        ];
    }

    public static function getMessages(): array {
        $messages = self::$messages;
        self::$messages = [];
        return $messages;
    }
}