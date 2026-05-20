<?php
require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/repository/UserRepository.php');

$userRepository = new UserRepository($pdo);

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) ? (int) $data['id'] : 0;

if ($id <= 0) {
    echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "No correct id"]]));
    exit;
}

$user = $userRepository->findById($id);

if (!$user) {
    echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "No such user exists"]]));
    exit;
}

$userRepository->delete($id);

echo(json_encode(["status" => true, "error" => null, "id" => $id]));