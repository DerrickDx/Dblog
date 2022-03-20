<?php require VIEW_PATH . '/header.php'; ?>
<div>
        <h1>Log in to Admin</h1>
        <form action="<?php echo URLROOT; ?>admin/login" method="post" enctype="multipart/form-data">
            <div >
                <label>Username:<sup>*</sup></label>
                <input placeholder="Username" type="text" name="username">
            </div>
            <div>
                <label>Password: <sup>*</sup></label>
                <input placeholder="Password" type="password" name="password" >
            </div>
            <div>
                <div>
                    <input type="submit" value="Login">
                </div>

            </div>
        </form>
    <div>
        <a href="<?php echo URLROOT ; ?>"><button>Back to Homepage</button></a>
    </div>
</div>
<?php require VIEW_PATH . '/footer.php'; ?>