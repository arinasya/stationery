<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add necessary meta tags and CSS links here -->
</head>
<body>
<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body"></div>
            <h3 class="text-center"><b>Checkout</b></h3>
            <hr class="border-dark">
            <form action="" id="place_order">
                <!-- Ensure that $formatted_total is defined -->
                <input type="hidden" name="amount" value="<?php echo isset($formatted_total) ? $formatted_total : '0.00'; ?>">
                <input type="hidden" name="request" value="confirm">
                <input type="hidden" name="confirm" value="0">
                <div class="row row-col-1 justify-content-center">
                    <div class="col-6">
                        <div class="form-group col address-holder">
                            <label for="" class="control-label">Department</label>
                            <textarea id="" cols="30" rows="3" name="department" class="form-control" style="resize:none"><?php echo $_settings->userdata('department') ?></textarea>
                        </div>
                        <div class="col">
                            <?php 
                            // Initialize total price
                            $total_price = 0;
                            // Initialize maximum decimal places
                            $max_decimal_places = 0;
                            // Fetch items from the database
                            $qry = $conn->query("SELECT c.*, i.name, i.price, i.id as item_id FROM `cart` c INNER JOIN `items` i ON i.id = c.item_id WHERE c.user_id = ".$_settings->userdata('id'));
                            if(!$qry) {
                                die("Query failed: " . $conn->error);
                            }
                            // Loop through items to calculate total price
                            while($row = $qry->fetch_assoc()):
                                $price = $row['price'];
                                $quantity = $row['quantity'];
                                // Calculate total price for the current item and accumulate
                                $total_item_price = $price * $quantity;
                                $total_price += $total_item_price;
                                // Calculate decimal places for the current item
                                $decimal_places = strlen(substr(strrchr($total_item_price, "."), 1));
                                // Update maximum decimal places
                                $max_decimal_places = max($max_decimal_places, $decimal_places);
                            endwhile;
                            // Display the total price for all items with specific decimal places
                            echo '<span><h4><b>Total: RM</b> ' . number_format($total_price, $max_decimal_places) . '</h4></span>';
                            ?>
                        </div>
                        <hr>
                        <div class="col my-3">
                            <h4 class="text-muted"></h4>
                            <div class="d-flex w-100 justify-content-between">
                                <button class="btn btn-flat btn-dark">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
$(function(){
    $('#place_order').submit(function(e){
        e.preventDefault()
        start_loader();
        $.ajax({
            url:'classes/Master.php?f=place_order',
            method:'POST',
            data:$(this).serialize(),
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("an error occured","error")
                end_loader();
            },
            success:function(resp){
                if(!!resp.status && resp.status == 'success'){
                    alert_toast("Order Successfully placed.","success")
                    setTimeout(function(){
                        location.replace('./')
                    },2000)
                }else{
                    console.log(resp)
                    alert_toast("an error occured","error")
                    end_loader();
                }
            }
        })
    })
})
</script>

</body>
</html>
