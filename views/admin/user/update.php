<?php require VIEW_PATH . '/header.php'; ?>

<a href="<?php echo URLROOT . 'admin'; ?>" ><button>Back</button></a>

<div>
    <h3>Update Admin User <?php print_r($this->params['user']->username); ?></h3>
    <form name="addUserForm" action="/admin/updateUser" method="post" enctype="multipart/form-data">
        <div>
            <p><label> Username:</label></p>
            <p><input type="text" disabled name="displayed_username" value="<?php echo $this->params['user']->username; ?>" placeholder="Username"> </p>
            <p><input type="hidden"  name="username" value="<?php echo $this->params['user']->username; ?>" placeholder="Username"> </p>
        </div>

        <div>
            <p><label> Password:</label></p>
            <p> <input type="password" name="password" placeholder="Password"> </p>
        </div>

        <div>
            <p><label>Created Date:</label></p>
            <p><input disabled type="text" value="<?php echo $this->params['user']->created_at; ?>"></p>
        </div>
        <div>
            <p><label>Last Edited Date:</label></p>
            <p><input disabled type="text" value="<?php echo $this->params['user']->edited_at; ?>"></p>
        </div>
        <div>
            <p> <input type="hidden" name="user_id" value="<?php echo $this->params['user']->id; ?>"></p>
        </div>
        <div>
            <div>
                <button onclick="return validateForm()" type="submit">Submit</button>
            </div>
            <?php  if(!empty($this->params['err_msg'])) : ?> <div><span style="color: #D8000C"><?php echo $this->params['err_msg']; ?></span> </div>
            <?php endif; ?>
        </div>
    </form>
</div>
<script>
    function validateForm() {
        if (document.forms["addUserForm"]["username"].value == "") {
            alert("Please enter username");
            return false;
        }
        if (document.forms["addUserForm"]["password"].value == "") {
            alert("Please enter password");
            return false;
        }
    }
</script>

<?php require VIEW_PATH . '/footer.php'; ?>



