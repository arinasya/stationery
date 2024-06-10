<?php
// Display errors for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<h1>Welcome to <?php echo $_settings->info('name'); ?></h1>
<hr>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box-content">
            <span class="info-box-number">
                <?php 
                // Item query
                $item_query = $conn->query("SELECT COUNT(*) AS total FROM items WHERE item_id= $id");
                if ($item_query) {
                    $item = $item_query->fetch_assoc()['total'];
                    // Sales query
                    $sales_query = $conn->query("SELECT sum(quantity) as total FROM order_list WHERE order_id IN (SELECT order_id FROM sales)");
                    if ($sales_query) {
                        $sales = $sales_query->fetch_assoc()['total'];
                        echo number_format($item - $sales);
                    } else {
                        echo "Error in sales query: " . $conn->error;
                    }
                } else {
                    echo "Error in item query: " . $conn->error;
                }
                ?>
            </span>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pending Orders</span>
                <span class="info-box-number">
                    <?php 
                    $pending_query = $conn->query("SELECT sum(id) as total FROM orders WHERE status = '0'");
                    if ($pending_query) {
                        $pending = $pending_query->fetch_assoc()['total'];
                        echo number_format($pending);
                    } else {
                        echo "Error in pending orders query: " . $conn->error;
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Sales</span>
                <span class="info-box-number">
                    <?php 
                    $sales_query = $conn->query("SELECT sum(total_amount) as total FROM `orders` WHERE status = '0'");
                    if ($sales_query) {
                        $sales = $sales_query->fetch_assoc()['total'];
                        echo number_format($sales);
                    } else {
                        echo "Error in sales query: " . $conn->error;
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php 
    $files = array();
    $items_query = $conn->query("SELECT * FROM `items` ORDER BY RAND()");
    if ($items_query) {
        while ($row = $items_query->fetch_assoc()) {
            if (!is_dir(base_app.'uploads/product_'.$row['id'])) continue;
            $fopen = scandir(base_app.'uploads/product_'.$row['id']);
            foreach ($fopen as $fname) {
                if (in_array($fname, array('.', '..'))) continue;
                $files[] = validate_image('uploads/product_'.$row['id'].'/'.$fname);
            }
        }
    } else {
        echo "Error in items query: " . $conn->error;
    }
    ?>
    <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner h-100">
            <?php foreach ($files as $k => $img): ?>
            <div class="carousel-item h-100 <?php echo $k == 0 ? 'active' : ''; ?>">
                <img class="d-block w-100 h-100" style="object-fit:contain" src="<?php echo $img; ?>" alt="">
            </div>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
