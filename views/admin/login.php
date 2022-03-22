<?php require VIEW_PATH . '/header.php'; ?>
<div>
    <div>
        <h1>Log in to Admin</h1>

        <form name="loginForm" action="<?php echo URLROOT; ?>admin/userLogin" method="post" enctype="multipart/form-data">
            <?php if(!empty($_SESSION['msg'])): ?>
                <span id="msg_a" style="color: darkgreen; font-size: x-large"><?php echo  $_SESSION['msg']; ?></span>

            <?php endif; ?>
            <div >
                <label>Username:<sup>*</sup></label>
                <input placeholder="Username" type="text" name="username" value="<?php echo !empty($this->params['username']) ? $this->params['username'] : ''; ?>" >
            </div>
            <div>
                <label>Password: <sup>*</sup></label>
                <input placeholder="Password" type="password" name="password" >
            </div>
            <div>
                <div>
                    <input onclick="return validateForm()" type="submit" value="Login">
                </div>
               <?php  if(!empty($this->params['err_msg'])) : ?> <span style="color: #D8000C"><?php echo $this->params['err_msg']; ?></span>
                 <?php endif; ?>
            </div>
        </form>
    </div>
    <br/>
    <div>
        <a href="<?php echo URLROOT ; ?>"><button>Back to Homepage</button></a>
    </div>
</div>
    <script>
        function validateForm() {
            if (document.forms["loginForm"]["username"].value === "") {
                alert("Please enter username");
                return false;
            }
            if (document.forms["loginForm"]["password"].value === "") {
                alert("Please enter password");
                return false;
            }
        }
    </script>
<?php require VIEW_PATH . '/footer.php'; ?>