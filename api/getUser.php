<?php

header('Content-Type: application/json');

require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/repository/UserRepository.php');

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo json_encode([
        "status" => false,
        "error" => [
            "code" => 405,
            "message" => "Method not allowed"
        ]
    ]);
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode([
        "status" => false,
        "error" => [
            "code" => 400,
            "message" => "No correct id"
        ]
    ]);
    exit;
}

$userRepository = new UserRepository($pdo);
$user = $userRepository->findById($id);

if (!$user) {
    echo json_encode([
        "status" => false,
        "error" => [
            "code" => 404,
            "message" => "No such user exists"
        ]
    ]);
    exit;
}

echo json_encode([
    "status" => true,
    "error" => null,
    "user" => $user
]);