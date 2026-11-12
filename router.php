<?php
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rawurldecode($path);

$routes = [
    '/' => '/index.php',
    '/index.php' => '/index.php',
    '/skills.php' => '/skills.php',
    '/projects.php' => '/projects.php',
    '/contact.php' => '/contact.php',
    '/admin/login.php' => '/admin/login.php',
    '/admin/logout.php' => '/admin/logout.php',
    '/admin/dashboard.php' => '/admin/dashboard.php',
    '/admin/projects.php' => '/admin/projects.php',
    '/admin/skills.php' => '/admin/skills.php',
    '/admin/messages.php' => '/admin/messages.php',
];

if (!isset($routes[$path])) {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

require __DIR__ . $routes[$path];
