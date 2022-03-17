<?php
if (directus()->isLoggedIn() || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /');
}

unset($_SESSION['error']);

$email = $_POST['email'];
$password = $_POST['password'];

try {
    directus()->login($email, $password);

    header('Location: /');
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();

    header('Location: /?login');
}
