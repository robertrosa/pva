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

//die();

echo '<br/>';
echo '<br/>';

include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';
//$odb_conn = connect_odbc_oracle();
//$ss_conn = connect_sqlsrv_pvdb();
$ss_conn = connect_sqlsrv_pvdb_test();

/*
First we need an entry into powerview.orders which will generate the id required for the pv_order_main table
*/
// Order is the same order number as will be used in the main insert query for pv_order_main
$ordernumber = 'test';

// appTypeID is always 4 (PowerView)
$apptypeid = 4;

// CMA - will the database contain CMA(s), true or false?
$cma = 0;

//serviceID is the service id returned from the form
$serviceid = $_POST['sel_service'];

// syndicateOK & dExecute are no longer used, both can be set to false
$syndicateok = 0;
$dexecute = 0;

// build the query
$ss_query_text = "INSERT INTO orders ([order], appTypeID, CMA, serviceID, syndicateOK, dExecute) 
                  VALUES ('" . $ordernumber . "', " . $apptypeid . ", " . $cma . ", " . $serviceid . ", " . $syndicateok . ", " . $dexecute . ")";

sqlsrv_query($ss_conn, $ss_query_text);       // prepare and execute the query

// get the id created by the last entry
$ss_query_text = "SELECT SCOPE_IDENTITY()";

$rv = sqlsrv_query($ss_conn, $ss_query_text);
$arr_id = sqlsrv_fetch_array($rv);
$orderid = intval($arr_id[0]);

/*
Begin populating the INSERT statement variables, not necessarily how we'll finish this off but will do for now
*/
// reset $ss_query_text, just to be on the safe side
$ss_query_text = '';

// OrderId doesn't automatically increment and is in fact created in the powerview.orders entry above
//$orderid = 6031;

// OrderNumber - needs to be generated and stored in/on the form. Created above as required for powerview.orders entry
//$ordernumber = 'test';

// Get the service name and code
$ss_query_service = 'SELECT service, ServiceName, ServiceCode FROM service WHERE (serviceID = ' . $_POST['sel_service'] . ')';
// execute query and return results to the following two variables
$service_details = sqlsrv_query($ss_conn, $ss_query_service);
$service_detail = sqlsrv_fetch_array($service_details);

$realservice = $service_detail['ServiceName'];
$servicecode = $service_detail['ServiceCode'];
$service = $service_detail['service'];

// RFNum - this should have been validated by javascript so shouldn't need to be tested for a value but still good practice
$rfnum = $_POST['sel_rf'];

// OrderDescription - use hidden form field to record this or look up in database?
$orderdescription = 'TEST DESCRIPTION';

// BaseGlobalField - Base field or Global field, get from ISEC
$baseglobalfield = 'G';

// LastUserID - where from?
$lastuserid = 'DANIELJE';

// LastUpdate - presumably the current time & date
$lastupdate = 'CURRENT_TIMESTAMP';

// Vol1 returned from $_POST butneeds splitting into name and number.
// Vol2 not required so can be left out of insert query or entered as 'NULL'
$arr_vol = explode(' ', $_POST['sel_volume']);
$vol1 = intval($arr_vol[0]);
$vol2 = 'NULL';

// OldFormat has only 17 examples where the value is not 0, all 1998 or earlier
$oldformat = 0;

// ProductSplitter - not yet completed in order_setup.php
if (isset($_POST['sel_split'])) {
  $productsplitter = $_POST['sel_split'];
} else {
  $productsplitter = 'NULL';
}

// VolumeTitle - return $_POST variable? If not will have to look up title from code
$volumetitle = $_POST['txt_vol_title'];

// VolumeFactor - return $_POST variable but will need to be validated
if (isset($_POST['txt_divisor'])) {
  $volumefactor = $_POST['txt_divisor'];
} else {
  $volumefactor = 'NULL';
}

// DBRollWeeks - populated from $_POST variable
$dbrollweeks = $_POST['sel_db_roll'];

// Daily - can be 0 or 1, use $_POST variable to determine which
if (isset($_POST['chk_every_day']) && $_POST['chk_every_day'] == 'on') {
  $daily = 1;
} else {
  $daily = 0;
}

// Calendar - can also be 0 or 1, determine with $_POST['chk_yr_qtr_mon']
if (isset($_POST['chk_yr_qtr_mon']) && $_POST['chk_yr_qtr_mon'] == 'on') {
  $calendar = 1;
} else {
  $calendar = 0;
}

// FixedQuarters - can also be 0 or 1, determine with $_POST['chk_inc_fixed']
if (isset($_POST['chk_inc_fixed']) && $_POST['chk_inc_fixed'] == 'on') {
  $fixedquarters = 1;
} else {
  $fixedquarters = 0;
}

// FQLongestWeeks - populate from $_POST - has never been anything other than 16
$fqlongestweeks = $_POST['sel_fix_wk_lng_qtr'];

// FQEndWeek - populate from $_POST. Has never been anythign other than 52
$fqendweek = $_POST['sel_fix_end_lng_qtr'];

