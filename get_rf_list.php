<?php

include 'functions.php';

// pick up the service id from a get variable
$serviceid = $_GET['servid'];

// Get isec connection parameters and connect to the isec system
$odb_conn = ConnectToISEC($serviceid);
// isec query
$ora_sql = "select reporting_field, title from mt0530 order by title;";
// return results and echo as options for a select
$results = odbc_exec($odb_conn, $ora_sql);
echo '<option selected disabled>Select a reporting field...</option>';
while ($result = odbc_fetch_array($results)) {
  echo '<option value="' . $result['REPORTING_FIELD'] . '">' . $result['REPORTING_FIELD'] . ' ' . $result['TITLE'] . '</option>';
}

?>