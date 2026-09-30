<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$username = trim($_POST['email'] ?? '');

if ($username === '') {
    exit('Username is required');
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=phishing_test;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $stmt = $pdo->prepare(
        'INSERT INTO uloha (username) VALUES (:username)'
    );

    $stmt->execute([
        ':username' => $username
    ]);

    header('Location: login.html');
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection error');
}