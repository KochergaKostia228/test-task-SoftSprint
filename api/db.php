<?php
    $host = 'sql107.infinityfree.com';
    $db   = 'if0_41977089_test_task';
    $user = 'if0_41977089';
    $pass = 'cC2SLNnfY7l2Dr';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