// FQName - populate from $_POST. Has never been anything other than 'Q4'
$fqname = $_POST['sel_fix_name_lng_qtr'];

// RelativeQuarters - populate from $_POST, can be 0 or 1
if (isset($_POST['chk_inc_rel']) && $_POST['chk_inc_rel'] == 'on') {
  $relativequarters = 1;
} else {
  $relativequarters = 0;
}

// RQLongestWeeks - populate from $_POST, can be either 13 or 16
$rqlongestweeks = $_POST['sel_rel_wk_lng_qtr'];

// RQRelEndWeek - populate from $_POST, has only ever been 0 or 13
$rqrelendweek = $_POST['sel_rel_end_lng_qtr'];

// RQName - populate from $_POST, has only ever been 'Q4'
$rqname = $_POST['sel_rel_name_lng_qtr'];

// DBGrows - not currently covering this but looks as though it should be included. Always opposite to DBRolls
$dbgrows = 0;

// DBRolls - effectively permanently set to 1 at the moment because DBGrows option not included and they must always be opposite values (0 & 1)  
$dbrolls = 1;

// NumShopAttribs - count number of selected shop attributes, not yet completed in form
$numshopattribs = 0;

// NumHierarchies - would be a count of selected hierarchies but not actually included on form currently so fixed to zero
$numhierarchies = 0;

// NumShopHiers - will be a count of selected shop hierarchies from $_POST variable but not yet completed on form
$numshophiers = 0;

// ProdFiles - always 'NULL' or 0 in database, not included in form, either set value to 0 or 'NULL'
$prodfiles = 0;

// Filter - not yet completed on form but will be value(s) chosen by user on form
if (isset($_POST['sel_filter'])) {
  $filter = $_POST['sel_filter'];
} else {
  $filter = 'NULL';
}

// NumFilters - not yet completed on form, count of filter items chosen by user
$numfilters = 0;

// NumAttribs - count of attributes in $_POST variable selected by user
$numattribs = count($_POST['sel_attr']);

// DBStartWeek - has never been anything other than 'NULL'
$dbstartweek = 'NULL';

// DBStatus - has never been anything other than 'NULL'
$dbstatus = 'NULL';

// CMA_Flag - always either 0 or 1, may need to be looked up from table. Set to 0 for now
$cma_flag = 0;

// PalmQuestions - populate depending on $_POST variable presence & value, can be 0 or 1
if (isset($_POST['chk_palm']) && $_POST['chk_palm'] = 'on') {
  $palmquestions = 1;
} else {
  $palmquestions = 0;
}

// Promo - not currently recorded on form, may need to be looked up in table. Can only be 0 or 1 so presumably determines whether or not to include promo itemisations
$promo = 1;

// BabyBoost - never anything other than 'NULL'
$babyboost = 'NULL';

// SameLength - always either 0 or 1, if value entered for standard rec length this is 1 otherwise 0
// StdLength - has always been either 0, 500, 10000 but determined by the value entered in std rec length. If nothing set to 0
if (isset($_POST['txt_std_rec_length'])) {
  $samelength = 1;
  $stdlength = $_POST['txt_std_rec_length'];
} else {
  $samelength = 0;
  $stdlength = 0;
}

// AKAfiles - are AKA files included? Determined by whether or not relevant $_POST variable is set
if (isset($_POST['chk_aka']) && $_POST['chk_aka']) {
  $akafiles = 1;
} else {
  $akafiles = 0;
}

// DataFormat - almost always PowerView, otherwise has only ever been blank or NULL
$dataformat = "Powerview";

// Formula1 - linked to alternative isec data source id (service folder), if that's blank value = 0, otherwise 1
// ServiceFolder - usually seems to be the same as RealService but not always
if (isset($_POST['txt_alt_isec_src_id'])) {
  $formula1 = 1;
  $servicefolder = "'" . $_POST['txt_alt_isec_src_id'] . "'";
} else {
  $formula1 = 0;
  $servicefolder = "";
}

// DataService - need to check what value this should be. Most often it's a lowercased version of ServiceFolder but usually has a value when ServiceFolder doesn't
$dataservice = strtolower($servicefolder);

// WeightType - most often 'NULL' but has also been '03 Dog' (once), '05 Individual' (103 times), '07 Baby' (7 times) & '01 Household' (162 times). If left blank set as 'NULL'
if (!isset($_POST['sel_wt_type']) || $_POST['sel_wt_type'] == "Leave blank for default") {
  $weighttype = 'NULL';
} else {
  $weighttype = $_POST['sel_wt_type'];
}

// LastImported - written by another process. Either leave out of query or fill with 'NULL' to begin with
$lastimported = 'NULL';

// Nutrition - mostly 'NULL' in database but has also been 2, 3, 61 & 62
$nutrition = 'NULL';

// Vol1Full - full name & code of Vol1 field
$vol1full = $_POST['sel_volume'];

