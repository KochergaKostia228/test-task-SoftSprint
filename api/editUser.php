<?php
require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/../repository/UserRepository.php');
require_once (__DIR__. '/../model/ResponseApi.php');
require_once (__DIR__. '/../model/roles.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userRepository = new UserRepository($pdo);

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($id <= 0) {
        echo(json_encode(new ResponseApi(false, ["code" => 500, "message" => "No correct id"])));
        exit;
    }

    $user = $userRepository->findById($id);

    if (!$user) {
        echo(json_encode(new ResponseApi(false, ["code" => 500, "message" => "No such user exists"])));
        exit;
    }

    if (!isset($_POST["first_name"], $_POST["last_name"], $_POST["status"], $_POST["role"])) {
        echo(json_encode(new ResponseApi(false, ["code" => 500, "message" => "Missing required fields"])));
        exit;
    }

    $userRepository->update($id, $_POST["first_name"], $_POST["last_name"], $_POST["status"], $_POST["role"]);

    $updatedUser = $userRepository->findById($id);

    $updatedUser['role'] = getRoles()[$updatedUser['role']] ?? null;

    echo(json_encode(new ResponseApi(true, null, ["user" => $updatedUser])));
    exit;
} else {
    echo "No data submitted.";
}