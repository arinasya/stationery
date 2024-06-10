<?php 

$id = $_GET['id'];
$items = $conn->query("SELECT * FROM `items` WHERE md5(id) = '{$id}' ");

if(!$items) {
    echo "Query Error: " . $conn->error;
} else {
    if($items->num_rows > 0) {
        $row = $items->fetch_assoc();
        $item_id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $vendor_id = $row['vendor_id'];

        $upload_path = base_app.'/uploads/product_'.$row['id'];
        $fileO = scandir($upload_path);
        $img = "";
        if(isset($fileO[2])) {
            $img = "uploads/product_".$row['id']."/".$fileO[2];
        }

        $item_result = $conn->query("SELECT price FROM items WHERE id = ".$row['id']);
        $item_price = "";
        if(!$item_result) {
            echo "Price Query Error: " . $conn->error;
        } else {
            if ($price_row = $item_result->fetch_assoc()) {
                $price = $price_row['price'];
                // Determine the number of decimal places
                $decimal_places = strlen(substr(strrchr($price, "."), 1));
                // Format the price
                $item_price = number_format((float)$price, $decimal_places);
            }
        }
    } else {
        echo "No item found.";
    }
}
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0" loading="lazy" id="display-img" src="<?php echo validate_image($img) ?>" alt="..." />
                <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                    <?php 
                    // Add image thumbnails if available
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <?php if(isset($name)):  ?>
                    <h1 class="display-5 fw-bolder border-bottom border-primary pb-1"><?php echo $name  ?></h1>
                <?php endif; ?>
                <div class="fs-5 mb-5">
                    RM<span id="price"><?php echo $item_price ?></span>
                    <br>
                    <form action="" id="add-cart">
                        <div class="d-flex">
                            <input type="hidden" name="price" value="<?php echo $item_price ?>">
                            <input type="hidden" name="item_id" value="<?php echo isset($item_id) ? $item_id : '' ?>">
                            <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 3rem" name="quantity">
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </div>
                    </form>
                </div>
                <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
            $related_items = $conn->query("SELECT * FROM `items` WHERE status = 1 AND (vendor_id = '{$vendor_id}' OR id = '{$id}') AND id != '{$id}' ORDER BY rand() LIMIT 4");
            while($related_row = $related_items->fetch_assoc()):
                $related_upload_path = base_app.'/uploads/product_'.$related_row['id'];
                $related_img = "";
                if(is_dir($related_upload_path)){
                    $related_fileO = scandir($related_upload_path);
                    if(isset($related_fileO[2]))
                        $related_img = "uploads/product_".$related_row['id']."/".$related_fileO[2];
                }
                $related_item_result = $conn->query("SELECT price FROM items WHERE id = ".$related_row['id']);
                $related_item_price = "";
                if ($related_price_row = $related_item_result->fetch_assoc()) {
                    $related_price = $related_price_row['price'];
                    $decimal_places = strlen(substr(strrchr($related_price, "."), 1));
                    $related_item_price = number_format((float)$related_price, $decimal_places);
                }
            ?>
            <div class="col mb-5">
                <div class="card h-100 product-item">
                    <img class="card-img-top w-100" src="<?php echo validate_image($related_img) ?>" alt="..." />
                    <div class="card-body p-4">
                        <div class="">
                            <h5 class="fw-bolder"><?php echo $related_row['name'] ?></h5>
                            <span><b>Price: RM</b><?php echo $related_item_price ?></span>
                        </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary" href=".?p=view_item&id=<?php echo md5($related_row['id']) ?>">View</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
    $(function(){
        $('.view-image').click(function(){
            var _img = $(this).find('img').attr('src');
            $('#display-img').attr('src', _img);
            $('.view-image').removeClass("active")
            $(this).addClass("active")
        });

        $('#add-cart').submit(function(e){
            e.preventDefault();
            if('<?php echo $_settings->userdata('id') ?>' <= 0){
                uni_modal("","test.php");
                return false;
            }
            start_loader();
            $.ajax({
                url: 'classes/Master.php?f=add_to_cart',
                data: $(this).serialize(),
                method: 'POST',
                dataType: "json",
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if (typeof resp === 'object' && resp.status == 'success'){
                        alert_toast("Product added to cart.", 'success');
                        $('#cart-count').text(resp.cart_count);
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                    }
                    end_loader();
                }
            });
        });
    });
</script>
