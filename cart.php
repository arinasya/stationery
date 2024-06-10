<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-end mb-2">
                <button class="btn btn-outline-dark btn-flat btn-sm" type="button" id="empty_cart">Empty Cart</button>
            </div>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <h3><b>Cart List</b></h3>
                <hr class="border-dark">
                <?php 
                $qry = $conn->query("SELECT c.*, i.name, i.price, i.id as item_id FROM `cart` c INNER JOIN `items` i ON i.id = c.item_id WHERE c.user_id = ".$_settings->userdata('id'));
                if(!$qry) {
                    die("Query failed: " . $conn->error);
                }

                while($row = $qry->fetch_assoc()):
                    $upload_path = base_app.'/uploads/product_'.$row['item_id'];
                    $img = "";
                    foreach($row as $k => $v) {
                        $row[$k] = trim(stripslashes($v));
                    }
                    if(is_dir($upload_path)) {
                        $fileO = scandir($upload_path);
                        if(isset($fileO[2])) {
                            $img = "uploads/product_".$row['item_id']."/".$fileO[2];
                        }
                    }
                    $price = $row['price'];
                    $decimal_places = strlen(substr(strrchr($price, "."), 1));
                    $item_price = number_format((float)$price, $decimal_places);
                ?>

                <div class="d-flex w-100 justify-content-between mb-2 py-2 border-bottom cart-item">
                    <div class="d-flex align-items-center col-8">
                        <span class="mr-2"><a href="javascript:void(0)" class="btn btn-sm btn-outline-danger rem_item" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a></span>
                        <img src="<?php echo validate_image($img) ?>" loading="lazy" class="cart-prod-img mr-2 mr-sm-2" alt="">
                        <div>
                            <p class="mb-1 mb-sm-1"><?php echo $row['name'] ?></p>
                            <p class="mb-1 mb-sm-1"><small><b>Price:</b> <span class="price"><?php echo $item_price ?></span></small></p>
                            <div>
                                <div class="input-group" style="width:130px !important">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-sm btn-outline-secondary min-qty" type="button" id="button-addon1"><i class="fa fa-minus"></i></button>
                                    </div>
                                    <input type="number" class="form-control form-control-sm qty text-center cart-qty" placeholder="" value="<?php echo $row['quantity'] ?>" aria-describedby="button-addon1" data-id="<?php echo $row['id'] ?>" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-outline-secondary plus-qty" type="button" id="button-addon1"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-right align-items-center d-flex justify-content-end">
                        <h4><b class="total-amount"><?php echo number_format((float)($item_price * $row['quantity']), $decimal_places) ?></b></h4>
                    </div>
                </div>
                <?php endwhile; ?>
                <div class="d-flex w-100 justify-content-between mb-2 py-2 border-bottom">
                    <div class="col-8 d-flex justify-content-end"><h4>Grand Total: RM</h4></div>
                    <div class="col d-flex justify-content-end"><h4 id="grand-total">-</h4></div>
                </div>
            </div>
        </div>
        <div class="d-flex w-100 justify-content-end">
            <a href="./?p=checkout" class="btn btn-sm btn-flat btn-dark">Checkout</a>
        </div>
    </div>
</section>
<script>
    function getMaxDecimalPlaces() {
        var maxDecimalPlaces = 0;
        $('.price').each(function() {
            var decimalPlaces = (($(this).text().split('.')[1] || "").length);
            if (decimalPlaces > maxDecimalPlaces) {
                maxDecimalPlaces = decimalPlaces;
            }
        });
        return maxDecimalPlaces;
    }

    function calc_total() {
        var total = 0;
        $('.total-amount').each(function() {
            var amount = $(this).text().replace(/,/g, '');
            amount = parseFloat(amount);
            total += amount;
        });
        var maxDecimalPlaces = getMaxDecimalPlaces();
        $('#grand-total').text(total.toLocaleString('en-US', { minimumFractionDigits: maxDecimalPlaces, maximumFractionDigits: maxDecimalPlaces }));
    }

    function qty_change(type, _this) {
        var qty = parseInt(_this.closest('.cart-item').find('.cart-qty').val());
        var price = parseFloat(_this.closest('.cart-item').find('.price').text().replace(/,/g, ''));
        var cart_id = _this.closest('.cart-item').find('.cart-qty').data('id');
        var new_total = 0;

        start_loader();

        if (type === 'minus') {
            qty = Math.max(qty - 1, 1);  // Ensure quantity doesn't go below 1
        } else {
            qty += 1;
        }

        new_total = (qty * price).toFixed(2);
        _this.closest('.cart-item').find('.cart-qty').val(qty);
        _this.closest('.cart-item').find('.total-amount').text(new_total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        calc_total();

        $.ajax({
            url: 'classes/Master.php?f=update_cart_qty',
            method: 'POST',
            data: { id: cart_id, quantity: qty },
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    end_loader();
                } else {
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            }
        });
    }

    function rem_item(id) {
        var _this = $('.rem_item[data-id="'+id+'"]');
        var item = _this.closest('.cart-item');

        start_loader();

        $.ajax({
            url: 'classes/Master.php?f=delete_cart',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    item.hide('slow', function() { item.remove(); });
                    calc_total();
                    end_loader();
                } else {
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            }
        });
    }

    function empty_cart() {
        start_loader();

        $.ajax({
            url: 'classes/Master.php?f=empty_cart',
            method: 'POST',
            data: {},
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            }
        });
    }

    $(function() {
        calc_total();
        $('.min-qty').click(function() {
            qty_change('minus', $(this));
        });
        $('.plus-qty').click(function() {
            qty_change('plus', $(this));
        });
        $('#empty_cart').click(function() {
            _conf("Are you sure to empty your cart list?", 'empty_cart', []);
        });
        $('.rem_item').click(function() {
            _conf("Are you sure to remove the item in cart list?", 'rem_item', [$(this).data('id')]);
        });
    });
</script>
