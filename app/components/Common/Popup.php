<?php
namespace App\Components\Common;

//Probably gonna be removed later

class Popup {
    private const CLASSES = [
        'overlay' => 'fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40',
        'container' => 'fixed inset-0 z-50 overflow-y-auto',
        'dialog' => 'flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0',
        'content' => 'relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg',
        'header' => 'bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4',
        'header_content' => 'sm:flex sm:items-start',
        'icon_container' => 'mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10',
        'icon' => 'h-6 w-6',
        'title' => 'text-lg font-medium leading-6 text-gray-900',
        'body' => 'px-4 pb-4 sm:p-6 sm:pb-4',
        'footer' => 'bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6',
        'button' => 'inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold shadow-sm sm:ml-3 sm:w-auto',
        'button_primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'button_danger' => 'bg-red-600 text-white hover:bg-red-700',
        'button_secondary' => 'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'
    ];

    // public static function render(): string {
    //     return "
    //     <div id='popup' class='hidden'>
    //         <div class='" . self::CLASSES['overlay'] . "'></div>
    //         <div class='" . self::CLASSES['container'] . "'>
    //             <div class='" . self::CLASSES['dialog'] . "'>
    //                 <div class='" . self::CLASSES['content'] . "'>
    //                     <div id='popupContent'></div>
    //                 </div>
    //             </div>
    //         </div>
    //     </div>

    //     <script>
    //     class Popup {
    //         static currentId = null;

    //         static show(options) {
    //             const {
    //                 title,
    //                 content,
    //                 type = 'info',
    //                 confirmButton = 'Confirmar',
    //                 cancelButton = 'Cancelar',
    //                 onConfirm = null,
    //                 onCancel = null,
    //                 showCancel = true
    //             } = options;

    //             const id = Date.now();
    //             this.currentId = id;

    //             const popup = document.getElementById('popup');
    //             const popupContent = document.getElementById('popupContent');

    //             const iconClass = type === 'danger' ? 'bg-red-100' : 'bg-blue-100';
    //             const iconColor = type === 'danger' ? 'text-red-600' : 'text-blue-600';
                
    //             popupContent.innerHTML = `
    //                 <div class='" . self::CLASSES['header'] . "'>
    //                     <div class='" . self::CLASSES['header_content'] . "'>
    //                         <div class='" . self::CLASSES['icon_container'] . " ${iconClass}'>
    //                             ${this.getIcon(type)}
    //                         </div>
    //                         <div class='mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left'>
    //                             <h3 class='" . self::CLASSES['title'] . "'>${title}</h3>
    //                         </div>
    //                     </div>
    //                 </div>
    //                 <div class='" . self::CLASSES['body'] . "'>
    //                     ${content}
    //                 </div>
    //                 <div class='" . self::CLASSES['footer'] . "'>
    //                     <button type='button' 
    //                             class='" . self::CLASSES['button'] . " ${type === 'danger' ? '" . self::CLASSES['button_danger'] . "' : '" . self::CLASSES['button_primary'] . "'}' 
    //                             onclick='Popup.handleConfirm(${id})'>
    //                         ${confirmButton}
    //                     </button>
    //                     ${showCancel ? `
    //                         <button type='button' 
    //                                 class='" . self::CLASSES['button'] . " " . self::CLASSES['button_secondary'] . "' 
    //                                 onclick='Popup.handleCancel(${id})'>
    //                             ${cancelButton}
    //                         </button>
    //                     ` : ''}
    //                 </div>
    //             `;

    //             popup.classList.remove('hidden');
    //             document.body.style.overflow = 'hidden';

    //             this.callbacks = this.callbacks || {};
    //             this.callbacks[id] = { onConfirm, onCancel };

    //             return id;
    //         }

    //         static hide(id) {
    //             if (id !== this.currentId) return;
                
    //             const popup = document.getElementById('popup');
    //             popup.classList.add('hidden');
    //             document.body.style.overflow = '';
                
    //             if (this.callbacks[id]) {
    //                 delete this.callbacks[id];
    //             }
    //         }

    //         static handleConfirm(id) {
    //             if (this.callbacks[id]?.onConfirm) {
    //                 this.callbacks[id].onConfirm();
    //             }
    //             this.hide(id);
    //         }

    //         static handleCancel(id) {
    //             if (this.callbacks[id]?.onCancel) {
    //                 this.callbacks[id].onCancel();
    //             }
    //             this.hide(id);
    //         }

    //         static getIcon(type) {
    //             const iconClass = '" . self::CLASSES['icon'] . " ' + (type === 'danger' ? 'text-red-600' : 'text-blue-600');
    //             return type === 'danger' 
    //                 ? `<svg class='${iconClass}' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
    //                     <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/>
    //                    </svg>`
    //                 : `<svg class='${iconClass}' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
    //                     <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'/>
    //                    </svg>`;
    //         }

    //         static confirm(options) {
    //             return new Promise((resolve) => {
    //                 this.show({
    //                     ...options,
    //                     onConfirm: () => resolve(true),
    //                     onCancel: () => resolve(false)
    //                 });
    //             });
    //         }

    //         static alert(options) {
    //             return this.show({
    //                 ...options,
    //                 showCancel: false
    //             });
    //         }
    //     }
    //     </script>";
    // }
}