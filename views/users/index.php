<form action="/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="receipt">
    <button type="submit">Upload</button>
</form>

<!--<h1>--><?//= $this->params['foo'] ?><!--</h1>-->
<!--<h1>--><?//= $this->foo ?><!--</h1>-->

<?php //foreach($data['posts'] as $post) : ?>
<!--    <div class="card card-body mb-3">-->
<!--        <h4 class="card-title">--><?php //echo $post->title; ?><!--</h4>-->
<!--        <div class="bg-light p-2 mb-3">-->
<!--            Written by --><?php //echo $post->name; ?><!-- on --><?php //echo $post->created_at; ?>
<!--        </div>-->
<!--        <p class="card-text">--><?php //echo $post->body; ?><!--</p>-->
<!--        <a class="btn btn-dark" href="--><?php //echo URLROOT; ?><!--/posts/show/--><?php //echo $post->postId; ?><!--">More</a>-->
<!--    </div>-->
<?php //endforeach; ?>

<?php foreach($this->params as $user) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $user->username; ?></h4>
        <div class="bg-light p-2 mb-3">
            Written by <?php echo $user->username; ?> on <?php echo $user->created_at; ?>
        </div>
<!--        <p class="card-text">--><?php //echo $post->body; ?><!--</p>-->
<!--        <a class="btn btn-dark" href="--><?php //echo URLROOT; ?><!--/posts/show/--><?php //echo $post->postId; ?><!--">More</a>-->
    </div>
<?php endforeach; ?>
