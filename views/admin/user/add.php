<?php require VIEW_PATH . '/header.php'; ?>

<a href="<?php echo URLROOT . 'admin'; ?>" ><button>Back</button></a>

<div>
    <h3>Add an Admin User</h3>
    <form name="addUserForm" action="/admin/createUser" method="post" enctype="multipart/form-data">
        <div>
            <p><label> Username:</label></p>
            <p>  <input type="text" name="username" placeholder="Username" value="<?php echo !empty($this->params['username']) ? $this->params['username'] : ''; ?>"> </p>
        </div>
        <div>
            <p><label> Password:</label></p>
            <p> <input type="password" name="password" placeholder="Password"> </p>
        </div>
        <div>
            <div>
                <button onclick="return validateForm()" type="submit">Submit</button>
            </div>
            <?php  if(!empty($this->params['err_msg'])) : ?> <div><span style="color: #D8000C"><?php echo $this->params['err_msg']; ?></span> </div>
            <?php endif; ?>
            <?php if(!empty($_SESSION['err_msg'])): ?>
                <span style="color: red; font-size: x-large"><?php echo !empty($_SESSION['err_msg']) ? $_SESSION['err_msg'] : ''; ?></span>
                <?php messageDisplay(name: 'err_msg'); ?>
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



