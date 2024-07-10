<!DOCTYPE html>
<html>
<head>
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>-->
</head>
<body>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php if($_settings->chk_flashdata('error')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('error') ?>",'error')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Orders</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-stripped" id="orderTable">
                <colgroup>
                    <col width="1%">
                    <col width="10%">
                    <col width="4%">
                    <col width="15%">
                    <col width="5%">
                    <col width="7%">
                    <col width="5%">
                    <col width="5%">
                    <col width="15%"> 
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Order</th>
                        <th>Department</th>
                        <th>Items</th>
                        <th>QTY</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Cancellation Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT o.*, u.department FROM orders o INNER JOIN users u ON u.id = o.user_id ORDER BY unix_timestamp(o.order_date) DESC");

                    while($row = $qry->fetch_assoc()):
                        $total_price = 0;
                        $max_decimal_places = 0;
                        $item_details = [];
                        $total_quantity = 0;

                        $olist = $conn->query("SELECT o.*, i.name, i.price FROM order_list o INNER JOIN items i ON o.item_id = i.id WHERE o.order_id = '{$row['id']}'");
                        $item_number = 1;

                        while ($orow = $olist->fetch_assoc()):
                            foreach ($orow as $k => $v) {
                                $orow[$k] = trim(stripslashes($v));
                            }
                            $quantity = $orow['quantity'];
                            $price = $orow['price'];
                            $total_item_price = $price * $quantity;
                            $total_price += $total_item_price;

                            $item_details[] = $item_number++ . ". " . $orow['name'];
                            $total_quantity += $quantity;

                            $decimal_places = strlen(substr(strrchr($total_item_price, "."), 1));
                            $max_decimal_places = max($max_decimal_places, $decimal_places);
                        endwhile;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($row['order_date'])) ?></td>
                        <td><?php echo $row['department'] ?></td>
                        <td><?php echo implode("<br>", $item_details); ?></td>
                        <td class="text-center"><?php echo $total_quantity; ?></td>
                        <td class="text-right"><?php echo number_format($total_price, $max_decimal_places); ?></td>
                        <td class="text-center">
                            <?php if($row['status'] == 0): ?>
                                <span class="badge badge-light">Order Placed</span>
                            <?php elseif($row['status'] == 1): ?>
                                <span class="badge badge-primary">Processing</span>
                            <?php elseif($row['status'] == 2): ?>
                                <span class="badge badge-primary">Completed</span>
                            <?php else : ?>
                                <span class="badge badge-danger">Cancelled</span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Action
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <div class="dropdown-item update_status" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="<?php echo $row['status'] ?>">
                                    <span>Update Status</span>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                            </div>
                        </td>
                        <td><?php echo $row['cancellation_reasons']; ?></td>  
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="status-update-form">
                <div class="modal-body">
                    <input type="hidden" name="id" id="order_id">
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="order_status" class="custom-select custol-select-sm">
                            <option value="0">Order Placed</option>
                            <option value="1">Processing</option>
                            <option value="2">Completed</option>
                            <option value="3">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group" id="cancellation_reason_group" style="display: none;">
                        <label for="cancellation_reasons" class="control-label">Reason for Cancellation</label>
                        <textarea name="cancellation_reasons" id="cancellation_reasons" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#orderTable').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": true
    });

    $('#order_status').change(function() {
        if ($(this).val() == '3') {
            $('#cancellation_reason_group').show();
        } else {
            $('#cancellation_reason_group').hide();
            $('#cancellation_reason').val('');
        }
    });

    $('.update_status').click(function() {
        var orderId = $(this).attr('data-id');
        var currentStatus = $(this).attr('data-status');
        $('#order_id').val(orderId);
        $('#order_status').val(currentStatus);
        $('#updateStatusModal').modal('show');
    });

    $('.cancel_order').click(function() {
        var orderId = $(this).attr('data-id');
        $('#order_id').val(orderId);
        $('#order_status').val('3');
        $('#cancellation_reason_group').show();
        $('#updateStatusModal').modal('show');
    });

    $('#status-update-form').submit(function(e) {
        e.preventDefault();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_status",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: function(err) {
                console.log("AJAX error: ", err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    });

    $('.delete_data').click(function() {
        var id = $(this).attr('data-id');
        if (confirm("Are you sure to delete this order?")) {
            delete_order(id);
        }
    });

    function delete_order(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_order",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: function(err) {
                console.log("AJAX error: ", err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
});
</script>
</body>
</html>
