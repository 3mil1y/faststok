<?php

namespace App\Core;

use App\Components\Layout\Layout;
use App\Components\Message\Message;

abstract class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        
        //ob_start();
        include_once "../app/views/{$view}.php";
       // $content = ob_get_clean();
        
        //echo Layout::render($data['title'] ?? 'FastStok', $content);
    }

    protected function redirect(string $url) {
        header("Location:" . self::getBaseUrl() . $url);
        exit;
    }

    protected function redirectWithSuccess(string $url, string $title, string $content = ''): void {
        $this->redirect($url, 'success', $title, $content);
    }

    protected function redirectWithError(string $url, string $title, string $content = ''): void {
        $this->redirect($url, 'error', $title, $content);
    }

    protected function redirectWithWarning(string $url, string $title, string $content = ''): void {
        $this->redirect($url, 'warning', $title, $content);
    }

    protected function redirectWithInfo(string $url, string $title, string $content = ''): void {
        $this->redirect($url, 'info', $title, $content);
    }

    protected static function getBaseUrl(): string {
        return "http://" . $_SERVER['HTTP_HOST'] . "/test/faststok/";
    }

    protected static function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected static function inInterval(int|float $value, int|float $min, int|float $max): bool {
        return ($value >= $min && $value <= $max) ? true : false;
    }

    protected static function anyNull(...$values): bool {
        return in_array(null, $values, true);
    }

    protected static function equalInputs(array $fields): bool {
        if($fields[0] === $fields[1]) {
            return true;
        }
        return false;
    }

    protected static function anyInputNull(array $fields): bool {
        foreach ($fields as $field) {
            if (self::input($field) === null) {
                return true;
            }
        }
        return false;
    }

    protected static function inputsInRange(array $inputRanges): bool {
        foreach ($inputRanges as $input => [$min, $max]) {
            if (!self::inInterval(self::input($input), $min, $max)) {
                return false;
            }
        }
        return true;
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}

/*Implementação pra depois (ESSA PORRA É DO GEPETO, ELE SOLTOU ALEATORIAMENTE, NÂO USA SEM CONFERIR)

protected function validateMultipleInputs(array $inputMatrix): ?string {
    foreach ($inputMatrix as $inputKey => $rule) {
        $value = self::input($inputKey);

        // Validação de campo obrigatório
        if (($rule['required'] ?? false) && ($value === null || $value === '')) {
            return "O campo '$inputKey' é obrigatório.";
        }

        // Validação de intervalo (numérico ou alfabético)
        if (isset($rule['range']) && $value !== null) {
            [$min, $max] = $rule['range'];

            // Detecta se é letra
            if (ctype_alpha($min) && ctype_alpha($max) && is_string($value)) {
                $char = strtoupper($value);
                if (ord($char) < ord(strtoupper($min)) || ord($char) > ord(strtoupper($max))) {
                    return "O campo '$inputKey' deve estar entre '$min' e '$max'.";
                }
            }
            // Numérico
            elseif (is_numeric($min) && is_numeric($max) && is_numeric($value)) {
                if ($value < $min || $value > $max) {
                    return "O campo '$inputKey' deve estar entre $min e $max.";
                }
            }
        }

        // Validação de diferença entre campos
        if (isset($rule['must_differ_from']) && $value !== null) {
            $other = self::input($rule['must_differ_from']);
            if ($value == $other) {
                return "O campo '$inputKey' deve ser diferente de '{$rule['must_differ_from']}'.";
            }
        }
    }

    return null;
}

*/