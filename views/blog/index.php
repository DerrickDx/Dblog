<?php require VIEW_PATH . '/header.php'; ?>
<div>
    <a href="<?php echo URLROOT ; ?>">  <button>Back to Homepage</button></a>
    <a href="<?php echo URLROOT ; ?>admin">  <button>Admin</button></a>
</div>
<?php foreach($this->params as $post) : ?>
    <div>
        <h2><?php echo $post->title; ?></h2>
        <div>
            Created <?php echo is_null($post->username) ? '' : 'by '. $post->username; ?>  at <?php echo $post->post_created_at; ?>
        </div>
        <p><textarea readonly style="resize:none; width: 600px; height: 50px" ><?php $charLimit = 75; echo strlen($post->body) > $charLimit ? substr($post->body, 0, $charLimit) .'...' : $post->body; ?></textarea></p>

        <a href="<?php echo URLROOT; ?>blog/post?id=<?php echo $post->post_id; ?>">See Full Post</a>
        <div>
            <?php echo $post->comment_count . ' ' . ($post->comment_count > 1 ? 'comments' : 'comment'); ?>
        </div>
    </div>
<br>
<?php endforeach; ?>
<?php require VIEW_PATH . '/footer.php'; ?>
