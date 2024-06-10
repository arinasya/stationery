<?php if($_settings->chk_flashdata('success')): ?>
    <div class="alert alert-success"><?php echo $_settings->flashdata('success'); ?></div>
<?php endif; ?>



<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Users</h3>
        <div class="card-tools">
            <a href="?page=users/manage_users" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="35%">
                        <col width="25%">
                        <col width="10%">
                        <col width="10%">
                        <col width="20%">
                        <col width="25%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th>Username</th>
                            <th>Department</th>
                            <th>User Role</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i= 1;
                        $qry = $conn->query("SELECT * FROM `users` ORDER BY UNIX_TIMESTAMP(last_login) DESC");

                            while($row = $qry->fetch_assoc()):
                               
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['name']?></td>
                                <td><?php echo $row['username']?></td>
                                <td><?php echo $row['department']?></td>
                                <td><?php echo $row['user_level']?></td>
                                <td><?php echo date ("Y-m-d H:i", strtotime($row['last_login'])) ?></td>
                                <td class="text-center">
                                    <?php if($row['status']== 1): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>

                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Action
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="?page=users/manage_users&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span>Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']?>"><span class="fa fa-trash text-danger"></span>Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Jquery-->

<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure you want to delete this user permanently?", "delete_user", [$(this).attr('data-id')]);
        });

        $('.table').dataTable();
    });

    function delete_user($id){
        start_loader();
        $.ajax({
            url: _base_url_+"classes/Master.php?f=delete_user",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: function(err){
                console.log(err);
                alert_toast("An error occurred.", "error");
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("An error occurred.", "error");
                    end_loader();
                }
            }
        });
    }
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
<script src ="../../plugins/jquery/jquery.min.js" > </script>
<script src ="../../plugins/jquery/jquery.min.js" > </script>