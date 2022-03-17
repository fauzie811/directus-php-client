<?php if (directus()->isLoggedIn()) {
    header('Location: /');
} ?>
<?php get_header(); ?>
<div class="px-8 py-6">
    <div class="max-w-lg border border-gray-300 mx-auto">
        <div class="px-4 py-3 border-b border-gray-300">
            <h1 class="text-lg font-semibold">Login</h1>
        </div>
        <div class="p-4">
            <form action="/?auth/login" method="POST" class="space-y-4">
                <div>
                    <label class="block font-semibold" for="email">Email</label>
                    <input class="w-full border-gray-300" type="email" name="email" id="email" value="test@test.com">
                </div>

                <div>
                    <label class="block font-semibold" for="password">Password</label>
                    <input class="w-full border-gray-300" type="password" name="password" id="password" value="test">
                </div>

                <?php if (!empty($_SESSION['error'])) {
                    echo "<p class='text-red-600'>{$_SESSION['error']}</p>";
                } ?>

                <div>
                    <button class="px-4 py-2 bg-indigo-600 text-white" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php unset($_SESSION['error']); ?>
<?php get_footer(); ?>
