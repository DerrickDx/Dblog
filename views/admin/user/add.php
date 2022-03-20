<?php require VIEW_PATH . '/header.php'; ?>

<a href="<?php echo URLROOT . 'admin'; ?>" ><button>Back</button></a>

<div>
    <h3>Add an Admin User</h3>
    <form name="addUserForm" action="/admin/createUser" method="post" enctype="multipart/form-data">
        <div>
            <p><label> Username:</label></p>
            <p>  <input type="text" name="username" placeholder="Username"> </p>
        </div>
        <div>
            <p><label> Password:</label></p>
            <p> <input type="password" name="password" placeholder="Password"> </p>
        </div>
        <button onclick="return validateForm()" type="submit">Submit</button>

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



