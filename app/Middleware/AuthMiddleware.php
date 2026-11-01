<?php

namespace App\Middleware;

class AuthMiddleware
{
    /**
     * Require an authenticated user.
     */
    public static function requireAuth(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Require a guest (unauthenticated user).
     */
    public static function requireGuest(): void
    {
        if (!empty($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
    }

    /**
     * Require one or more specific roles.
     */
    public static function requireRole(
        array $allowedRoles
    ): void {

        self::requireAuth();

        $userRoles = $_SESSION['roles'] ?? [];

        if (empty(array_intersect(
            $allowedRoles,
            $userRoles
        ))) {
            http_response_code(403);
            exit('403 - Access Denied');
        }
    }
}
