<?php
global $pdo;
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . "/controllers/usersTableController.php";

if (!isLoggedIn()) {
    redirect("login.php");
}

$controller = new UsersTableController();
$controller->handleRequest();
