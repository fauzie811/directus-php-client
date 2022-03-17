<?php if (!directus()->isLoggedIn()) {
    header('Location: /?login');
} ?>
<?php get_header(); ?>
<div class="px-8 py-6">
    <h1 class="text-2xl font-semibold">Posts</h1>

    <table class="mt-6 w-full">
        <thead>
            <tr class="border-b-2">
                <th class="px-4 py-2 text-left font-semibold">ID</th>
                <th class="px-4 py-2 text-left font-semibold">Title</th>
                <th class="px-4 py-2 text-left font-semibold">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $posts = directus()->getItems('posts');
            foreach ($posts as $post) {
            ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?php echo $post['id']; ?></td>
                    <td class="px-4 py-2">
                        <a class="text-indigo-600" href="/?posts/<?php echo $post['id']; ?>">
                            <?php echo $post['title']; ?>
                        </a>
                    </td>
                    <td class="px-4 py-2"><?php echo $post['status']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php get_footer(); ?>
