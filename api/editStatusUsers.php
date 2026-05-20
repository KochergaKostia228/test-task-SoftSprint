<?php
require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/repository/UserRepository.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $userRepository = new UserRepository($pdo);

    $ids = isset($data['ids']) ? $data['ids'] : [];

    if (count($ids) <= 0) {
        echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "No correct id"]]));
        exit;
    }

    $users = [];

    foreach ($data['ids'] as $id) {
        $user = $userRepository->findById($id);

        if (!$user) {
            echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "No such user exists"]]));
            exit;
        }

        $userRepository->updateStatus($id, $data["status"]);
        $users[] = $userRepository->findById($id);
    }

    echo(json_encode(["status" => true, "error" => null, "users" => $users]));
    exit;
} else {
    echo "No data submitted.";
}