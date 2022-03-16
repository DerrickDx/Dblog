


<?php foreach($this->params as $post) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $post->title; ?></h4>
        <div class="bg-light p-2 mb-3">
            Posted by <?php echo $post->username; ?> at <?php echo $post->post_created_at; ?>
        </div>
        <p class="card-text"><?php echo $post->body; ?></p>
        <a class="btn btn-dark" href="<?php echo URLROOT; ?>posts/<?php echo $post->post_id; ?>">More</a>
    </div>
<?php endforeach; ?>


<!--<form action="/upload" method="post" enctype="multipart/form-data">-->
<!--    <input type="file" name="receipt">-->
<!--    <button type="submit">Upload</button>-->
<!--</form>-->