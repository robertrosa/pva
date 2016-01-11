<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';
// connect to the oracle database
$odb_conn = connect_odbc_oracle();
// simple query, get shop attribute code and description
$ora_sql = 'select shop_attribute_code, shop_attribute_desc from st0005';
// return results and build the list of options
$results = odbc_exec($odb_conn, $ora_sql);
// Build the options. Include both code & description in value as well as html content
while ($result = odbc_fetch_array($results)) {
  echo '<option value="' . $result['SHOP_ATTRIBUTE_CODE'] . ' ' . $result['SHOP_ATTRIBUTE_DESC'] . '">' . $result['SHOP_ATTRIBUTE_CODE'] . ' ' . $result['SHOP_ATTRIBUTE_DESC'] . '</option>';
}