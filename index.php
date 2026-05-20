<?php
require_once 'api/db.php';
require_once 'api/repository/UserRepository.php';

$userRepository = new UserRepository($pdo);
$users = $userRepository->getAllUsers();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <?php include 'components/options.php' ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        <input class="form-check-input" type="checkbox" id="allCheck">
                    </th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Status</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTable">
                <?php foreach ($users as $user): ?>
                    <tr data-id="<?= $user['id']; ?>">
                        <th scope="row">
                            <input class="form-check-input row-check" type="checkbox">
                        </th>
                        <td class="first_name"><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td class="last_name"><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td class="status"><?php echo htmlspecialchars($user['status']); ?></td>
                        <td class="role"><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#userModal">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php include 'components/options.php' ?>
    </div>

    <?php include 'components/modals/userModal.php'; ?>
    <?php include 'components/modals/deleteModal.php'; ?>
    <?php include 'components/modals/optionsErrorModal.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/deleteUser.js"></script>
    <script src="js/options.js"></script>
    <script src="js/allCheck.js"></script>
</body>

</html>