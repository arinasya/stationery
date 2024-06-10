<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">KPJ Stationery </h1>
            <p class="lead fw-normal text-white-50 mb-0">Order Now!</p>
        </div>
    </div>
</header>
<!-- Section-->
<style>
    .book-cover{
        object-fit: contain !important;
        height: auto !important;
    }
</style>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
                $items = $conn->query("SELECT * FROM `items` WHERE status = 1 ORDER BY RAND() LIMIT 8");
                while($item = $items->fetch_assoc()):
                    $upload_path = base_app.'/uploads/product_'.$item['id'];
                    $img = "";
                    if(is_dir($upload_path)){
                        $fileO = scandir($upload_path);
                        if(isset($fileO[2]))
                            $img = "uploads/product_".$item['id']."/".$fileO[2];
                    }
                    foreach($item as $k => $v){
                        $item[$k] = trim(stripslashes($v));
                    }
                    
                    // Fetch and format the item price with specific decimal places
                    $item_price = "";
                    if (!empty($item['id'])) {
                        $id = $item['id'];
                        $item_result = $conn->query("SELECT price FROM items WHERE id = ".$id);
                        if ($row = $item_result->fetch_assoc()) {
                            $price = $row['price'];
                            // Determine the number of decimal places
                            $decimal_places = strlen(substr(strrchr($price, "."), 1));
                            // Format the price
                            $item_price = number_format((float)$price, $decimal_places);
                        }
                    }
            ?>
            <div class="col mb-5">
                <div class="card product-item">
                    <!-- Product image-->
                    <img class="card-img-top w-100 book-cover" src="<?php echo validate_image($img) ?>" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $item['name'] ?></h5>
                            <!-- Product price-->
                            <span><b>Price: RM</b><?php echo $item_price ?></span>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary" href=".?p=view_item&id=<?php echo md5($item['id']) ?>">View</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
