<?php
require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/repository/UserRepository.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $userRepository = new UserRepository($pdo);

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

    if (!isset($data["first_name"], $data["last_name"], $data["status"], $data["role"])) {
        echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "Missing required fields"]]));
        exit;
    }

    $userRepository->update($id, $data["first_name"], $data["last_name"], $data["status"], $data["role"]);

    $updatedUser = $userRepository->findById($id);

    echo(json_encode(["status" => true, "error" => null, "user" => $updatedUser]));
    exit;
} else {
    echo "No data submitted.";
}