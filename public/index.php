<?php
/**
 * Main Application Router
 * Simple routing for native PHP project
 */

// Error reporting for development - disable on production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Automatic Session Start
session_start();

// Include database connection
require_once dirname(__DIR__) . '/config/db.php';

// Include Auth Helper
require_once dirname(__DIR__) . '/config/auth_helper.php';

// Define base path constants
define('BASE_PATH', dirname(__DIR__));
define('URL_ROOT', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . str_replace('index.php', '', $_SERVER['PHP_SELF']));

// Basic Router
$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Handle common routes
switch ($route) {
    case 'home':
        // Default Landing Page
        echo "<h1>Welcome to MotionVault</h1>";
        echo "<p>This is a native PHP project structure.</p>";
        echo "<ul>";
        echo "<li><a href='?route=auth/login'>Login</a></li>";
        echo "<li><a href='?route=auth/register'>Register</a></li>";
        echo "<li><a href='?route=creator/dashboard'>Creator Dashboard</a></li>";
        echo "</ul>";
        break;

    case 'auth/login':
        require_once BASE_PATH . '/auth/login.php';
        break;

    case 'auth/register':
        require_once BASE_PATH . '/auth/register.php';
        break;

    case 'auth/logout':
        require_once BASE_PATH . '/auth/logout.php';
        break;

    case 'creator/dashboard':
        require_once BASE_PATH . '/creator/index.php';
        break;

    default:
        // 404 Not Found
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>The route <strong>$route</strong> was not found on this server.</p>";
        echo "<a href='?route=home'>Back to Home</a>";
        break;
}
