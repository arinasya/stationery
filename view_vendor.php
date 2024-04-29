<?php 
$title = "All Stationery Vendor";
$sub_title = "";
if(isset($_GET['v']) && isset($_GET['i'])){
    $vendor_qry = $conn->query("SELECT * FROM vendors where md5(id) = '{$_GET['v']}'");
    if($vendor_qry->num_rows > 0){
        $name = $vendor_qry->fetch_assoc()['name'];
    }
 $item_qry = $conn->query("SELECT * FROM items where md5(id) = '{$_GET['i']}'");
    if($item_qry->num_rows > 0){
        $title = $item_qry->fetch_assoc()['name'];
    }
}
elseif(isset($_GET['v'])){
    $vendor_qry = $conn->query("SELECT * FROM vendors where md5(id) = '{$_GET['v']}'");
    if($vendor_qry->num_rows > 0){
        $name = $vendor_qry->fetch_assoc()['name'];
    }
}
elseif(isset($_GET['i'])){
    $item_qry = $conn->query("SELECT * FROM items where md5(id) = '{$_GET['i']}'");
    if($item_qry->num_rows > 0){
        $title = $item_qry->fetch_assoc()['name'];
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
                $vendors = $conn->query("SELECT * FROM `vendors` where status = 1 order by name asc ");
                while($row = $vendors->fetch_assoc()):
                    foreach($row as $k=> $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    
            ?>
            <div class="col mb-6 mb-2">
                <a href="./?p=items&c=<?php echo md5($row['id']) ?>" class="card vendor-item text-dark">
                    <div class="card-body p-4">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder border-bottom border-primary"><?php echo $row['name'] ?></h5>
                        </div>
                       
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>