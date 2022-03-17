


<?php foreach($this->params as $post) : ?>
    <div class="card card-body mb-3">
        <h2 class="card-title"><?php echo $post->title; ?></h2>
        <div class="bg-light p-2 mb-3">
            Created <?php echo is_null($post->username) ? '' : 'by '. $post->username; ?>  at <?php echo $post->post_created_at; ?>
        </div>
<!--        <p class="card-text">--><?php //echo $post->body; ?><!--</p>-->
        <p><textarea readonly style="resize:none; width: 600px; height: 50px" ><?php $charLimit = 75; echo strlen($post->body) > $charLimit ? substr($post->body, 0, $charLimit) .'...' : $post->body; ?></textarea></p>

        <a class="btn btn-dark" href="<?php echo URLROOT; ?>posts/details?id=<?php echo $post->post_id; ?>">See Full Post</a>
        <div class="bg-light p-2 mb-3">
            <?php echo $post->comment_count . ' ' . ($post->comment_count > 1 ? 'comments' : 'comment'); ?>
        </div>
    </div>
<br>
<?php endforeach; ?>
<br>
<div class="card card-body mb-3">
    <a href="<?php echo URLROOT ; ?>" class="btn btn-light mb-3"><i class="fa fa-backward" aria-hidden="true"></i>  <button>Back</button></a>
</div>

<!--<form action="/upload" method="post" enctype="multipart/form-data">-->
<!--    <input type="file" name="receipt">-->
<!--    <button type="submit">Upload</button>-->
<!--</form>-->