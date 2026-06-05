<?php

require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/../repository/UserRepository.php');
require_once(__DIR__ . '/../model/roles.php');
require_once(__DIR__ . '/../model/ResponseApi.php');

$userRepository = new UserRepository($pdo);

$first_name = $_POST["first_name"] ?? null;
$last_name = $_POST["last_name"] ?? null;
$status = $_POST["status"] ?? null;
$role = $_POST["role"] ?? null;

if (!$first_name || !$last_name || $status === null || $role === null) {
    echo json_encode(new ResponseApi(false, [
        "code" => 400,
        "message" => "Not all required fields are filled"
    ]));
    exit;
}

$id = $userRepository->create($first_name, $last_name, $status, $role);

$user = $userRepository->findById($id);
$user['role'] = getRoles()[$user['role']] ?? null;

echo json_encode(new ResponseApi(true, null, ["user" => $user]));
