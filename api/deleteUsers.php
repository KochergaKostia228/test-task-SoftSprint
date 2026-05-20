<?php
require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/repository/UserRepository.php');

$userRepository = new UserRepository($pdo);

$data = json_decode(file_get_contents('php://input'), true);

$ids = isset($data['ids']) ? $data['ids'] : [];

if (count($ids) <= 0) {
    echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "No correct id"]]));
    exit;
}

foreach ($data['ids'] as $id) {
    $user = $userRepository->findById($id);

    if (!$user) {
        echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "No such user exists"]]));
        exit;
    }

    $userRepository->delete($id);
}

echo(json_encode(["status" => true, "error" => null, "ids" => $ids]));