<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

$odb_conn = connect_odbc_oracle();

$ora_sql = "select thingy_code, thingy_desc from RT0040 where thingy_type='I' and key_type=2 order by insert_date desc";

$results = odbc_exec($odb_conn, $ora_sql);

while ($result = odbc_fetch_array($results)) {
  echo '<option value="' . $result['THINGY_CODE'] . ' ' . $result['THINGY_DESC'] . '">' . $result['THINGY_CODE'] . ' ' . $result['THINGY_DESC'] . '</option>';
}