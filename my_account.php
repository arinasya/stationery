<section class="py-2">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Orders</b></h4>
                   <!-- <a href="./?p=edit_account" class="btn btn-dark btn-flat"><div class="fa fa-user-cog"></div> Manage Account</a>-->
                </div>
                <hr class="border-warning">
                <table class="table table-stripped text-dark">
                    <colgroup>
                        <col width="10%">
                        <col width="15%">
                        <col width="25%">
                        <col width="25%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DateTime</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            $qry = $conn->query("
                                SELECT 
                                    o.*, 
                                    u.username as user 
                                FROM 
                                    `orders` o 
                                    INNER JOIN `users` u ON u.id = o.user_id 
                                WHERE 
                                    o.user_id = '".$_settings->userdata('id')."' 
                                ORDER BY 
                                    unix_timestamp(o.order_date) DESC
                            ");
                            while($row = $qry->fetch_assoc()):
                                $order_id = $row['id'];
                                $total_amount = 0;
                                $max_decimal_places = 2; // Default to 2 decimal places
                            
                                // Fetch order items and calculate total amount with respective decimal places
                                $order_items = $conn->query("
                                    SELECT 
                                        ol.quantity, 
                                        ol.price 
                                    FROM 
                                        `order_list` ol 
                                    WHERE 
                                        ol.order_id = '{$order_id}'
                                ");
                            
                                while ($item = $order_items->fetch_assoc()) {
                                    $quantity = $item['quantity'];
                                    $price = $item['price'];
                                    $item_total = $quantity * $price;
                            
                                    // Determine the decimal places for the item price
                                    $decimal_places = strlen(substr(strrchr(rtrim($price, '0'), "."), 1));
                                    $max_decimal_places = max($max_decimal_places, $decimal_places);
                            
                                    $total_amount += $item_total;
                                }
                                // Ensure decimal places are 2 or 3
                                $decimal_places_to_use = $max_decimal_places > 2 ? 3 : 2;
                                $formatted_total_amount = number_format($total_amount, $decimal_places_to_use);
                        ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['order_date'])) ?></td>
                            <td><a href="javascript:void(0)" class="view_order" data-id="<?php echo $row['id'] ?>"><?php echo md5($row['id']); ?></a></td>
                            <td><?php echo $formatted_total_amount; ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 0): ?>
                                    <span class="badge badge-light text-dark">Pending</span>
                                <?php elseif($row['status'] == 1): ?>
                                    <span class="badge badge-primary">Completed</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Cancelled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script>
    function cancel_book($id){
        start_loader()
        $.ajax({
            url:_base_url_+"classes/Master.php?f=update_book_status",
            method:"POST",
            data:{id:$id,status:2},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occurred",'error')
                end_loader()
            },
            success:function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    alert_toast("Order cancelled successfully",'success')
                    setTimeout(function(){
                        location.reload()
                    },2000)
                }else{
                    console.log(resp)
                    alert_toast("An error occurred",'error')
                }
                end_loader()
            }
        })
    }
    $(function(){
        $('.view_order').click(function(){
            uni_modal("Order Details","./admin/orders/view_order.php?view=user&id="+$(this).attr('data-id'),'large')
        })
        $('table').dataTable();
    })
</script>
