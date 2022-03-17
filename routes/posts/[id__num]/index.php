<?php
if (!directus()->isLoggedIn()) {
    header('Location: /?login');
}
$post = directus()->getItem('posts', $_GET['id']);
?>
<?php get_header(); ?>
<div class="px-8 py-6">
    <div class="flex items-center">
        <h1 class="text-2xl font-semibold">
            Posts / <?php echo $post['title']; ?>
        </h1>

        <form action="/?posts/<?php echo $_GET['id']; ?>/update" method="POST" class="ml-auto">
            <input type="hidden" name="status" value="<?php echo $post['status'] == 'draft' ? 'published' : 'draft'; ?>">
            <button class="px-4 py-2 bg-indigo-600 text-white" type="submit"><?php echo $post['status'] == 'draft' ? 'Publish' : 'Unpublish'; ?></button>
        </form>
    </div>
    <pre><?php echo htmlentities(json_encode($post, JSON_PRETTY_PRINT)); ?></pre>
</div>
<?php get_footer(); ?>
