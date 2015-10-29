<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PowerView Order Set-Up</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Select2 style -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

    <!-- Chosen style -->
    <link rel="stylesheet" type="text/css" href="css/plugins/chosen/chosen.css">

    <!-- Awesome bootstrap checkboxes -->
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/order_setup.css" rel="stylesheet">

</head>

<?php
// Include the mod_database.php common file and connect to both sql & isec/oracle databases. 
/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
       Modification required here as won't always be connecting to SPAN database in oracle
   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';
$odb_conn = connect_odbc_oracle();
$ss_conn = connect_sqlsrv_pvdb();

?>

<body class="fixed-sidebar"><!-- Adding class="fixed-sidebar" does what you might imagine it would -->
    <!-- This is a test comment by Rob -->
    <div id="wrapper">

<?php
  include_once "leftMenu.html";
?>

        <div id="page-wrapper" class="gray-bg">
        
<?php
  $page_title = "Powerview Order Setup Form";

  include_once "topMenu.php";
?>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <!-- <h2>Powerview New Order Form</h2> -->
                <div class="breadcrumbs">
                  <span style="color: green;" class="">Client&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span style="color: green;" class="">Reporting Field&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span style="color: green;" class="">Volume&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span style="color: green;" class="">Attributes&nbsp;</span><i class="fa fa-long-arrow-right"></i>

                  <span style="color: #DADADA;" class="">Products&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span style="color: orange;" class="">Store&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span style="color: #DADADA;" class="">Time&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span style="color: #DADADA;" class="">Others&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                  <span class="">Delivery&nbsp;</span>
                </div>
            </div><!-- class="col-lg-12" -->
        </div><!-- class="row wrapper border-bottom white-bg page-heading" -->

        <div class="wrapper wrapper-content animated fadeInRight">
            <form method="get" class="form-horizontal">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Main  <!-- <small>Main</small> --></h5>
                                <!-- <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div> -->
                            </div><!-- class="ibox-title" -->
                            <div class="ibox-content">
                            <!-- <form method="get" class="form-horizontal"> -->

<?php
// Get list of services sorted by pvaDisplaySequence
    $ss_sql = "SELECT DISTINCT orders.serviceID, service.service, service.pvaDisplaySequence
        FROM orders INNER JOIN
        service ON orders.serviceID = service.serviceID
        WHERE (orders.appTypeID = 4) AND (Service.LatestPeriod IS NOT NULL)
        ORDER BY service.pvaDisplaySequence";

    $services = sqlsrv_query($ss_conn, $ss_sql);
?>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="sel_service">Select Service</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_service" id="sel_service">
                                            <option selected disabled>Make a selection...</option>
<?php while ($service = sqlsrv_fetch_array($services)): ?>
                                            <option value="<?php echo $service['serviceID']; ?>"><?php echo $service['service']; ?></option>
<?php endwhile; ?>
                                        </select>
                                    </div>

                                    <label class="col-sm-2 col-sm-offset-1 control-label" for="sel_rf">Select Reporting Field</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_rf" id="sel_rf">
                                            <!-- <option></option> -->
                                            <!-- Populated by get_rf_list.php -->
                                        </select>
                                    </div>
                                </div><!-- class="form-group" -->
                                
                                <div class="hr-line-dashed"></div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                                                  VOLUME
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="sel_volume">Volume</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_volume" id="sel_volume">
                                            <option selected disabled>Select a volume measure...</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_divisor" id="sel_divisor">
                                            <option selected disabled>Select a volume divisor...</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Enter volume title">
                                    </div>                                    

                                </div><!-- class="form-group" -->

                                <div class="hr-line-dashed"></div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                                                ATTRIBUTES
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="sel_attr">Select Attributes</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_attr" id="sel_attr">
                                            
                                        </select>
                                    </div>
                                    <div class="text-center col-sm-1">
                                        <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Names</a>
                                    </div>

                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">

                                                    </div>
                                                </div>
                                            </div><!-- class="modal-content" -->
                                        </div><!-- class="modal-dialog" -->
                                    </div><!-- id="modal-form" -->

                                </div><!-- class="form-group" -->

                                

<!-- 
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                              Buttons 
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-->
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="submit">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                                <!-- </form> -->
                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->
<!-- 
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                                              Advanced options 
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
-->
<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ PRODUCTS @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
                        <div class="ibox float-e-margins collapsed">
                            <div class="ibox-title">
                                <h5>Products <small> - Advanced Options</small></h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="sel_split">Product Splitter</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_split" id="sel_split">
                                            <option selected disabled>Select an attribute...</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label" for="sel_filter">Filter From Attributes</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_filter" id="sel_filter">
                                            <option selected disabled>Select an attribute to use as a filter...</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->

<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ STORE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
                        <div class="ibox float-e-margins collapsed">
                            <div class="ibox-title">
                                <h5>Store <small> - Advanced Options</small></h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="sel_store_hier">Store Hierarchies</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_store_hier" id="sel_store_hier">
                                            <option selected disabled>Select store hierarchies...</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label" for="sel_store_attr">Store Attributes</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_store_attr" id="sel_store_attr">
                                            <option selected disabled>Select an attribute to use as a filter...</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->

