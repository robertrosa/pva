<?php
/*
Routine to populate the weights/measures dropdown
*/

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

// pick up the service id from a get variable
$rfnum = $_GET['rfnum'];

// connect to the oracle database
$odb_conn = connect_odbc_oracle();

// Get volume fields for chosen rfNum from oracle db.
$ora_sql = "select a.nominal_weight as NOM_WEIGHT, b.nominal_weight_desc as NOM_WEIGHT_DESC
        from mt0540 a, mt0240 b
        where a.nominal_weight = b.nominal_weight
        and reporting_field = " . $rfnum;

$results = odbc_exec($odb_conn, $ora_sql);

// echo the results back to the page. js will add them to the right place
echo '<option selected disabled>Make a selection...</option>';
while ($result = odbc_fetch_array($results)) {
    echo '<option value="' . $result['NOM_WEIGHT'] . ' ' . $result['NOM_WEIGHT_DESC'] . '">' . $result['NOM_WEIGHT_DESC'] . '</option>';
}
