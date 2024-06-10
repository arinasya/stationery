<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM `items` WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        foreach($result->fetch_assoc() as $k => $v){
            $$k = stripslashes($v);
        }
    }
    $stmt->close();
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Item</h3>
    </div>
    <div class="card-body">
        <form action="" id="item-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <label for="vendor_id" class="control-label">Vendor</label>
                <select name="vendor_id" id="vendor_id" class="custom-select select" required>
                    <option value=""></option>
                    <?php
                    $vendor_query = $conn->query("SELECT * FROM `vendors` ORDER BY name ASC");
                    while($row = $vendor_query->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($vendor_id) && $vendor_id == $row['id'] ? 'selected' : '' ?>>
                        <?php echo $row['name'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="control-label">Item Name</label>
                <textarea name="name" id="name" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($name) ? $name : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price" class="control-label">Price</label>
                <input type="number" step="any" class="form-control form" required name="price" value="<?php echo isset($price) ? $price : '' ?>">
            </div>
            <div class="form-group">
                <label for="charge_code" class="control-label">Charge Code</label>
                <input type="number" step="any" class="form-control form" required name="charge_code" value="<?php echo isset($charge_code) ? $charge_code : '' ?>">
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select select">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="images" class="control-label">Images</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="img[]" multiple accept="image/*" onchange="displayImg(this, $(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <?php if(isset($id)): ?>
            <?php 
            $upload_path = "uploads/item_" . $id;
            if(is_dir($upload_path)): 
                $files = scandir($upload_path);
                foreach($files as $img):
                    if(in_array($img, array('.', '..')))
                        continue;
            ?>
            <div class="d-flex w-100 align-items-center img-item">
                <span><img src="<?php echo $upload_path . '/' . $img ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
                <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo $upload_path . '/' . $img ?>"><i class="fa fa-trash"></i></button></span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="item-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=item">Cancel</a>
    </div>
</div>
<script>
    function displayImg(input, _this) {
        var fnames = [];
        Object.keys(input.files).map(k => {
            fnames.push(input.files[k].name);
        });
        _this.siblings('.custom-file-label').html(JSON.stringify(fnames));
    }
    function delete_img($path) {
        start_loader();
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=delete_img',
            data: { path: $path },
            method: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err);
                alert_toast("An error occured while deleting an Image", "error");
                end_loader();
            },
            success: function(resp) {
                $('.modal').modal('hide');
                if (typeof resp == 'object' && resp.status == 'success') {
                    $('[data-path="' + $path + '"]').closest('.img-item').hide('slow', function() {
                        $('[data-path="' + $path + '"]').closest('.img-item').remove();
                    });
                    alert_toast("Image Successfully Deleted", "success");
                } else {
                    console.log(resp);
                    alert_toast("An error occured while deleting an Image", "error");
                }
                end_loader();
            }
        });
    }
    $(document).ready(function() {
        $('#item-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_item",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=item";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });

        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
