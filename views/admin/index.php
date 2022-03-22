<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>DBlog Admin</title>
    <style>
        <?php require VIEW_PATH . '/styles.css'; ?>
    </style>
</head>
<body>
    <div>
        <h1>Welcome to Admin Page, <?php print_r($_SESSION['user_name']); ?> <a href="<?php echo URLROOT ; ?>">  <button>Back to Homepage</button></a>
            <a href="<?php echo URLROOT ; ?>blog"><button>Blog</button></a>
            <a href="<?php echo URLROOT ; ?>admin/logout"><button>Logout</button></a></h1>

    </div>
    <?php if(!empty($_SESSION['msg'])): ?>
        <span id="msg" style="color: darkgreen; font-size: x-large"><?php echo $_SESSION['msg'] ; ?></span>
        <?php messageDisplay(); ?>
    <?php endif; ?>

    <?php if(!empty($_SESSION['err_msg'])): ?>
        <span id="err_msg" style="color: red; font-size: x-large"><?php echo $_SESSION['err_msg']; ?></span>
        <?php messageDisplay(name: 'err_msg'); ?>
    <?php endif; ?>

    <div class="tab">
        <button class="tab_links <?php echo $this->params['source'] ==  USER_ACTION ? 'active' :''?>" onclick="tab('user')">Admin Users</button>
        <button class="tab_links <?php echo $this->params['source'] ==  POST_ACTION ? 'active' :''?>" onclick="tab('post')">Blog Posts</button>
        <button class="tab_links <?php echo $this->params['source'] ==  COMMENT_ACTION ? 'active' :''?>" onclick="tab('comment')">Blog Comments</button>
    </div>

    <div id="user" style="display: <?php echo $this->params['source'] ==  USER_ACTION ? 'block' :'none'?>" class="tab_content">
        <h2>Admin Users   <a href="<?php echo URLROOT ; ?>admin/user/add"><button>Add</button></a></h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created Date</th>
                <th>Edited Date</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($this->params['users'] as $user) : ?>
                <tr>
                    <td><?php echo $user->id ?></td>
                    <td><?php echo $user->username ?></td>
                    <td><?php echo $user->created_at ?></td>
                    <td><?php echo $user->edited_at ?></td>
                    <td>
                        <a href="<?php echo URLROOT ; ?>admin/user/edit?id=<?php echo $user->id; ?>"><button>Edit</button></a>
                    </td>
                    <td>
                        <?php if($user->id != $_SESSION['user_id']) : ?>
                            <form action="<?php echo URLROOT; ?>admin/removeUser" method="POST">
                                <button name="user_id" onclick="return confirmDelete()" value="<?php echo $user->id ?>">Remove</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="post" class="tab_content" style="display: <?php echo $this->params['source'] ==  POST_ACTION ? 'block' :'none'?>">
        <h2>Blog Posts   <a href="<?php echo URLROOT ; ?>admin/post/add"><button>Add</button></a></h2>
        <table id="post_table">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created Date</th>
                <th>Edited Date</th>
                <th>Author</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($this->params['posts'] as $post) : ?>
                <tr>
                    <td><?php echo $post->post_id ?></td>
                    <td><?php echo $post->title ?></td>
                    <td><?php $charLimit = 75; echo strlen($post->body) > $charLimit ? substr($post->body, 0, $charLimit) .'...' : $post->body; ?></td>

                    <td><?php echo $post->post_created_at ?></td>
                    <td><?php echo $post->post_edited_at ?></td>
                    <td><?php echo is_null($post->username) ? 'Deactivated User' : $post->username ?></td>
                    <td>
                        <a href="<?php echo URLROOT ; ?>admin/post/edit?id=<?php echo $post->post_id; ?>"><button>Edit</button></a>
                    </td>
                    <td>
                        <form action="<?php echo URLROOT; ?>admin/removePost" method="POST">
                            <button name="post_id" onclick="return confirmDelete()" value="<?php echo $post->post_id ?>">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="comment" class="tab_content" style="display: <?php echo $this->params['source'] ==  COMMENT_ACTION ? 'block' :'none'?>">
        <h2>Blog Comments</h2>
        <table id="comment_table">
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Commenter</th>
                <th>Anonymous</th>
                <th>Created Date</th>
                <th>Post ID</th>
                <th>Approved</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($this->params['comments'] as $comment) : ?>
                <tr>
                    <td><?php echo $comment->comment_id ?></td>
                    <td><?php echo $comment->message ?></td>
                    <td><?php echo $comment->name ?></td>
                    <td><?php echo $comment->is_anonymous ? 'Yes' : 'No' ?></td>
                    <td><?php echo $comment->created_at ?></td>
                    <td><?php echo $comment->post_id ?></td>
                    <td><?php echo $comment->is_approved ? 'Yes' : 'No' ?></td>
                    <td>
                        <form action="<?php echo URLROOT; ?>admin/updateComment" method="POST">
                            <button name="is_approved" onclick="return confirmCommentChange()" value="<?php echo $comment->is_approved ? 0 : 1?>"><?php echo $comment->is_approved ? 'Reject' : 'Approve'  ?></button>
                            <input type="hidden" name="comment_id" value="<?php echo $comment->comment_id ?>"/>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo URLROOT; ?>admin/removeComment" method="POST">
                           <button name="comment_id" onclick="return confirmDelete()" value="<?php echo $comment->comment_id ?>">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function tab(tabName) {
            let i, tab_content, tab_links;
            tab_content = document.getElementsByClassName("tab_content");
            for (i = 0; i < tab_content.length; i++) {
                tab_content[i].style.display = "none";
            }
            tab_links = document.getElementsByClassName("tab_links");
            if (document.getElementById("msg")) {
                document.getElementById("msg").setAttribute('hidden', true);
            }
            if (document.getElementById("err_msg")) {
                document.getElementById("err_msg").setAttribute('hidden', true);
            }
            for (i = 0; i < tab_links.length; i++) {
                tab_links[i].className = tab_links[i].className.replace(" active", "");
            }
            console.log('tabName: '+tabName);
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.className += " active";
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this item?");

        }

        function confirmCommentChange() {
            return confirm("Are you sure you want to change the status of the comment?");

        }

        function loadDoc(tabName) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState === 4 && this.status === 200) {
                    console.log(this.response)

                    var arr = JSON.parse(this.response);
                    console.log(arr.length)
                    for(var i=0; i<arr.length; i++) {
                        console.log(arr[i].title)
                    }
                }
            };
            xhttp.open("GET", "<?php echo URLROOT ; ?>" + "admin/getPosts", true);
            xhttp.send();

        }
    </script>

</body>
</html>