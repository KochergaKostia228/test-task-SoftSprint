<?php
require_once(__DIR__ . '/db.php');
require_once (__DIR__. '/repository/UserRepository.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $userRepository = new UserRepository($pdo);

    if (!isset($data["first_name"]) || !isset($data["last_name"]) || !isset($data["status"]) || !isset($data["role"])) {
        echo(json_encode(["status" => false, "error" => ["code" => 500, "message" => "Not all required fields are filled"]]));
        exit;
    }

    $id = $userRepository->create($data["first_name"], $data["last_name"], $data["status"], $data["role"]);

    $user = $userRepository->findById($id);

    $html = "
        <tr data-id='$id'>
            <th scope='row'>
                <input class='form-check-input row-check' type='checkbox'>
            </th>
            <td class='first_name'>{$user['first_name']}</td>
            <td class='last_name'>{$user['last_name']}</td>
            <td class='status'>{$user['status']}</td>
            <td class='role'>{$user['role']}</td>
            <td>
                <button type='button' class='btn btn-warning btn-edit' data-bs-toggle='modal' data-bs-target='#userModal'>
                    Edit
                </button>
                <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal'>
                    Delete
                </button>
            </td>
        </tr>
    ";

    echo(json_encode(["status" => true, "error" => null, "html" => $html]));
    exit;
} else {
    echo "No data submitted.";
}