<?php
require_once __DIR__ . "/controllers/registerController.php";
require_once __DIR__ . '/includes/helpers.php';


if (isLoggedIn()) {
    redirect("todo.php");
}

$controller = new RegisterController();
$controller->handleRequest();
