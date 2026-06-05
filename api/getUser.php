<?php

require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/../repository/UserRepository.php');
require_once (__DIR__. '/../model/ResponseApi.php');

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo json_encode(new ResponseApi(false, ["code" => 405, "message" => "Method not allowed"]));
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(new ResponseApi(false, ["code" => 400, "message" => "No correct id"]));
    exit;
}

$userRepository = new UserRepository($pdo);
$user = $userRepository->findById($id);

if (!$user) {
    echo json_encode(new ResponseApi(false, ["code" => 404, "message" => "No such user exists"]));
    exit;
}

echo json_encode(new ResponseApi(true, null, ["user" => $user]));