<?php
require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/../repository/UserRepository.php');
require_once (__DIR__. '/../model/ResponseApi.php');

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

$userRepository->delete($id);

echo(json_encode(new ResponseApi(true, null, ["id" => $id])));