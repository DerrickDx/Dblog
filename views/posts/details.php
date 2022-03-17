
<br>
<h1><?php echo $this->params['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?php echo $this->params['post']->username; ?> at <?php echo $this->params['post']->post_created_at; ?> <?php echo is_null($this->params['post']->post_edited_at) ? '' : '  (Edited at ' . $this->params['post']->post_edited_at . ')'; ?>
</div>
<p><textarea readonly style="auto; min-width: 600px; min-height: 300px" ><?php echo $this->params['post']->body; ?></textarea></p>
<!--<p><input type="text" disabled id="fname" name="fname" size="50" value="--><?php //echo $this->params['post']->body; ?><!--"></p>-->

<div class="card card-body mb-3">
    <h3 class="card-title">Comments:</h3>
    <div class="bg-light p-2 mb-3">
    </div>
    <p class="card-text"><?php echo ''; ?></p>
</div>

<?php foreach($this->params['comments'] as $comment) : ?>
    <div class="card card-body mb-3">

<!--        <p class="card-text">--><?php //echo $comment->message; ?><!--</p>-->
        <div class="bg-light p-2 mb-3">
<!--            <h4 class="card-title">--><?php //echo $comment->message; ?><!--</h4>-->
            <p class="card-text" style="font-weight: bold;"><?php echo $comment->message; ?></p>
            Commented by <?php echo ($comment->is_anonymous ? 'Anonymous User' : $comment->commenter); ?> at <?php echo $comment->comment_created_at; ?>
        </div>
<!--        <a class="btn btn-dark" href="--><?php //echo URLROOT; ?><!--/posts/show/--><?php //echo $comment->comment_id; ?><!--">Sth</a>-->
    <br>
    </div>
<?php endforeach; ?>



<a href="<?php echo URLROOT . 'posts'; ?>" class="btn btn-light mb-3"><i class="fa fa-backward" aria-hidden="true"></i> <button>Back</button></a>
