<?php

/*
TASK: Get all the data from the form into the dbo.pv_order_main table within the Powerview database.
Will need lots of logical tests on $_POST values 
*/

echo '<pre>';
var_dump($_POST);
echo '</pre>';

/*
$_POST variables:
  - array(20) {
  ["sel_service"]=>
  string(1) "7"
  ["sel_rf"]=>
  string(4) "1591"
  ["sel_volume"]=>
  string(16) "POUND     (MEAT)"
  ["txt_vol_title"]=>
  string(16) "POUND     (MEAT)"
  ["sel_attr"]=>
  array(3) {
    [0]=>
    string(1) "1"
    [1]=>
    string(1) "2"
    [2]=>
    string(3) "265"
  }
  ["sel_db_roll"]=>
  string(3) "260"
  ["chk_yr_qtr_mon"]=>
  string(2) "on"
  ["chk_inc_fixed"]=>
  string(2) "on"
  ["sel_fix_wk_lng_qtr"]=>
  string(2) "16"
  ["sel_fix_end_lng_qtr"]=>
  string(2) "52"
  ["sel_fix_name_lng_qtr"]=>
  string(2) "Q4"
  ["sel_rel_wk_lng_qtr"]=>
  string(2) "13"
  ["sel_rel_end_lng_qtr"]=>
  string(1) "0"
  ["sel_rel_name_lng_qtr"]=>
  string(2) "Q4"
  ["chk_stan_recl"]=>
  string(2) "on"
  ["txt_std_rec_length"]=>
  string(3) "500"
  ["txt_alt_isec_src_id"]=>
  string(4) "SPAN"
  ["chk_aka"]=>
  string(2) "on"
  ["chk_palm"]=>
  string(2) "on"
  ["sel_wt_type"]=>
  string(7) "Default"
}
}
*/






die();

include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';
//$odb_conn = connect_odbc_oracle();
//$ss_conn = connect_sqlsrv_pvdb();
$ss_conn = connect_sqlsrv_pvdb_test();



$query_text = 'INSERT INTO dbo.pv_order_main (OrderNumber, RealService, ServiceCode, RFNum, OrderDescription, BaseGlobalField, LastUserID, LastUpdate, Vol1, Vol2, OldFormat, ProductSplitter, 
            VolumeTitle, VolumeFactor, DBRollWeeks, Daily, Calendar, FixedQuarters, FQLongestWeeks, FQEndWeek, FQName, RelativeQuarters, RQLongestWeeks, 
            RQRelEndWeek, RQName, DBGrows, DBRolls, NumShopAttribs, NumHierarchies, NumShopHiers, ProdFiles, Filter, NumFilters, NumAttribs, DBStartWeek, DBStatus, 
            CMA_Flag, PalmQuestions, Promo, BabyBoost, SameLength, StdLength, AKAfiles, DataFormat, Formula1, ServiceFolder, DataService, WeightType, LastImported, 
            Nutrition, Vol1Full, Service, PacksOverride, CurrencyType, NewFormatExtracts, BrandList) 
            SELECT ' . $_POST['userid'] . ', "' . preg_replace("/(\d+)\.(\d+)\.(\d+)/", "$3-$2-$1", $_POST['date']) . '", (SELECT UpdateTypeId FROM tuUpdateType WHERE UpdateType ="' . 
              preg_replace($patterns, $replacements, $key) . '"), "' . trim($value) . '", CURRENT_TIMESTAMP;';

$cols_in_pv_order_main = "OrderNumber, RealService, ServiceCode, RFNum, OrderDescription, BaseGlobalField, LastUserID, LastUpdate, Vol1, Vol2, OldFormat, ProductSplitter, 
            VolumeTitle, VolumeFactor, DBRollWeeks, Daily, Calendar, FixedQuarters, FQLongestWeeks, FQEndWeek, FQName, RelativeQuarters, RQLongestWeeks, 
            RQRelEndWeek, RQName, DBGrows, DBRolls, NumShopAttribs, NumHierarchies, NumShopHiers, ProdFiles, Filter, NumFilters, NumAttribs, DBStartWeek, DBStatus, 
            CMA_Flag, PalmQuestions, Promo, BabyBoost, SameLength, StdLength, AKAfiles, DataFormat, Formula1, ServiceFolder, DataService, WeightType, LastImported, 
            Nutrition, Vol1Full, Service, PacksOverride, CurrencyType, NewFormatExtracts, BrandList";


