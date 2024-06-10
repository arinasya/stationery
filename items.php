<?php 
// Initialize $title and $sub_title
$title = "";
$sub_title = "";

// Check if 'v' and 'i' parameters are set in the URL
if (isset($_GET['v']) && isset($_GET['i'])) {
    // Query to select vendor by md5(id)
    $vendor_qry = $conn->query("SELECT * FROM vendors WHERE md5(id) = '{$_GET['v']}'");
    if ($vendor_qry) {
        if ($vendor_qry->num_rows > 0) {
            $name = $vendor_qry->fetch_assoc()['name']; // Retrieve vendor name
            $title = $name; // Update $title with vendor name
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Query to select item by md5(id)
    $item_qry = $conn->query("SELECT * FROM items WHERE md5(id) = '{$_GET['i']}'");
    if ($item_qry) {
        if ($item_qry->num_rows > 0) {
            $title = $item_qry->fetch_assoc()['name']; // Update $title with item name
        }
    } else {
        echo "Error: " . $conn->error;
    }
} elseif (isset($_GET['v'])) {
    // Query to select vendor by md5(id)
    $vendor_qry = $conn->query("SELECT * FROM vendors WHERE md5(id) = '{$_GET['v']}'");
    if ($vendor_qry) {
        if ($vendor_qry->num_rows > 0) {
            $name = $vendor_qry->fetch_assoc()['name']; // Retrieve vendor name
            $title = $name; // Update $title with vendor name
        }
    } else {
        echo "Error: " . $conn->error;
    }
} elseif (isset($_GET['i'])) {
    // Query to select item by md5(id)
    $item_qry = $conn->query("SELECT * FROM items WHERE md5(id) = '{$_GET['i']}'");
    if ($item_qry) {
        if ($item_qry->num_rows > 0) {
            $title = $item_qry->fetch_assoc()['name']; // Update $title with item name
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title; ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo $sub_title; ?></p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container-fluid row">
        <?php if(isset($_GET['v'])): ?>
        <div class="col-md-3 border-right mb-2 pb-3">
            <h3><b>Items</b></h3>
            <div class="list-group">
                <a href="./?p=items&v=<?php echo $_GET['v']; ?>" class="list-group-item <?php echo !isset($_GET['i']) ? 'active' : ''; ?>">All</a>
                <?php 
                $items = $conn->query("SELECT * FROM `items` WHERE md5(vendor_id) =  '{$_GET['v']}'");
                if ($items) {
                    while($row = $items->fetch_assoc()):
                ?>
                    <a href="./?p=items&v=<?php echo $_GET['v']; ?>&i=<?php echo md5($row['id']); ?>" class="list-group-item <?php echo isset($_GET['i']) && $_GET['i'] == md5($row['id']) ? 'active' : ''; ?>"><?php echo $row['name']; ?></a>
                <?php 
                    endwhile;
                } else {
                    echo "Error: " . $conn->error;
                }
                ?>
            </div>
            <hr>
        </div>
        <?php endif; ?>
        <div class="<?php echo isset($_GET['v']) ? 'col-md-9' : 'col-md-10 offset-md-1'; ?>">
            <div class="container-fluid p-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book" aria-selected="true">Products</a>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active" id="book">
                        <?php 
                        if(isset($_GET['search'])){
                            echo "<h4 class='text-center'><b>Search Result for '".$_GET['search']."'</b></h4>";
                        }
                        ?>
                        <div class="row gx-2 gx-lg-2 row-cols-1 row-cols-md-3 row-cols-xl-3">
                            <?php 
                            $whereData = "";
                            if(isset($_GET['search'])) {
                                $whereData = " AND (name LIKE '%{$_GET['search']}%' OR charge_code LIKE '%{$_GET['search']}%' OR description LIKE '%{$_GET['search']}%')";
                            } elseif(isset($_GET['v']) && isset($_GET['i'])) {
                                $whereData = " AND (md5(vendor_id) = '{$_GET['v']}' AND md5(id) = '{$_GET['i']}')";
                            } elseif(isset($_GET['v']) && !isset($_GET['i'])) {
                                $whereData = " AND md5(vendor_id) = '{$_GET['v']}'";
                            } elseif(isset($_GET['i']) && !isset($_GET['v'])) {
                                $whereData = " AND md5(id) = '{$_GET['i']}'";
                            }
                            $items = $conn->query("SELECT * FROM items WHERE status = 1 {$whereData} ORDER BY rand()");
                            if ($items) {
                                while($row = $items->fetch_assoc()):
                                    $upload_path = base_app.'/uploads/product_'.$row['id'];
                                    $img = "";
                                    if(is_dir($upload_path)){
                                        $fileO = scandir($upload_path);
                                        if(isset($fileO[2]))
                                            $img = "uploads/product_".$row['id']."/".$fileO[2];
                                    }
                                    foreach($row as $k => $v){
                                        $row[$k] = trim(stripslashes($v));
                                    }
                                    
                                    // Fetch and format the item price with specific decimal places
                                    $price = $row['price'];
                                    // Determine the number of decimal places
                                    $decimal_places = strlen(substr(strrchr($price, "."), 1));
                                    // Format the price
                                    $item_price = number_format((float)$price, $decimal_places);
                            ?>
                            <div class="col-md-12 mb-5">
                                <div class="card product-item">
                                    <!-- Product image-->
                                    <img class="card-img-top w-100" src="<?php echo validate_image($img); ?>" loading="lazy" alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo $row['name']; ?></h5>
                                            <!-- Product price-->
                                            <span><b>Price: RM</b><?php echo $item_price; ?></span>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center">
                                            <a class="btn btn-flat btn-primary" href=".?p=view_item&id=<?php echo md5($row['id']); ?>">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                endwhile;
                            } else {
                                echo "Error: " . $conn->error;
                            }
                            if($items->num_rows <= 0){
                                echo "<h4 class='text-center'><b>No Product Listed.</b></h4>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