<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ TIME @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
                        <div class="ibox float-e-margins collapsed">
                            <div class="ibox-title">
                                <h5>Time <small> - Advanced Options</small></h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="sel_db_roll">Database Rollover</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_db_roll" id="sel_db_roll">
                                            <option selected disabled>Select number of weeks...</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="checkbox checkbox-success checkbox-inline">
                                            <input id="chk_every_day" type="checkbox">
                                            <label for="chk_every_day">
                                                Create field containing every day
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success checkbox-inline">
                                            <input id="chk_yr_qtr_mon" type="checkbox" checked>
                                            <label for="chk_yr_qtr_mon">
                                                Create field containing years, quarters &amp; months 
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- class="form-group" -->

                                <div class="hr-line-dashed"></div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                                      Fixed periods
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                <div class="form-group">
                                    <div class="col-sm-6 b-r">
                                        <div class="checkbox checkbox-success">
                                            <input id="chk_inc_fixed" type="checkbox" checked>
                                            <label for="chk_inc_fixed">
                                                Include fixed quarterly periods in 'TIMETNS'
                                            </label>
                                        </div>
                                        <div class="row time">
                                            <label class="col-sm-6 control-label" for="sel_fix_wk_lng_qtr">Weeks in longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_fix_wk_lng_qtr" id="sel_fix_wk_lng_qtr">
                                                    <!-- <option selected disabled>Select number of weeks...</option> -->
                                                    <option>13</option>
                                                    <option selected>16</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row time">
                                            <label class="col-sm-6 control-label" for="sel_fix_end_lng_qtr">End week of longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_fix_end_lng_qtr" id="sel_fix_end_lng_qtr">
                                                    <!-- <option selected disabled>Select end week...</option> -->
<?php for ($i=1; $i<52; $i++): ?>
                                                    <option><?php echo $i; ?></option>
<?php endfor; ?>
                                                    <option selected>52</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-6 control-label" for="sel_fix_name_lng_qtr">Name of longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_fix_name_lng_qtr" id="sel_fix_name_lng_qtr">
                                                    <!-- <option selected disabled>Select name...</option> -->
                                                    <option>Q1</option>
                                                    <option>Q2</option>
                                                    <option>Q3</option>
                                                    <option selected>Q4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                                      Relative periods
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                    <div class="col-sm-6">
                                        <div class="checkbox checkbox-success">
                                            <input id="chk_inc_fixed" type="checkbox" checked>
                                            <label for="chk_inc_fixed">
                                                Include relative quarterly periods in 'TIMEREL'
                                            </label>
                                        </div>
                                        <div class="row time">
                                            <label class="col-sm-6 control-label" for="sel_rel_wk_lng_qtr">Weeks in longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_rel_wk_lng_qtr" id="sel_rel_wk_lng_qtr">
                                                    <option selected>13</option>
                                                    <option>16</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row time">
                                            <label class="col-sm-6 control-label" for="sel_rel_end_lng_qtr">End week of longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_rel_end_lng_qtr" id="sel_rel_end_lng_qtr">
<?php for ($i=0; $i<52; $i++): ?>
                                                    <option><?php echo $i; ?></option>
<?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-6 control-label" for="sel_rel_name_lng_qtr">Name of longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_rel_name_lng_qtr" id="sel_rel_name_lng_qtr">
                                                    <!-- <option selected disabled>Select name...</option> -->
                                                    <option>Q1</option>
                                                    <option>Q2</option>
                                                    <option>Q3</option>
                                                    <option selected>Q4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- class="form-group" -->

                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->

<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ OTHER @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Other <small> - Advanced Options</small></h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="checkbox checkbox-success">
                                            <input id="chk_stan_recl" type="checkbox" checked>
                                            <label for="chk_stan_recl">
                                                Standard Record Length
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2"><input type="text" class="form-control" value="500"></div>
                                    <label class="col-sm-4 control-label">Alternative ISEC Data Source ID</label>
                                    <div class="col-sm-2"><input type="text" class="form-control" value="SPAN"></div>
                                </div><!-- class="form-group" -->

                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="checkbox checkbox-success">
                                            <input id="chk_aka" type="checkbox" checked>
                                            <label for="chk_aka">
                                                Produce AKA files for this order?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="checkbox checkbox-success">
                                            <input id="chk_palm" type="checkbox" checked>
                                            <label for="chk_palm">
                                                Include palm questions?
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label" for="sel_wt_type">Choose weight type</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_wt_type" id="sel_wt_type">
                                            <option selected>Default</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->

                    </div><!-- class="col-lg-12" -->
                </div><!-- class="row" -->
            </form><!-- class="form-horizontal" -->

        </div><!-- class="wrapper wrapper-content animated fadeInRight" -->
        <div class="footer">
            <div>
                <strong>Copyright</strong> Kantar Worldpanel &copy; 2015
            </div>
        </div>

      </div><!-- id="page-wrapper" class="gray-bg" -->
    </div><!-- id="wrapper" -->



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <!-- Chosen -->
    <script type="text/javascript" src="js/plugins/chosen/chosen.jquery.js"></script>

    <!-- Local -->
    <script src="js/order_setup.js" type="text/javascript"></script>

</body>

</html>