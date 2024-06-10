<?php
if(isset($_GET['id']) && $_GET['id']>0){
    $qry = $conn->query("SELECT * FROM user_groups WHERE id = '{$_GET['id']}'");

    if($qry->num_rows > 0){
        $row = $qry->fetch_assoc();
        foreach($row as $k => $v){
            $$k = stripslashes($v);
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update" : "Create New" ?> Group </h3>
    </div>
    <div class="card-body">
        <form action="" id="group-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''?>">
            <div class="form-group">
                <label for="group_name" class="control-label">Group Name</label>
                <textarea name="group_name" id="group_name" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($group_name) ? $group_name : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="group_level" class="control-label">Group Levels</label>
                <input type="number" class="form-control form" required name="group_level" value="<?php echo isset($group_level) ? $group_level : '' ?>">
            </div>
            <div class="form-group">
                <label for="group_status" class="control-label">Status</label>
                <select name="group_status" id="group_status" class="custom-select select">
                    <option value="1" <?php echo isset($group_status) && $group_status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($group_status) && $group_status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="group-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=group">Cancel</a>
    </div>
</div>
<script>
    $('#group-form').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_group",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            error: function(err){
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp){
                if(resp.status == 'success'){
                    location.href = "./?page=group";
                }else if(resp.status == 'failed' && resp.msg){
                    var el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                    _this.prepend(el);
                    el.show('slow');
                    $("html, body").animate({scrollTop: _this.closest('.card').offset().top}, "fast");
                    end_loader();
                }else{
                    alert_toast("An error occurred", 'error');
                    end_loader();
                    console.log(resp);
                }
            }
        });
    });
</script>
