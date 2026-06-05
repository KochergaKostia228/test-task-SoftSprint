<?php
require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/../repository/UserRepository.php');
require_once (__DIR__. '/../model/ResponseApi.php');

$userRepository = new UserRepository($pdo);

$ids = isset($_POST['ids']) ? $_POST['ids'] : [];

if (count($ids) <= 0) {
    echo(json_encode(new ResponseApi(false, ["code" => 500, "message" => "No correct id"])));
    exit;
}

foreach ($ids as $id) {
    $user = $userRepository->findById($id);

    if (!$user) {
        echo(json_encode(new ResponseApi(false, ["code" => 500, "message" => "No such user exists"])));
        exit;
    }

    $userRepository->delete($id);
}

echo(json_encode(new ResponseApi(true, null, ["ids" => $ids])));