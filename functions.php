<?php

include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';

function ConnectToISEC($serviceid) {
// Returns the connection string    
    $ss_conn = connect_SQLSRV_PVDB_test();

    $ss_sql = "SELECT pva_isecdetails.IsecDsn, pva_isecdetails.IsecDsnLogin, pva_isecdetails.IsecDsnPassword
                FROM pva_isecdetails INNER JOIN
                service ON pva_isecdetails.IsecId = service.IsecId
                WHERE service.serviceID = " . $serviceid;

    $result = sqlsrv_query($ss_conn, $ss_sql);
    
    $iseclogindetails = sqlsrv_fetch_array($result);

    return connect_odbc_oracle($iseclogindetails['IsecDsnLogin'], $iseclogindetails['IsecDsnPassword'], $iseclogindetails['IsecDsn']);
}

?>