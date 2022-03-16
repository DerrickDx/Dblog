

<?php //foreach($this->params as $post) : ?>
<!--    <div class="card card-body mb-3">-->
<!--        <h4 class="card-title">--><?php //echo $post->title; ?><!--</h4>-->
<!--        <div class="bg-light p-2 mb-3">-->
<!--            Posted by --><?php //echo $post->username; ?><!-- at --><?php //echo $post->post_created_at; ?>
<!--        </div>-->
<!--        <p class="card-text">--><?php //echo $post->body; ?><!--</p>-->
<!--        <a class="btn btn-dark" href="--><?php //echo URLROOT; ?><!--/posts/show/--><?php //echo $post->post_id; ?><!--">More</a>-->
<!--    </div>-->
<?php //endforeach; ?>


<br>
<h1><?php echo $this->params['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?php echo $this->params['post']->username; ?> at <?php echo $this->params['post']->post_created_at; ?>
</div>
<p><?php echo $this->params['post']->body; ?></p>

<?php foreach($this->params['comments'] as $comment) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $comment->message; ?></h4>
        <div class="bg-light p-2 mb-3">
            Commented by <?php echo $comment->commenter; ?> at <?php echo $comment->comment_created_at; ?>
        </div>
        <p class="card-text"><?php echo $comment->message; ?></p>
<!--        <a class="btn btn-dark" href="--><?php //echo URLROOT; ?><!--/posts/show/--><?php //echo $comment->comment_id; ?><!--">Sth</a>-->
    </div>
<?php endforeach; ?>
<?php //echo $_SERVER['HTTP_HOST']; ?>
<?php //print_r($_SERVER); ?>
<a href="<?php echo URLROOT . 'posts'; ?>" class="btn btn-light mb-3"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
