<section class="py-2">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Orders</b></h4>
                    <!-- <a href="./?p=edit_account" class="btn btn-dark btn-flat"><div class="fa fa-user-cog"></div> Manage Account</a>-->
                </div>
                <form id="filter-form" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="date_start">Start Date</label>
                            <input type="date" class="form-control" id="date_start" name="date_start" value="<?php echo $date_start; ?>" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="date_end">End Date</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" value="<?php echo $date_end; ?>" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>
                <hr class="border-warning">
                <table class="table table-stripped text-dark">
                    <colgroup>
                        <col width="4%">
                        <col width="10%">
                        <col width="25%">
                        <col width="4%">
                        <col width="5%">
                        <col width="5%">
                        <col width="5%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DateTime</th>
                            <th>Items</th>
                            <th>QTY</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                            <th>Action</th>
                            <th>Cancellation Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d", strtotime("-7 days"));
                            $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");

                            $qry = $conn->query("
                                SELECT 
                                    o.*, 
                                    u.username as user 
                                FROM 
                                    `orders` o 
                                    INNER JOIN `users` u ON u.id = o.user_id 
                                WHERE 
                                    o.user_id = '".$_settings->userdata('id')."' 
                                    AND DATE(o.order_date) BETWEEN '{$date_start}' AND '{$date_end}'
                                ORDER BY  
                                    unix_timestamp(o.order_date) DESC
                            ");

                            if ($qry) {
                                while($row = $qry->fetch_assoc()):
                                    $order_id = $row['id'];
                                    $total_amount = 0;
                                    $total_quantity = 0;
                                    $max_decimal_places = 2; // Default to 2 decimal places
                        ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['order_date'])) ?></td>
                            <td>
                                <?php 
                                      $olist = $conn->query("SELECT o.*, i.name, i.price FROM order_list o INNER JOIN items i ON o.item_id = i.id WHERE o.order_id = '{$row['id']}'");
                                    
                                    if ($olist) {
                                        $item_number = 1; // Initialize item number
                                        while ($item = $olist->fetch_assoc()) {
                                            $quantity = $item['quantity'];
                                            $price = $item['price'];
                                            $item_total = $quantity * $price;
                                
                                            // Determine the decimal places for the item price
                                            $decimal_places = strlen(substr(strrchr(rtrim($price, '0'), "."), 1));
                                            $max_decimal_places = max($max_decimal_places, $decimal_places);
                                
                                            $total_amount += $item_total;
                                            $total_quantity += $quantity;

                                            // Display item name with incrementing number
                                            echo $item_number++ . ". " . $item['name'] . "<br>";
                                        }
                                    } else {
                                        echo "Error fetching order items: " . $conn->error;
                                    }
                                    
                                    // Ensure decimal places are 2 or 3
                                    $decimal_places_to_use = $max_decimal_places > 2 ? 3 : 2;
                                    $formatted_total_amount = number_format($total_amount, $decimal_places_to_use);
                                ?>
                            </td>
                            <td><?php echo $total_quantity; ?></td>
                            <td><?php echo $formatted_total_amount; ?></td>
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
                            <td class="text-center">
                                <?php if($row['status'] == 0 || $row['status'] == 1): ?>
                                    <button class="btn btn-danger btn-sm cancel_order" data-id="<?php echo $order_id; ?>">Cancel Order</button>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['cancellation_reasons']; ?></td>
                        </tr>
                        <?php 
                                endwhile;
                            } else {
                                echo "Error fetching orders: " . $conn->error;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal HTML for Cancellation Reason -->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cancelModalLabel">Cancel Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="cancelOrderForm">
              <div class="form-group">
                <label for="cancellationReason">Reason for Cancellation</label>
                <textarea class="form-control" id="cancellationReason" name="cancellationReason" rows="3" required></textarea>
              </div>
              <input type="hidden" id="cancelOrderId" name="order_id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="submitCancelOrder">Cancel Order</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      function showCancelModal(order_id) {
        $('#cancelOrderId').val(order_id);
        $('#cancelModal').modal('show');
      }

      $(function(){
        $('#filter-form').submit(function(e) {
                e.preventDefault();
                location.href = "./?p=my_account&date_start=" + $('[name="date_start"]').val() + "&date_end=" + $('[name="date_end"]').val();
            });
        $('.cancel_order').click(function(){
          var order_id = $(this).data('id');
          showCancelModal(order_id);
        });

        $('#submitCancelOrder').click(function() {
          var order_id = $('#cancelOrderId').val();
          var reason = $('#cancellationReason').val();
          if (reason.trim() === '') {
            alert('Please provide a reason for cancellation.');
            return;
          }
          cancel_order(order_id, reason);
        });

        function cancel_order(order_id, reason) {
          start_loader();
          $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_status",
            method: "POST",
            data: {id: order_id, status: 3, cancellation_reason: reason},
            dataType: "json",
            error: err => {
              console.log(err);
              alert_toast("An error occurred", 'error');
              end_loader();
            },
            success: function(resp) {
              if (typeof resp == 'object' && resp.status == 'success') {
                alert_toast("Order cancelled successfully", 'success');
                setTimeout(function() {
                  location.reload();
                }, 2000);
              } else {
                console.log(resp);
                alert_toast("An error occurred", 'error');
              }
              end_loader();
            }
          });
        }

        $('.view_order').click(function(){
          uni_modal("Order Details","./admin/orders/view_order.php?view=user&id="+$(this).attr('data-id'),'large');
        });
        $('table').dataTable();
      });
    </script>
