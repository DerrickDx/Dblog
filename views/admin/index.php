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
            <a href="<?php echo URLROOT ; ?>admin/logout"><button>Logout</button></a></h1>

    </div>

    <div class="tab">
        <button class="tablinks active" onclick="tab('user_tag')">Admin Users</button>
        <button class="tablinks" onclick="tab('post_tag')">Blog Posts</button>
        <button class="tablinks" onclick="tab('comment_tag')">Blog Comments</button>
    </div>

    <div id="user_tag" style="display: block" class="tabcontent">
        <h2>Admin Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created Date</th>
                <th>Edited Date</th>
            </tr>
            <?php foreach($this->params['users'] as $user) : ?>
                <tr>
                    <td><?php echo $user->id ?></td>
                    <td><?php echo $user->username ?></td>
                    <td><?php echo $user->created_at ?></td>
                    <td><?php echo $user->edited_at ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="post_tag" class="tabcontent">
        <h2>Blog Posts</h2>
        <table id="post_table">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created Date</th>
                <th>Edited Date</th>
                <th>Author</th>
            </tr>
<!--            --><?php //print_r($this->params);?>
            <?php foreach($this->params['posts'] as $post) : ?>
                <tr>
                    <td><?php echo $post->post_id ?></td>
                    <td><?php echo $post->title ?></td>
                    <td><?php echo $post->title ?></td>
                    <td><?php echo $post->post_created_at ?></td>
                    <td><?php echo $post->post_created_at ?></td>
                    <td><?php echo $post->username ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="comment_tag" class="tabcontent">
        <h2>Blog Comments</h2>
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
            if (tabName != 'user_tag') {
                loadDoc(tabName)
            }
        }

        function loadDoc(tabName) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    // document.getElementById("demo").innerHTML = this.responseText;
                    // console.log(this.response['posts'])
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