<?php
if (!directus()->isLoggedIn() || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /');
}

$id = $_GET['id'];
$status = $_POST['status'];

try {
    directus()->updateItem('posts', $id, compact('status'));
} catch (Exception $e) {
    echo $e->getMessage();
    // $_SESSION['error'] = $e->getMessage();
}
header("Location: /?posts/$id");
