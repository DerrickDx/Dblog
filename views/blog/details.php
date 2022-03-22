<?php require VIEW_PATH . '/header.php'; ?>
<div>
    <a href="<?php echo URLROOT . 'blog'; ?>" ><button>Back</button></a>
    <a href="<?php echo URLROOT ; ?>admin">  <button>Admin</button></a>
    <br>
</div>
<div>
    <h1><?php echo $this->params['post']->title; ?></h1>
        Created <?php echo is_null($this->params['post']->username) ? '' : 'by '. $this->params['post']->username; ?> at <?php echo  $this->params['post']->post_created_at ; ?> <?php echo is_null($this->params['post']->post_edited_at) ? '' : '  (Edited at ' . $this->params['post']->post_edited_at . ')'; ?>
    <p><textarea readonly style="auto; min-width: 800px; min-height: 400px" ><?php echo $this->params['post']->body; ?></textarea></p>
    <br>
</div>
<div>
    <div>
        <h3>Comments</h3>
    </div>

    <?php if(!empty($_SESSION['msg'])): ?>
        <span style="color: darkgreen; font-size: x-large"><?php echo $_SESSION['msg']; ?></span>
        <?php messageDisplay(); ?>
    <?php endif; ?>

    <?php if(!empty($_SESSION['err_msg'])): ?>
        <span style="color: darkred; font-size: x-large"><?php echo$_SESSION['err_msg']; ?></span>
        <?php messageDisplay(name: 'err_msg'); ?>
    <?php endif; ?>
    <?php foreach($this->params['comments'] as $comment) : ?>
        <div>
            <div>
                <p  style="font-weight: bold;"><?php echo $comment->message; ?></p>
                Commented by <?php echo ($comment->is_anonymous ? 'Anonymous User' : (is_null($comment->commenter) ? 'Deactivated User' : $comment->commenter)); ?> at <?php echo $comment->comment_created_at; ?>
            </div>
        <br>
        </div>
    <?php endforeach; ?>
    </div>
<div>
    <h3>Add a comment</h3>

    <form name="commentForm" action="/blog/addComment" method="post" enctype="multipart/form-data">
        <p> <input type="text" name="message" placeholder="Enter your comment..."  style="auto; min-width: 600px; min-height: 50px" ></p>
        <p> Name: <input type="text" name="name" placeholder="Enter your name">  &nbsp&nbsp Anonymous <input type="checkbox" id='annoymousComment' value='1'"  name="anonymous" ><input type="hidden" id='annoymousCommentHidden' value='0'  name="anonymous" >
        <p> <input type="hidden" name="post_id" value="<?php echo $this->params['post']->post_id; ?>"></p>
        <button onclick="return validateForm()" type="submit">Post Comment</button>
    </form>
</div>
<script>
    function validateForm() {
        if (document.forms["commentForm"]["message"].value === "") {
            alert("Please enter your comment");
            return false;
        }
        if (document.forms["commentForm"]["message"].value.length > 50) {
            alert("Comment message should be limited to 50 characters");
            return false;
        }
        if (document.forms["commentForm"]["name"].value === "" &&  !document.getElementById("annoymousComment").checked ) {
            alert("Please enter your name");
            return false;
        }
        if(document.getElementById("annoymousComment").checked) {
            document.getElementById('annoymousCommentHidden').disabled = true;
        }
    }
</script>
<?php require VIEW_PATH . '/footer.php'; ?>


