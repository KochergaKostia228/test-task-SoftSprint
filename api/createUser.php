<?php
require_once(__DIR__ . '/db.php');
require_once (__DIR__. '/repository/UserRepository.php');
require_once (__DIR__. '/../model/roles.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $userRepository = new UserRepository($pdo);

    if (!isset($data["first_name"]) || !isset($data["last_name"]) || !isset($data["status"]) || !isset($data["role"])) {
        echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "Not all required fields are filled"]]));
        exit;
    }

    $id = $userRepository->create($data["first_name"], $data["last_name"], $data["status"], $data["role"]);

    $user = $userRepository->findById($id);

    echo(json_encode(["status" => true, "error" => null, "user" => $user]));
    exit;
} else {
    echo "No data submitted.";
}