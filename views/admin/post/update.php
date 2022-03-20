<?php require VIEW_PATH . '/header.php'; ?>

<a href="<?php echo URLROOT . 'admin'; ?>" ><button>Back</button></a>

<div>
    <h3>Update Post <?php print_r($this->params['post']->title); ?></h3>
    <form name="updateUserForm" action="/admin/updatePost" method="post" enctype="multipart/form-data">
        <div>
            <p><label> Title:</label></p>
            <p><input type="text" name="title" value="<?php echo $this->params['post']->title; ?>" placeholder="Username"> </p>
        </div>
        <div>
            <p><label> Body:</label></p>
            <p><textarea name="body" style="auto; min-width: 600px; min-height: 300px"><?php echo $this->params['post']->body; ?></textarea></p>
        </div>
        <div>
            <p><label> Author:</label></p>
            <p><select name="user_id">
                    <option value="0">Select from list</option>

                    <?php foreach($this->params['users'] as $user) : ?>
                        <option <?php echo $user->id == $this->params['post']->user_id ? 'selected' : ''?> value="<?php echo $user->id; ?>"><?php echo $user->username; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <div>
            <p><label>Created Date:</label></p>
            <p><input disabled type="text" value="<?php echo $this->params['post']->created_at; ?>"></p>
        </div>
        <div>
            <p><label>Last Edited Date:</label></p>
            <p><input disabled type="text" value="<?php echo $this->params['post']->edited_at; ?>"></p>
        </div>
        <div>
            <p> <input type="hidden" name="post_id" value="<?php echo $this->params['post']->id; ?>"></p>
        </div>
        <button onclick="return validateForm()" type="submit">Submit</button>
    </form>
</div>
<script>
    function validateForm() {
        if (document.forms["updateUserForm"]["title"].value == "") {
            alert("Please enter title");
            return false;
        }
        if (document.forms["updateUserForm"]["body"].value == "") {
            alert("Please enter body");
            return false;
        }
        if (document.forms["updateUserForm"]["user_id"].value == "0") {
            alert("Please select from list");
            return false;
        }
    }
</script>
<?php require VIEW_PATH . '/footer.php'; ?>



