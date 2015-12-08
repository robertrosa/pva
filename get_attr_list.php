<?php

// include db connections file
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

// pick up the service id from a get variable
$rfnum = $_GET['rfnum'];

$odb_conn = connect_odbc_oracle();

// Get a list of attributes including type, description & csa flag
$ora_sql = "select distinct a.attribute_type as att_type, b.attribute_type_desc as att_type_desc, b.csa_flag  as csa_flag from mt1360 a, mt0340 b
        where a.reporting_field = " . $rfnum . "
        and a.attribute_type = b.attribute_type
        union
        select distinct a.csa_type as att_type, b.attribute_type_desc as att_type_desc, b.csa_flag as csa_flag from mt1060 a, mt0340 b
        where a.reporting_field = " . $rfnum . "
        and a.csa_type = b.attribute_type
        Union
        select distinct a.attribute_type as att_type, b.attribute_type_desc as att_type_desc, b.csa_flag as csa_flag from mt1340 a, mt0340 b
        where a.global_field = " . $rfnum . "
        and a.attribute_type = b.attribute_type
        order by 1";

$results = odbc_exec($odb_conn, $ora_sql);

//echo 'Testing<br />';
//echo '<ul>';
while ($result = odbc_fetch_array($results)) {
  echo '<option value="' . $result['ATT_TYPE'] . '">' . $result['ATT_TYPE'] . ' ' . $result['ATT_TYPE_DESC'] . '</option>';
}
//echo '</ul>';

?>