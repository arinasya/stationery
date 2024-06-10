<?php 
// Initialize $title and $sub_title
$title = "All Stationery Vendor";
$sub_title = "";

// Check if 'v' and 'i' parameters are set in the URL
if (isset($_GET['v']) && isset($_GET['i'])) {
    // Query to select vendor by md5(id)
    $vendor_qry = $conn->query("SELECT * FROM vendors WHERE md5(id) = '{$_GET['v']}'");
    if ($vendor_qry->num_rows > 0) {
        $name = $vendor_qry->fetch_assoc()['name']; // Retrieve vendor name
        $title = $name; // Update $title with vendor name
    }
    
    // Query to select item by md5(id)
    $item_qry = $conn->query("SELECT * FROM items WHERE md5(id) = '{$_GET['i']}'");
    if ($item_qry->num_rows > 0) {
        $title = $item_qry->fetch_assoc()['name']; // Update $title with item name
    }
} elseif (isset($_GET['v'])) {
    // Query to select vendor by md5(id)
    $vendor_qry = $conn->query("SELECT * FROM vendors WHERE md5(id) = '{$_GET['v']}'");
    if ($vendor_qry->num_rows > 0) {
        $name = $vendor_qry->fetch_assoc()['name']; // Retrieve vendor name
        $title = $name; // Update $title with vendor name
    }
} elseif (isset($_GET['i'])) {
    // Query to select item by md5(id)
    $item_qry = $conn->query("SELECT * FROM items WHERE md5(id) = '{$_GET['i']}'");
    if ($item_qry->num_rows > 0) {
        $title = $item_qry->fetch_assoc()['name']; // Update $title with item name
    }
}
?>
<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo $sub_title ?></p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-2 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-2 justify-content-center">
           
            <?php 
                $whereData = "";
                $vendors = $conn->query("SELECT id, name FROM vendors WHERE status = 1 ORDER BY name ASC");
                while ($row = $vendors->fetch_assoc()):
            ?>
            <div class="col mb-6 mb-2">
                <a href="./?p=items&c=<?php echo md5($row['id']) ?>" class="card vendor-item text-dark">
                    <div class="card-body p-4">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder border-bottom border-primary">
                                <?php 
                                if (isset($row['name'])) {
                                    echo $row['name']; // Output vendor name
                                } else {
                                    echo "No name available"; // Handle the case when 'name' index is not found
                                }
                                ?>
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section> 
