<?php

// Simple PHP router

$request_uri = $_SERVER['REQUEST_URI'];

// Define a mapping of routes to corresponding PHP files
$routes = [
    '/' => 'home.php',
    '/login' => 'login.php',
    '/register' => 'register.php',
    '/my_account' => 'my_account.php',
];

// Determine the appropriate PHP file to include based on the request URI
if (array_key_exists($request_uri, $routes)) {
    include $routes[$request_uri];
} else {
    http_response_code(404);
    echo '404 Not Found';
}