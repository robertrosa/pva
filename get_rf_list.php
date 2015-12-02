<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

// pick up the service id from a get variable
$servid = $_GET['servid'];

/*
Get isec connection parameters
*/
// connect to the sqlsrv database
$ss_conn = connect_SQLSRV_PVDB();
// query to return isec logon params
$ss_sql = "SELECT service.serviceID, service.service, service.IsecId, service.ServiceName, pva_isecdetails.IsecDsn, pva_isecdetails.IsecDsnLogin, pva_isecdetails.IsecDsnPassword
            FROM service INNER JOIN
            pva_isecdetails ON service.IsecId = pva_isecdetails.IsecId
            WHERE (service.serviceID = " . $servid . ")";
// execute query, will only return one row due to use of 
$params = sqlsrv_query($ss_conn, $ss_sql);
// unpack results into an array


$odb_conn = connect_odbc_oracle();

$ora_sql = "select reporting_field, title from mt0530 order by title;";

$results = odbc_exec($odb_conn, $ora_sql);
echo '<option selected disabled>Select a reporting field...</option>';
while ($result = odbc_fetch_array($results)) {
  echo '<option value="' . $result['REPORTING_FIELD'] . '">' . $result['REPORTING_FIELD'] . ' ' . $result['TITLE'] . '</option>';
}

?>