<?php 
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d", strtotime("-7 days"));
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");
$vendor = isset($_GET['vendor']) ? $_GET['vendor'] : '';
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Summary Order</h5>
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
                <div class="form-group col-md-3">
                    <label for="vendor">Vendor</label>
                    <input type="text" class="form-control form-control-sm" name="vendor" value="<?php echo htmlspecialchars($vendor); ?>">
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
                <h3 class="text-center m-0"><b>Summary Order</b></h3>
                <p class="text-center m-0">Date Between <?php echo $date_start; ?> and <?php echo $date_end; ?></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="25%">
                    <col width="25%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Charge Code</th>
                        <th>Vendor</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>QTY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Debug: Print date values
                    echo "<!-- Date Start: {$date_start}, Date End: {$date_end} -->";

                    $vendor_filter = $vendor ? "AND v.name LIKE '%" . $conn->real_escape_string($vendor) . "%'" : '';

                    $query = "
                        SELECT DATE(o.order_date) as date, v.name as vendor_name, i.charge_code , i.name as item_name, ol.price, SUM(ol.quantity) as total_quantity
                        FROM order_list ol
                        INNER JOIN orders o ON o.id = ol.order_id
                        INNER JOIN vendors v ON v.id = ol.vendor_id
                        INNER JOIN items i ON i.id = ol.item_id
                        WHERE DATE(o.order_date) BETWEEN '{$date_start}' AND '{$date_end}' {$vendor_filter}
                        GROUP BY DATE(o.order_date), v.name, i.charge_code, i.name, ol.price
                        ORDER BY DATE(o.order_date) DESC, v.name ASC, i.charge_code ASC, i.name ASC, ol.price ASC
                    ";

                    // Debug: Print query
                    echo "<!-- Query: {$query} -->";

                    $qry = $conn->query($query);

                    if ($qry) {
                        if ($qry->num_rows > 0) {
                            while ($row = $qry->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row['charge_code']; ?></td>
                                    <td><?php echo $row['vendor_name']; ?></td>
                                    <td><?php echo $row['item_name']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td class="text-right"><?php echo $row['total_quantity']; ?></td>
                                </tr>
                                <?php 
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No Data...</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Error in summary query: " . $conn->error . "</td></tr>";
                    }
                    ?>
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
            location.href = "./?page=summary&date_start=" + encodeURIComponent($('[name="date_start"]').val()) + "&date_end=" + encodeURIComponent($('[name="date_end"]').val()) + "&vendor=" + encodeURIComponent($('[name="vendor"]').val());
        });

        $('#printBTN').click(function() {
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader();
            rep.prepend(ns);
            var nw = window.document.open('', '_blank', 'width=900, height=600');
            nw.document.write(rep.html());
            nw.document.close();
            nw.print();
            setTimeout(function() {
                nw.close();
                end_loader();
            }, 500);
        });
    });
</script>
