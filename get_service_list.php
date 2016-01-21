<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

// connect to the sqlsrv database
//$ss_conn = connect_SQLSRV_PVDB();
$ss_conn = connect_SQLSRV_PVDB_test();

// Get list of services sorted by pvaDisplaySequence
$ss_sql = "SELECT DISTINCT orders.serviceID, service.service, service.pvaDisplaySequence, service.ServiceCode
    FROM orders INNER JOIN
    service ON orders.serviceID = service.serviceID
    WHERE (orders.appTypeID = 4) AND (Service.LatestPeriod IS NOT NULL)
    ORDER BY service.pvaDisplaySequence";

$services = sqlsrv_query($ss_conn, $ss_sql); ?>

<option selected disabled>Make a selection...</option>
<?php while ($service = sqlsrv_fetch_array($services)): ?>
    <option value="<?php echo (isset($servtype) && $servtype == 'id') ? $service['serviceID'] : $service['ServiceCode']; ?>"><?php echo $service['service']; ?></option>
<?php endwhile;