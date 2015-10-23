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

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/order_setup.css" rel="stylesheet">

</head>

<?php

include '\\\kwlwgd704376\wpserver$\web\common\mod_database.php';
$odb_conn = connect_odbc_oracle();
$ss_conn = connect_sqlsrv_pvdb();

?>

<body>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>PV Order Setup<!--  <small>With custom checkbox and radion elements. --></small></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul> -->
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">

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
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_service" id="sel_service">
                                            <option selected disabled>Select a service...</option>
<?php while ($service = sqlsrv_fetch_array($services)): ?>
                                            <option value="<?php echo $service['serviceID']; ?>"><?php echo $service['service']; ?></option>
<?php endwhile; ?>
                                        </select>
                                    </div>
                                <!-- </div><div class="form-group"> -->
                                    <label class="col-sm-2 control-label" for="sel_rf">Select Reporting Field</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="sel_rf" id="sel_rf">
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="submit">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div><!-- class="row" -->


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

    <!-- Local -->
    <script src="js/order_setup.js" type="text/javascript"></script>

</body>

</html>