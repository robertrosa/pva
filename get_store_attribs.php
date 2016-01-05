<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

$odb_conn = connect_odbc_oracle();

$ora_sql = 'select shop_attribute_code, shop_attribute_desc from st0005';

$results = odbc_exec($odb_conn, $ora_sql);

while ($result = odbc_fetch_array($results)) {
  echo '<option value="' . $result['SHOP_ATTRIBUTE_CODE'] . '">' . $result['SHOP_ATTRIBUTE_CODE'] . ' ' . $result['SHOP_ATTRIBUTE_DESC'] . '</option>';
}