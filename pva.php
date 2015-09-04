<?php
    include 'db/conn_database.php';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PowerView Administrator</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Calendar -->
    <link href="css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <style>
    #calendar {
        width: 226px;
        margin: 0 auto;
        font-size: 10px;
    }
    .fc-center h2 {
        font-size: 14px;
        white-space: normal !important;
        font-weight: 600;
    }
    .fc-view-month .fc-event, .fc-view-agendaWeek .fc-event {
        font-size: 0;
        overflow: hidden;
        height: 2px;
    }
    .fc-view-agendaWeek .fc-event-vert {
        font-size: 0;
        overflow: hidden;
        width: 2px !important;
    }
    .fc-agenda-axis {
        width: 20px !important;
        font-size: .7em;
    }

    .fc-button-group {
        padding: 0;
    }
    </style>

</head>
<body>
    <div id="overlay" style="opacity:1;background:#FFF;width:100%;height:100%;z-index:2147483647;top:0;left:0;position:fixed;">
        <img src="img/loading.gif" style="position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);" alt="Loading" />     
    </div>
    <div id="wrapper">

        <?php
            include_once "leftMenu.html";
        ?>

        <div id="page-wrapper" class="gray-bg">
        
        <?php
            include_once "topMenu.html";
        ?>

        <div class="wrapper wrapper-content">
        <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <!-- label-info for Admin active / label-danger for Admin inactive -->
                                <span id="adminStatus" class="label label-info pull-right">Admin</span>
                                <h5>Servers status</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><span id="NrServersActive" style="color:#92D400;">0</span>/<span id="NrServersOnStandby" style="color:#FF4655;">0</span>/<span id="NrServersInactive">0</span></h1>
                                <div class="stat-percent font-bold text-success"><a href="javascript:void(0)" onClick="servers.php" class="kwp" id="plusServersInfo"><i class="fa fa-plus-square-o"></i></a></div>
                                <small><span style="color:#92D400;">Active</span> / <span style="color:#FF4655;">On Standby</span> / Inactive</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right"><!--Annual--></span>
                                <h5>Events</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><span id="NrCriticalEvents" style="color:#FF4655;">0</span>/<span id="NrWarningEvents" style="color:#FFBE00;">0</span>/<span id="NrInformationEvents" style="color:#92D400;">0</span></h1>
                                <div class="stat-percent font-bold text-info"><!--20% <i class="fa fa-level-up"></i>--></div>
                                <small><span style="color:#FF4655;">Critical</span> / <span style="color:#FFBE00;">Warning</span> / <span style="color:#92D400;">Info</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span id="databasesServiceName" class="label label-primary pull-right">Worldpanel</span>
                                <h5>Databases</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><span style="color:#92D400;" id="NrDatabasesCompleted">0</span>/<span id="NrDatabasesWaiting">0</span></h1>
                                <div class="stat-percent font-bold text-navy"><span id="percentDatabasesCompleted">0</span>% <i id="databasesIcon" class="fa fa-level-up"></i></div>
                                <small><span style="color:#92D400;">Competed</span> / Waiting</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span id="reworksServiceName" class="label label-primary pull-right">Worldpanel</span>
                                <h5>Reworks</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><span style="color:#92D400;" id="NrReworksCompleted">0</span>/<span id="NrReworksWaiting">0</span></h1>
                                <div class="stat-percent font-bold text-navy"><span id="percentReworksCompleted">0</span>% <i id="reworksIcon" class="fa fa-level-up"></i></div>
                                <small><span style="color:#92D400;">Competed</span> / Waiting</small>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Database Smmary</h5>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" id="Worldpanel" class="btn btn-xs btn-white active">Worldpanel</button>
                                        <button type="button" id="Food On The Go" class="btn btn-xs btn-white">Food On The Go</button>
                                        <button type="button" id="Worldpanel Ireland" class="btn btn-xs btn-white">Worldpanel Ireland</button>
                                        <button type="button" id="Combined Panel" class="btn btn-xs btn-white">Combined Panel</button>
                                        <button type="button" id="Petrol Panel" class="btn btn-xs btn-white">Petrol Panel</button>
                                        <button type="button" id="Foods Online" class="btn btn-xs btn-white">Foods Online</button>
                                        <button type="button" id="Pulse" class="btn btn-xs btn-white">Pulse</button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                <div class="col-lg-9">
                                    <!--<div class="flot-chart">
                                        <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                    </div>-->
                                    <div id="lineChartDiv">
                                        <canvas id="lineChart" height="61" width="219" style="width:219px;height:51px;">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <ul class="stat-list">
                                        <li>
                                            <h2 class="no-margins"><span id="chartNrDatabasesCompleted">0</span> / <span id="chartNrDatabasesWaiting">0</span></h2>
                                            <small>Total databases</small>
                                            <div class="stat-percent"><span id="chartPercentDatabasesCompleted">0</span>% <i id="chartDatabasesIcon" class="fa text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div id="chartBarPercentDatabasesCompleted" style="width: 0%;" class="progress-bar"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins "><span id="chartNrDeliverablesCompleted">0</span> / <span id="chartNrDeliverablesWaiting">0</span></h2>
                                            <small>Deliverable databases</small>
                                            <div class="stat-percent"><span id="chartPercentDeliverablesCompleted">0</span>% <i id="chartDeliverablesIcon" class="fa text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div id="chartBarPercentDeliverablesCompleted" style="width: 0%;" class="progress-bar"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins "><span id="chartNrCMACompleted">0</span> / <span id="chartNrCMAWaiting">0</span></h2>
                                            <small>CMA Clearances</small>
                                            <div class="stat-percent"><span id="chartPercentCMACompleted">0</span>% <i id="chartCMAIcon" class="fa text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div id="chartBarPercentCMACompleted" style="width: 0%;" class="progress-bar"></div>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                            <div class="ibox float-e-margins">                              
                            <div class="ibox-content">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>                    

                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>In production</h5>
                            </div>                            
                            <div class="ibox-content">
                                <table class="table" id="DatabasesBeingProduced">
                                    <thead>
                                    <tr>
                                        <th>DB Name</th>
                                        <th>Server</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>   
                    </div>                 

                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>In queue</h5>
                            </div>                            
                            <div class="ibox-content">
                                <table class="table" id="DatabasesInQueue">
                                    <thead>
                                    <tr>
                                        <th>DB Name</th>
                                        <th>Prio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>   
                    </div>                                        


                </div>
                </div>            

    </div>

    <!-- Mainly scripts -->
    <script src="js/plugins/fullcalendar/moment.min.js"></script>
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <!-- Full Calendar -->
    <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>    

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>    

    <!-- General page manipulation -->
    <script src="js/pva.js"></script>

</body>
</html>
