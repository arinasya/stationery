<?php if($_settings->chk_flashdata('success')): ?>
    <div class="alert alert-success"><?php echo $_settings->flashdata('success'); ?></div>
<?php endif; ?>

<?php if($_settings->chk_flashdata('error')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('error') ?>",'error')
</script>
<?php endif;?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Orders</h3>
        <!-- <div class="card-tools">
            <a href="?page=order/manage_order" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
        </div> -->
    </div>
    <div class="card-body">
        <div class="form-group col-md-1">
            <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
        </div>
        <hr>
        <div id="printable">
            <div class="container-fluid">
                <div class="container-fluid">
                    <table class="table table-bordered ">
                        <colgroup>
                            <col width="5%">
                            <col width="15%">
                            <col width="25%">
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date Order</th>
                                <th>Department</th>
                                <th>Total Amount</th>
                                <th>Confirm</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $qry = $conn->query("SELECT o.*, u.department FROM orders o INNER JOIN users u on u.id = o.user_id ORDER BY unix_timestamp(o.order_date) DESC ");
                            if(!$qry){
                                die("Query failed:" . $conn->error);
                            }
                            while($row = $qry->fetch_assoc()):
                                // Initialize total price
                                $total_price = 0;
                                // Initialize maximum decimal places
                                $max_decimal_places = 0;
            
                                $olist = $conn->query("SELECT o.*, i.name, i.price FROM order_list o INNER JOIN items i ON o.item_id = i.id WHERE o.order_id = '{$row['id']}'");
                                while ($orow = $olist->fetch_assoc()):
                                    foreach ($orow as $k => $v) {
                                        $orow[$k] = trim(stripslashes($v));
                                    }
                                    
                                    $quantity = $orow['quantity'];
                                    $price = $orow['price'];
                                    $total_item_price = $price * $quantity;
                                    $total_price += $total_item_price;
                                    
                                    // Calculate decimal places for the current item
                                    $decimal_places = strlen(substr(strrchr($total_item_price, "."), 1));
                                    $max_decimal_places = max($max_decimal_places, $decimal_places);
                                endwhile;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo date("Y-m-d H:i", strtotime($row['order_date'])) ?></td>
                                <td><?php echo $row['department'] ?></td>
                                <td class="text-right"><?php echo number_format($total_price, $max_decimal_places); ?></td>
                                <td class="text-center">
                                    <?php if($row['confirm'] == 0): ?>
                                        <span class="badge badge-light">No</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Yes</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($row['status'] == 0): ?>
                                        <span class="badge badge-light">Pending</span>
                                    <?php elseif($row['status'] == 1): ?>
                                        <span class="badge badge-primary">Completed</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="?page=orders/view_order&id=<?php echo $row['id'] ?>">View Order</a>
                                        <?php if($row['confirm'] == 0 && $row['status'] != 4): ?>
                                            <a class="dropdown-item confirm" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Confirm</a>
                                        <?php endif; ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
</div>

<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete this order permanently?","delete_order",[$(this).attr('data-id')])
        })
        $('.confirm').click(function(){
            _conf("Are you sure to mark this order as confirm?","confirm",[$(this).attr('data-id')])
        })
        $('.table').dataTable();
        $('#printBTN').click(function(){
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            rep.prepend(ns)
            var nw = window.document.open('','_blank','width=900,height=600')
                nw.document.write(rep.html())
                nw.document.close()
                nw.print()
                setTimeout(function(){
                    nw.close()
                    end_loader()
                },500)
        })
    })
    function confirm($id) {
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=confirm",
        method: "POST",
        data: { id: $id },
        dataType: "json",
        error: err => {
            console.log(err); // Log the error
            alert_toast("An error occurred.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occurred: " + resp.err, 'error');
                end_loader();
            }
        }
    });
}

    function delete_order($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_order",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occured.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
