<style>
    table td, table th {
        padding: 3px !important;
    }
</style>
<?php 
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d", strtotime("-7 days"));
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");
$max_decimal_places = 2; // Initialize max decimal places
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Sales Report</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Date Start</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo $date_start; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_end">Date End</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo $date_end; ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </form>
        <hr>
        <div id="printable">
            <div>
                <h4 class="text-center m-0"><?php echo $_settings->info('name'); ?></h4>
                <h3 class="text-center m-0"><b>Sales Report</b></h3>
                <p class="text-center m-0">Date Between <?php echo $date_start; ?> and <?php echo $date_end; ?></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="10">
                    <col width="20">
                    <col width="10">
                </colgroup>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Department</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $qry = $conn->query("SELECT DATE(o.order_date) as date, u.department, SUM(ol.quantity * ol.price) as total_amount 
                                         FROM order_list ol 
                                         INNER JOIN orders o ON o.id = ol.order_id 
                                         INNER JOIN users u ON u.id = o.user_id  
                                         WHERE DATE(o.order_date) BETWEEN '{$date_start}' AND '{$date_end}'
                                         GROUP BY DATE(o.order_date), u.department 
                                         ORDER BY DATE(o.order_date) DESC, u.department ASC");
                    if ($qry) {
                        while ($row = $qry->fetch_assoc()) {
                            // Determine if 3 decimal places are needed
                            $total_amount = $row['total_amount'];
                            $decimal_places = (floor($total_amount * 1000) == $total_amount * 1000) ? 3 : 2;
                            $formatted_total_amount = number_format($total_amount, $decimal_places);
                            ?>
                            <tr>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <td class="text-right"><?php echo $formatted_total_amount; ?></td>
                            </tr>
                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='3'>Error in sales query: " . $conn->error . "</td></tr>";
                    }
                    if ($qry->num_rows <= 0): ?>
                    <tr>
                        <td class="text-center" colspan="3">No Data...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<noscript>
    <style>
        .m-0 {
            margin: 0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table tr, .table td, .table th {
            border: 1px solid gray;
        }
    </style>
</noscript>
<script>
    $(function() {
        $('#filter-form').submit(function(e) {
            e.preventDefault();
            location.href = "./?page=sales&date_start=" + $('[name="date_start"]').val() + "&date_end=" + $('[name="date_end"]').val();
        });

        $('#printBTN').click(function() {
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader();
            rep.prepend(ns);
            var nw = window.document.open('', '_blank', 'width=900,height=600');
            nw.document.write(rep.html());
            nw.document.close();
            nw.print();
            setTimeout(function() {
                nw.close();
                end_loader();
            }, 500);
        });
    });

    function start_loader() {
        // Add your loader start logic here
    }

    function end_loader() {
        // Add your loader end logic here
    }
</script>
