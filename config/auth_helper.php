<?php
/**
 * Auth Helper - For Authentication Checks and Middleware
 */

/**
 * Check if a user is logged in
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if a user has a specific role
 * @param array|string $roles
 * @return bool
 */
function has_role($roles) {
    if (!is_logged_in() || !isset($_SESSION['user_role'])) return false;
    
    $userRole = $_SESSION['user_role'];
    
    if (is_array($roles)) {
        return in_array($userRole, $roles);
    }
    return $userRole === $roles;
}

/**
 * Require Login - Redirect if not logged in
 */
function require_login() {
    if (!is_logged_in()) {
        header("Location: ?route=auth/login");
        exit();
    }
}

/**
 * Require Role - Redirect if user doesn't have the required role
 * @param array|string $roles
 */
function require_role($roles) {
    require_login();
    
    if (!has_role($roles)) {
        // Forbidden or show message
        http_response_code(403);
        die("403 Forbidden: Anda tidak memiliki akses ke halaman ini.");
    }
}
