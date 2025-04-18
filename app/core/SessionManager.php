<?php
namespace App\Core;

use App\Entities\User;

class SessionManager {
    private const USER_ID_KEY = 'user_id';
    private const USER_ROLE_KEY = 'user_role';
    private const USER_LOGIN_KEY = 'user_login';

    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destroy(): void {
        self::start();
        session_destroy();
    }

    public static function setUser(User $user): void {
        self::start();
        $_SESSION[self::USER_ID_KEY] = $user->getId();
        $_SESSION[self::USER_ROLE_KEY] = $user->getRole();
        $_SESSION[self::USER_LOGIN_KEY] = $user->getLogin();
    }

    public static function getUser(): ?array {
        self::start();
        if (!isset($_SESSION[self::USER_ID_KEY])) {
            return null;
        }

        return [
            'id' => $_SESSION[self::USER_ID_KEY],
            'role' => $_SESSION[self::USER_ROLE_KEY],
            'login' => $_SESSION[self::USER_LOGIN_KEY]
        ];
    }

    public static function isAuthenticated(): bool {
        self::start();
        return isset($_SESSION[self::USER_ID_KEY]);
    }

    public static function isAdmin(): bool {
        self::start();
        return isset($_SESSION[self::USER_ROLE_KEY]) && $_SESSION[self::USER_ROLE_KEY] === 'admin';
    }

    public static function logout(): void {
        self::destroy();
    }
}