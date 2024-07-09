<?php
if(isset($_GET['id']) && $_GET['id']>0){
    $id = $conn->real_escape_string($_GET['id']);
    $qry =$conn->query("SELECT * FROM users WHERE id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $row = $qry->fetch_assoc();
        foreach($row as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update": "Create New" ?> User </h3>
</div>
<div class="card-body">
    <form action="" id="user-form">
        <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : ''?>">
        <div class="form-group">
            <label for="name" class="control-label">Name</label>
            <textarea name="name" id="name"  cols="30" rows="2" class="form-control form no-resize"><?php echo isset($name)? $name : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <textarea name= "username" id="username" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($username)? $username : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="department" class="control-label">Department</label>
            <textarea name= "department" id="department" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($department)? $department : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="user_level" class="control-label">User Role</label>
            <input type="number"  class="form-control form" required name="user_level" value="<?php echo isset($user_level) ? $user_level : '' ?>">
            <option value=""></option>
             </div>
        
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="custom-select select">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0"<?php echo isset($status)&& $status == 0 ? 'selected' : '' ?>>Inactive</option>
           </select>
        </div> 
        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input type="password" id="password" class="form-control form-control-sm form" name="password" required>
        </div>


</form>
</div>
<div class="card-footer">
    <button class="btn btn-flat btn-primary" form="user-form">Save</button>
    <a class="btn btn-flat btn-default" href="?page=users">Cancel</a>
</div>
<script>
   $('#user-form').submit(function(e){
    e.preventDefault();
    var _this = $(this);
    $('.err-msg').remove();
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=save_users",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        dataType: 'json',
        error: err => {
            console.log(err);
            alert_toast("An error occurred", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.href = "./?page=users";
            } else if (resp.status == 'failed' && !!resp.msg) {
                var el = $('<div>');
                el.addClass("alert alert-danger err-msg").text(resp.msg);
                _this.prepend(el);
                el.show('slow');
                $("html, body").animate({scrollTop: _this.closest('.card').offset().top}, "fast");
                end_loader();
            } else {
                alert_toast("An error occurred", 'error');
                end_loader();
                console.log(resp);
            }
        }
    });
});

    $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })

    </script>
    