<?php

/*
TASK: Get all the data from the form into the dbo.pv_order_main table within the Powerview database
*/



echo '<pre>';
var_dump($_POST);
echo '</pre>';

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


