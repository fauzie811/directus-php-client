<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>
<body>
    <nav class="fixed w-full left-0 top-0 bg-white border-b shadow h-16 flex items-center px-4">
        <a class="transition px-4 py-2 hover:bg-gray-100 rounded" href="/">Home</a>
        <a class="transition px-4 py-2 hover:bg-gray-100 rounded" href="/?posts">Posts</a>

        <?php
        if (!directus()->isLoggedIn()) {
            echo '<a class="ml-auto transition px-4 py-2 hover:bg-gray-100 rounded" href="/?login">Login</a>';
        } else {
            echo '<a class="ml-auto transition px-4 py-2 hover:bg-gray-100 rounded" href="/?auth/logout">Logout</a>';
        }
        ?>
    </nav>
    <main class="pt-16">