

<a href="<?php echo URLROOT . 'posts'; ?>" class="btn btn-light mb-3"><i class="fa fa-backward" aria-hidden="true"></i> <button>Back</button></a>
<br>
<h1><?php echo $this->params['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Created <?php echo is_null($this->params['post']->username) ? '' : 'by '. $this->params['post']->username; ?> at <?php echo  $this->params['post']->post_created_at ; ?> <?php echo is_null($this->params['post']->post_edited_at) ? '' : '  (Edited at ' . $this->params['post']->post_edited_at . ')'; ?>
</div>
<p><textarea readonly style="auto; min-width: 600px; min-height: 300px" ><?php echo $this->params['post']->body; ?></textarea></p>
<!--<p><input type="text" disabled id="fname" name="fname" size="50" value="--><?php //echo $this->params['post']->body; ?><!--"></p>-->

<div class="card card-body mb-3">
    <h3 class="card-title">Comments</h3>
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
            Commented by <?php echo ($comment->is_anonymous ? 'Anonymous User' : (is_null($comment->commenter) ? 'Deactivated User' : $comment->commenter)); ?> at <?php echo $comment->comment_created_at; ?>
        </div>
    <br>
    </div>
<?php endforeach; ?>


<div class="card card-body mb-3">
    <br>
    <h3 class="card-title">Add a comment</h3>
    <div class="bg-light p-2 mb-3">
    </div>
    <p class="card-text"><?php echo ''; ?></p>
    <form name="commentForm" action="/comments/add" method="post" enctype="multipart/form-data">

<!--        <p>Comment: </p>-->
        <p> <input type="text" name="message" placeholder="Enter your comment..."  style="auto; min-width: 600px; min-height: 50px" ></p>
        <p> Name: <input type="text" name="name" placeholder="Enter your name">  &nbsp&nbsp Anonymous <input type="checkbox" id='annoymousComment' value='1' onclick="anonymousCheck()"  name="anonymous" ><input type="hidden" id='annoymousCommentHidden' value='0'  name="anonymous" >
        <p> <input type="hidden" name="post_id" value="<?php echo $this->params['post']->post_id; ?>"></p>
        <button onclick="return validateForm()" type="submit">Post Comment</button>
    </form>
<!--    <p><textarea  style="auto; min-width: 600px; min-height: 50px" ></textarea></p>-->
</div>
<script>
    function validateForm() {
        // alert("ALERT");
        console.log(document.forms["commentForm"]);
        if (document.forms["commentForm"]["message"].value == "") {
            alert("Please enter your comment");
            return false;
        }
        // alert(document.forms["commentForm"]["anonymous"].checked);
        if (document.forms["commentForm"]["name"].value == "" &&  !document.getElementById("annoymousComment").checked ) {
            alert("Please enter your name");
            return false;
        }

        if(document.getElementById("annoymousComment").checked) {
            document.getElementById('annoymousCommentHidden').disabled = true;
        }
        // alert(document.forms["commentForm"]["anonymous"].value);
        // document.forms["commentForm"]["anonymous"].value = document.forms["commentForm"]["anonymous"].checked;
        // return false;
    }
    function anonymousCheck() {
        console.log(document.forms["commentForm"]["anonymous"].checked)
    }
</script>

<!--if(document.getElementById("testName").checked) {-->
<!--document.getElementById('testNameHidden').disabled = true;-->
<!--}-->



