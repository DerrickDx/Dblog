<?php require VIEW_PATH . '/header.php'; ?>

<a href="<?php echo URLROOT . 'admin'; ?>" ><button>Back</button></a>

<div>
    <h3>Add a Post</h3>
    <form name="addPostrForm" action="/admin/createPost" method="post" enctype="multipart/form-data">
        <div>
            <p><label> Title:</label></p>
            <p>  <input type="text" name="title" placeholder="Title"> </p>
        </div>
        <div>
            <p><label> Body:</label></p>
            <p><textarea name="body" style="auto; min-width: 600px; min-height: 300px" placeholder="Body"></textarea></p>
        </div>
        <div>
            <p><label> Author:</label></p>
            <p><select name="user_id">
                    <option value="0">Select from list</option>
                    <?php foreach($this->params['users'] as $user) : ?>
                        <option value="<?php echo $user->id; ?>"><?php echo $user->username; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <button onclick="return validateForm()" type="submit">Submit</button>

    </form>
</div>
<script>
    function validateForm() {
        if (document.forms["addPostrForm"]["title"].value == "") {
            alert("Please enter title");
            return false;
        }
        if (document.forms["addPostrForm"]["body"].value == "") {
            alert("Please enter body");
            return false;
        }
        if (document.forms["addPostrForm"]["user_id"].value == "0") {
            alert("Please select from list");
            return false;
        }
    }
</script>

<?php require VIEW_PATH . '/footer.php'; ?>



