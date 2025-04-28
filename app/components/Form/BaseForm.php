<?php
namespace App\Components\Form;

abstract class BaseForm {
    protected const CLASSES = [
        'form' => 'space-y-6 bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto',
        'title' => 'text-2xl font-bold text-gray-900 mb-6',
        'subtitle' => 'text-sm text-gray-600 mb-4',
        'section' => 'space-y-4',
        'section_title' => 'text-lg font-medium text-gray-900',
        'grid' => 'grid grid-cols-1 md:grid-cols-2 gap-4',
        'input_group' => 'space-y-1',
        'label' => 'block text-sm font-medium text-gray-700',
        'input' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'select' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'textarea' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm',
        'error' => 'mt-1 text-sm text-red-600',
        'success' => 'mt-1 text-sm text-green-600',
        'hint' => 'mt-1 text-sm text-gray-500',
        'button_group' => 'flex justify-end space-x-3 mt-6',
        'button' => 'inline-flex justify-center rounded-md border border-transparent py-2 px-4 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2',
        'button_primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'button_secondary' => 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 focus:ring-blue-500',
        'button_danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500'
    ];

    protected static function generateTextInput(string $name, string $label, string $value = '', array $attributes = []): string {
        $attrs = self::buildAttributes(array_merge([
            'type' => 'text',
            'id' => $name,
            'name' => $name,
            'value' => $value,
            'class' => self::CLASSES['input']
        ], $attributes));

        return self::wrapInputGroup($label, "<input {$attrs}>");
    }

    protected static function generateSelect(string $name, string $label, array $options, string $selected = '', array $attributes = [], string $default = ''): string {
        $attrs = self::buildAttributes(array_merge([
            'id' => $name,
            'name' => $name,
            'class' => self::CLASSES['select']
        ], $attributes));

        $optionsHtml = '';
        if(isset($default) && $default != '' && $selected == '') {
            $optionsHtml .= "<option value='' disabled selected>{$default}</option>";
        }
        foreach ($options as $value => $text) {
            $isSelected = $value == $selected ? ' selected' : '';
            $optionsHtml .= "<option value='{$value}'{$isSelected}>{$text}</option>";
        }

        return self::wrapInputGroup($label, "<select {$attrs}>{$optionsHtml}</select>");
    }

    protected static function generateTextarea(string $name, string $label, string $value = '', array $attributes = []): string {
        $attrs = self::buildAttributes(array_merge([
            'id' => $name,
            'name' => $name,
            'class' => self::CLASSES['textarea'],
            'rows' => '3'
        ], $attributes));

        return self::wrapInputGroup($label, "<textarea {$attrs}>{$value}</textarea>");
    }

    protected static function generateOptions(array $items, string $defaultLabel = ''): string {
        $options = $defaultLabel ? "<option value=''>{$defaultLabel}</option>" : '';
        foreach ($items as $item) {
            $value = is_array($item) ? $item['id'] : $item;
            $label = is_array($item) ? $item['name'] : $item;
            $options .= "<option value='{$value}'>{$label}</option>";
        }
        return $options;
    }

    private static function buildAttributes(array $attributes): string {
        $attrs = [];
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $attrs[] = $key;
            } elseif ($value !== false && $value !== null) {
                $attrs[] = "{$key}='{$value}'";
            }
        }
        return implode(' ', $attrs);
    }

    private static function wrapInputGroup(string $label, string $input): string {
        return "
            <div class='" . self::CLASSES['input_group'] . "'>
                <label class='" . self::CLASSES['label'] . "'>{$label}</label>
                {$input}
            </div>";
    }

    abstract public static function render(string $action, array $params = []): string;
}