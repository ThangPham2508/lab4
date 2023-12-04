<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/$class.php";
});

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if ($parts[4] != "products") {
    http_response_code(404);
    exit;
}

$id = $parts[5] ?? null;

$database = new Database("localhost", "root", "wedededwe", "shop");

$gateway = new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);

?>











