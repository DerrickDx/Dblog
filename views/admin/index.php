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
        <span style="color: darkgreen; font-size: x-large"><?php echo !empty($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></span>
        <?php messageDisplay(); ?>
    <?php endif; ?>
    <?php if(!empty($_SESSION['err_msg'])): ?>
        <span style="color: red; font-size: x-large"><?php echo !empty($_SESSION['err_msg']) ? $_SESSION['err_msg'] : ''; ?></span>
        <?php messageDisplay(name: 'err_msg'); ?>
    <?php endif; ?>
    <div class="tab">
        <button class="tablinks <?php echo $this->params['source'] ==  'user' ? 'active' :''?>" onclick="tab('user')">Admin Users</button>
        <button class="tablinks <?php echo $this->params['source'] ==  'post' ? 'active' :''?>" onclick="tab('post')">Blog Posts</button>
        <button class="tablinks <?php echo $this->params['source'] ==  'comment' ? 'active' :''?>" onclick="tab('comment')">Blog Comments</button>
    </div>

    <div id="user" style="display: <?php echo $this->params['source'] ==  'user' ? 'block' :'none'?>" class="tabcontent">
        <h2>Admin Users   <a href="<?php echo URLROOT ; ?>admin/createUser"><button>Add</button></a></h2>

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
                        <a href="<?php echo URLROOT ; ?>admin/updateUser?id=<?php echo $user->id; ?>"><button>Edit</button></a>
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

    <div id="post" class="tabcontent" style="display: <?php echo $this->params['source'] ==  'post' ? 'block' :'none'?>">
        <h2>Blog Posts   <a href="<?php echo URLROOT ; ?>admin/createPost"><button>Add</button></a></h2>
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
                        <a href="<?php echo URLROOT ; ?>admin/updatePost?id=<?php echo $post->post_id; ?>"><button>Edit</button></a>
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

    <div id="comment" class="tabcontent" style="display: <?php echo $this->params['source'] ==  'comment' ? 'block' :'none'?>">
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
                        <form action="<?php echo URLROOT; ?>admin/updateCommand" method="POST">
                            <button name="is_approved" onclick="return confirmCommentChange()" value="<?php echo $comment->is_approved ? 0 : 1?>"><?php echo $comment->is_approved ? 'Reject' : 'Approve'  ?></button></a>
                            <input type="hidden" name="comment_id" value="<?php echo $comment->comment_id ?>"/>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo URLROOT; ?>admin/removeCommand" method="POST">
                           <button name="comment_id" onclick="return confirmDelete()" value="<?php echo $comment->comment_id ?>">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function tab(tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            console.log('tabName: '+tabName);
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.className += " active";
        }

        function confirmDelete() {
            if (confirm("Are you sure you want to delete this item?")) {
                return true;
            }
            return false
        }

        function confirmCommentChange() {
            if (confirm("Are you sure you want to change the status of the comment?")) {
                return true;
            }
            return false
        }

        function loadDoc(tabName) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
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