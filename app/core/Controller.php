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

    protected function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected static function anyNull(...$values): bool {
        return in_array(null, $values, true);
    }

    protected static function inInterval(int|float $value, int|float $min, int|float $max): bool {
        return ($value >= $min && $value <= $max) ? true : false;
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}