<?php

namespace App\Models;

use App\Core\Database\Database;
use App\Entities\User;
use Exception;

class UserModel {
    /**
     * Create a new user in the database
     */
    public static function create(User $user): bool {
        try {
            $sql = "INSERT INTO user (login, password, role) VALUES (?, ?, ?)";
            $params = [
                $user->getlogin(),
                password_hash($user->getPassword(), PASSWORD_DEFAULT),
                $user->getRole()
            ];
            
            Database::executePrepared($sql, "sss", $params);
            
           // $id = Database::getLastInsertId();
            $user->setId(Database::getLastInsertId());
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
    }

    /**
     * List all users
     */
    public static function list(): array {
        try {
            $sql = "SELECT id, login, role FROM user ORDER BY login";
            $result = Database::query($sql);
            
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = self::mapToUser($row);
            }
            
            return $users;
        } catch (Exception $e) {
            throw new Exception("Error listing users: " . $e->getMessage());
        }
    }

    /**
     * Find user by ID
     */
    public static function getById(int $id): ?User {
        try {
            $sql = "SELECT id, login, role FROM user WHERE id = ?";
            $params = [$id];
            
            $result = Database::executePrepared($sql, "i", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToUser($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Error finding user: " . $e->getMessage());
        }
    }

    /**
     * Find user by login
     */
    public static function getByLogin(string $login): ?User {
        try {
            $sql = "SELECT id, login, role FROM user WHERE login = ?";
            //$params = [$login];
            
            $result = Database::executePrepared($sql, "s", [$login]);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToUser($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Error finding user: " . $e->getMessage());
        }
    }

    /**
     * Update user details
     */
    public static function update(User $user): bool {
        try {
            $sql = "UPDATE user SET login = ?, role = ? WHERE id = ?";
            $params = [
                $user->getlogin(),
                $user->getRole(),
                $user->getId()
            ];
            
            Database::executePrepared($sql, "ssi", $params);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao validar login: " . $e->getMessage());
        }
    }

    /**
     * Update user role
     */
    public static function updateRole(int $userId, string $newRole): bool {
        try {
            $sql = "UPDATE user SET role = ? WHERE id = ?";
            $params = [
                $newRole,
                $userId
            ];
            
            Database::executePrepared($sql, "si", $params);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar permissão: " . $e->getMessage());
        }
    }

    /**
     * Verify user credentials
     */
    public static function validateLogin(string $login, string $password): ?User {
        try {
            $sql = "SELECT * FROM user WHERE login = ?";
            $params = [$login];
            
            $result = Database::executePrepared($sql, "s", $params);
            
            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    return self::mapToUser($row);
                }
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Error verifying credentials: " . $e->getMessage());
        }
    }

    /**
     * Delete a user
     */
    public static function delete(int $id): bool {
        try {
            $sql = "DELETE FROM user WHERE id = ?";
            $params = [$id];
            Database::executePrepared($sql, "i", $params);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }

    /**
     * Map database row to User entity
     */
    private static function mapToUser(array $row): User {
        return new User(
            $row['login'],
            $row['password'] ?? '',
            $row['role'],
            $row['id']
        );
    }
}