<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
  <div class="info-box-content">
  <span class="info-box-number">
                  <?php 
                   
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Users</span>
        <span class="info-box-number">
          <?php
            $users_query = $conn->query("SELECT COUNT(id) as total_users FROM users");
            if($users_query) {
              $total_users = $users_query->fetch_assoc()['total_users'];
              echo number_format($total_users);
            } else {
              echo "Error: " . $conn->error;
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
          $qry = $conn->query("SELECT SUM(total_amount) as total_amount FROM orders");

          if ($qry) {
              $row = $qry->fetch_assoc();
              $total_amount = $row['total_amount'];

              // Determine if 3 decimal places are needed
              $decimal_places = (floor($total_amount * 1000) == $total_amount * 1000) ? 3 : 2;
              $formatted_total_amount = number_format($total_amount, $decimal_places);

              echo " RM" . $formatted_total_amount;
          } else {
              echo "Error: " . $conn->error;
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
    $items_query = $conn->query("SELECT * FROM `items` order by rand()");
    if ($items_query) {
      while($row = $items_query->fetch_assoc()){
        if(!is_dir(base_app.'uploads/product_'.$row['id']))
          continue;
        $fopen = scandir(base_app.'uploads/product_'.$row['id']);
        foreach($fopen as $fname){
          if(in_array($fname,array('.','..')))
            continue;
          $files[]= validate_image('uploads/product_'.$row['id'].'/'.$fname);
        }
      }
    } else {
      echo "Error: " . $conn->error;
    }
  ?>
  <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner h-100">
      <?php foreach($files as $k => $img): ?>
      <div class="carousel-item h-100 <?php echo $k == 0? 'active': '' ?>">
        <img class="d-block w-100 h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
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