// Service - full name of service, returned from 'service' table in SQL database using ServiceID & populated above
//$service = '';

// PacksOverride - almost always 'NULL', otherwise 1, not sure what determines this
$packsoverride = 'NULL';

// CurrencyType - has only ever been 'NULL' in SQL database
$currencytype = 'NULL';

// NewFormatExtracts - has only ever been 'NULL' in SQL database
$newformatextracts = 'NULL';

// BrandList - Always 'NULL' except 'Entertainment' once and 'Allenter' once
$brandlist = 'NULL';



$ss_query_text = "INSERT INTO dbo.pv_order_main (OrderId, OrderNumber, RealService, ServiceCode, RFNum, OrderDescription, BaseGlobalField, LastUserID, LastUpdate, Vol1, Vol2, OldFormat, ProductSplitter, 
            VolumeTitle, VolumeFactor, DBRollWeeks, Daily, Calendar, FixedQuarters, FQLongestWeeks, FQEndWeek, FQName, RelativeQuarters, RQLongestWeeks, 
            RQRelEndWeek, RQName, DBGrows, DBRolls, NumShopAttribs, NumHierarchies, NumShopHiers, ProdFiles, Filter, NumFilters, NumAttribs, DBStartWeek, DBStatus, 
            CMA_Flag, PalmQuestions, Promo, BabyBoost, SameLength, StdLength, AKAfiles, DataFormat, Formula1, ServiceFolder, DataService, WeightType, LastImported, 
            Nutrition, Vol1Full, Service, PacksOverride, CurrencyType, NewFormatExtracts, BrandList) 
            VALUES (" . $orderid . ", '" . $ordernumber . "', '" . $realservice . "', " . $servicecode . ", " . $rfnum . ", '" . $orderdescription . "', '" . $baseglobalfield . "', '" . $lastuserid . "', 
            CURRENT_TIMESTAMP, " . $vol1 . ", " . $vol2 . ", " . $oldformat . ", " . $productsplitter . ", '" . $volumetitle . "', '" . $volumefactor . "', " . $dbrollweeks . ", " . $daily . ", " . 
            $calendar . ", " . $fixedquarters . ", " . $fqlongestweeks . ", " . $fqendweek . ", '" . $fqname . "', " . $relativequarters . ", " . $rqlongestweeks . ", " . $rqrelendweek . ", '" . $rqname . 
            "', " . $dbgrows . ", " . $dbrolls . ", " . $numshopattribs . ", " . $numhierarchies . ", " . $numshophiers . ", " . $prodfiles . ", " . $filter . ", " . $numfilters . ", ". $numattribs . ", " . 
            $dbstartweek . ", " . $dbstatus . ", " . $cma_flag . ", " . $palmquestions . ", " . $promo . ", " . $babyboost . ", " . $samelength . ", " . $stdlength . ", " . $akafiles . ", '" . 
            $dataformat . "', " . $formula1 . ", " . $servicefolder . ", " . $dataservice . ", " . $weighttype . ", " . $lastimported . ", " . $nutrition . ", '" . $vol1full . "', '" . $service . "', " .
            $packsoverride . ", " . $currencytype . ", " . $newformatextracts . ", " . $brandlist . ");";

echo '<pre>';
var_dump($ss_query_text);
echo '</pre>';

try {
  $rv = sqlsrv_query($ss_conn, $ss_query_text);
  if (($errors = sqlsrv_errors()) != null) {
    foreach( $errors as $error ) {
      echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
      echo "code: ".$error[ 'code']."<br />";
      echo "message: ".$error[ 'message']."<br />";
    }
  } else {
    echo '<br/><br/>';
    echo 'Successs?';
  }

} catch(Exception $e) {
  echo 'ERROR: ' . $e->getMessage();
  die();
}

echo '<br/><br/>';
echo 'Successs!';


// close the database connection
sqlsrv_close($ss_conn);



/*$cols_in_pv_order_main = "OrderNumber, RealService, ServiceCode, RFNum, OrderDescription, BaseGlobalField, LastUserID, LastUpdate, Vol1, Vol2, OldFormat, ProductSplitter, 
            VolumeTitle, VolumeFactor, DBRollWeeks, Daily, Calendar, FixedQuarters, FQLongestWeeks, FQEndWeek, FQName, RelativeQuarters, RQLongestWeeks, 
            RQRelEndWeek, RQName, DBGrows, DBRolls, NumShopAttribs, NumHierarchies, NumShopHiers, ProdFiles, Filter, NumFilters, NumAttribs, DBStartWeek, DBStatus, 
            CMA_Flag, PalmQuestions, Promo, BabyBoost, SameLength, StdLength, AKAfiles, DataFormat, Formula1, ServiceFolder, DataService, WeightType, LastImported, 
            Nutrition, Vol1Full, Service, PacksOverride, CurrencyType, NewFormatExtracts, BrandList";*/

// Other queries will be required for the following tables:
//        - pv_order_shopattribs
//        - pv_order_shophiers
//        - 

