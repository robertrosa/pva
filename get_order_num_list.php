<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

// connect to the sqlsrv database
//$ss_conn = connect_SQLSRV_PVDB();
$ss_conn = connect_SQLSRV_PVDB_test();

// pick up the service id from a get variable
$servicecode = $_GET['servicecode'];

// Get list of order numbers for the given service
$ss_sql = "SELECT DISTINCT OrderNumber FROM dbo.pv_order_main WHERE (ServiceCode = " . $servicecode . ")";

$order_numbers = sqlsrv_query($ss_conn, $ss_sql); ?>

<option selected disabled>Select an order number...</option>
<?php while ($order_number = sqlsrv_fetch_array($order_numbers)): ?>
    <option value="<?php echo $order_number['OrderNumber']; ?>"><?php echo $order_number['OrderNumber']; ?></option>
<?php endwhile;