<?php if(isset($_GET['view'])): 
require_once('../../config.php');
endif;?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>

<?php endif;?>

<?php 
if(!isset($_GET['id'])){
    $_settings->set_flashdata('error','No order ID Provided.');
    redirect('admin/?page=orders');
}
$order = $conn->query("SELECT o.*,department as users FROM `orders` o inner join users u on u.id = o.user_id where o.id = '{$_GET['id']}' ");
if($order->num_rows > 0){
    foreach($order->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}else{
    $_settings->set_flashdata('error','Order ID provided is Unknown');
    redirect('admin/?page=orders');
}
?>
<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="conitaner-fluid">
            <p><b>Department: <?php echo $users ?></b></p>
            <table class="table-striped table table-bordered">
                <colgroup>
                    <col width="15%">
                    <col width="35%">
                    <col width="25%">
                    <col width="25%">
                </colgroup>
                <thead>
                    <tr>
                        <th>QTY</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $olist = $conn->query("SELECT o.*, i.name, i.price FROM order_list o INNER JOIN items i ON o.item_id = i.id WHERE o.order_id = '{$row['id']}'");
                        while($row = $olist->fetch_assoc()):
                        foreach($row as $k => $v){
                            $orow[$k] = trim(stripslashes($v));
                        }
                        $quantity = $orow['quantity'];
                        $price = $orow['price'];
                        $total_item_price = $price * $quantity;
                        $total_price += $total_item_price;

                        // Store item details
                        $item_details[] = $orow['name'];
                        $total_quantity += $quantity;

                        // Calculate decimal places for the current item
                        $decimal_places = strlen(substr(strrchr($total_item_price, "."), 1));
                        $max_decimal_places = max($max_decimal_places, $decimal_places);
                    endwhile;
                    ?>
                  
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan='3'  class="text-right">Total RM</th>
                        <th class="text-right"><?php echo number_format($total_price, $max_decimal_places); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-6">
                <!--<p>confrim order: <?php echo $confirm ?></p>-->
            </div>
            <div class="col-6 row row-cols-2">
                <div class="col-3">Order Status:</div>
                <div class="col-9">
                <?php 
                    switch($status){
                        case '0':
                            echo '<span class="badge badge-light text-dark">Order Placed</span>';
	                    break;
                        case '1':
                            echo '<span class="badge badge-primary">Processing</span>';
	                    break;
                        case '2':
                            echo '<span class="badge badge-primary">Completed</span>';
                        break;
                        default:
                            echo '<span class="badge badge-danger">Cancelled</span>';
	                    break;
                    }
                ?>
                </div>
                <?php if(!isset($_GET['view'])): ?>
                <div class="col-3"></div>
                <div class="col">
                    <button type="button" id="update_status" class="btn btn-sm btn-flat btn-primary">Update Status</button>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    </div>
<?php if(isset($_GET['view'])): ?>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal>.modal-dialog>.modal-content>.modal-footer{
        display:none;
    }
    #uni_modal .modal-body{
        padding:0;
    }
</style>
<?php endif; ?>
<script>
    $(function(){
        $('#update_status').click(function(){
            uni_modal("Update Status", "./orders/update_status.php?oid=<?php echo $id ?>&status=<?php echo $status ?>")
        })
    })
</script>
 