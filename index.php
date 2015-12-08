<?php
    include 'db/conn_database.php';
?>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PowerView Administrator</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet"> 

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

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet"> 


</head>

<body>
    <!-- This is a test comment by Rob -->
    <div id="wrapper">

        <?php
            include_once "leftMenu.html";
        ?>

        <div id="page-wrapper" class="gray-bg">
        
        <?php
            include_once "topMenu.html";
        ?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-3">

                    <div class="ibox" style="background-color:red">
                        <div class="ibox-title">                            
                            <h3>Servers Status</h3>
                        </div>                        
                        <div class="ibox-content">
                            <div> 
                                <div class="">Admin Server: <span class="font-bold">LIVE</span></div>       
                                <div class="">Last 24h Active Servers:</span></div> 
                                <div align="center"><span id="sparkline"></span></div>                         
                                <div>&nbsp;</div>                         
                                <div class="">NextPvJobSub: <span class="font-bold">17:48</span></div>    
                                <div class="">NextPvDemon: <span class="font-bold">17:20</span></div>  
                                <div class="">NextPvDownload: <span class="font-bold">17:34</span></div>         
                            </div>                              
                        </div>                         
                    </div>   

                    <div class="ibox">
                        <div class="ibox-title">   
                            <span class="label label-info pull-right" id="CombinedPanelPeriod"></span>
                            <h3><a href="javascript:void(0);" class="getService" name="Combined Panel">Combined Panel</a></h3>
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-CombinedPanel"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="CombinedPanelTotalDatabases">0</div>
                                    <div id="CombinedPanelTotalDeliverables">0</div>
                                    <div id="CombinedPanelTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="CombinedPanelWaitingDatabases">0</div>
                                    <div id="CombinedPanelWaitingDeliverables">0</div>
                                    <div id="CombinedPanelWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="CombinedPanelQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="CombinedPanelQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>                      

                </div>
                <div class="col-lg-3">

                                        <div class="ibox">
                        <div class="ibox-title">   
                            <span class="label label-info pull-right" id="WorldpanelPeriod"></span>                         
                            <h3><a href="javascript:void(0);" class="getService" name="Worldpanel">Worldpanel</a></h3>
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-Worldpanel"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="WorldpanelTotalDatabases">0</div>
                                    <div id="WorldpanelTotalDeliverables">0</div>
                                    <div id="WorldpanelTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="WorldpanelWaitingDatabases">0</div>
                                    <div id="WorldpanelWaitingDeliverables">0</div>
                                    <div id="WorldpanelWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="WorldpanelQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="WorldpanelQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">    
                            <span class="label label-info pull-right" id="PetrolPanelPeriod"></span>       
                            <h3><a href="javascript:void(0);" class="getService" name="Petrol Panel">Petrol Panel</a></h3>                 
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-PetrolPanel"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="PetrolPanelTotalDatabases">0</div>
                                    <div id="PetrolPanelTotalDeliverables">0</div>
                                    <div id="PetrolPanelTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="PetrolPanelWaitingDatabases">0</div>
                                    <div id="PetrolPanelWaitingDeliverables">0</div>
                                    <div id="PetrolPanelWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="PetrolPanelQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="PetrolPanelQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>                    

                </div>
                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-title">  
                            <span class="label label-info pull-right" id="FoodOnTheGoPeriod"></span>                          
                            <h3><a href="javascript:void(0);" class="getService" name="Food On The Go">Food On The Go</a></h3>
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-FoodOnTheGo"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="FoodOnTheGoTotalDatabases">0</div>
                                    <div id="FoodOnTheGoTotalDeliverables">0</div>
                                    <div id="FoodOnTheGoTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="FoodOnTheGoWaitingDatabases">0</div>
                                    <div id="FoodOnTheGoWaitingDeliverables">0</div>
                                    <div id="FoodOnTheGoWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="FoodOnTheGoQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="FoodOnTheGoQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">      
                            <span class="label label-info pull-right" id="FoodsOnlinePeriod"></span>  
                            <h3><a href="javascript:void(0);" class="getService" name="Foods Online">Foods Online</a></h3>                    
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-FoodsOnline"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="FoodsOnlineTotalDatabases">0</div>
                                    <div id="FoodsOnlineTotalDeliverables">0</div>
                                    <div id="FoodsOnlineTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="FoodsOnlineWaitingDatabases">0</div>
                                    <div id="FoodsOnlineWaitingDeliverables">0</div>
                                    <div id="FoodsOnlineWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="FoodsOnlineQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="FoodsOnlineQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>                    


                </div>
                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-title">        
                            <span class="label label-info pull-right" id="WorldpanelIrelandPeriod"></span>  
                            <h3><a href="javascript:void(0);" class="getService" name="Worldpanel Ireland">Worldpanel Ireland</a></h3>                  
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-WorldpanelIreland"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="WorldpanelIrelandTotalDatabases">0</div>
                                    <div id="WorldpanelIrelandTotalDeliverables">0</div>
                                    <div id="WorldpanelIrelandTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="WorldpanelIrelandWaitingDatabases">0</div>
                                    <div id="WorldpanelIrelandWaitingDeliverables">0</div>
                                    <div id="WorldpanelIrelandWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="WorldpanelIrelandQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="WorldpanelIrelandQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">       
                            <span class="label label-info pull-right" id="PulsePeriod"></span>     
                            <h3><a href="javascript:void(0);" class="getService" name="Pulse">Pulse</a></h3>               
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-Pulse"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverables</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div id="PulseTotalDatabases">0</div>
                                    <div id="PulseTotalDeliverables">0</div>
                                    <div id="PulseTotalCMA">0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div id="PulseWaitingDatabases">0</div>
                                    <div id="PulseWaitingDeliverables">0</div>
                                    <div id="PulseWaitingCMA">0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent" id="PulseQueueStatusNr">0%</div></div>                                
                                <div class="progress progress-mini">
                                    <div id="PulseQueueStatus" style="width: 0%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>

                </div>              
            </div>


        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> Kantar Worldpanel &copy; 2015
            </div>
        </div>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script type="text/javascript" src="js/plugins/circles-master/circles.js"></script>    

    <!-- JS Page Level -->           
    <script type="text/javascript" src="js/plugins/circles-master/circles-master.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>  

    <!-- Calendar -->
    <script src="js/plugins/fullcalendar/moment.min.js"></script>  
    <!-- Full Calendar -->
    <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script> 

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>         

    <!-- General page manipulation -->
    <script src="js/index.js"></script>    

    <script type="text/javascript">
        jQuery(document).ready(function() {
            CirclesMaster.initCirclesMaster1();
            $("#sparkline").sparkline([5, 6, 7, 2, 0, 4, 2, 4, 5, 7, 2, 4, 12, 14, 4, 2, 14, 12, 7, 9, 10, 11, 14, 15], {
            type: 'bar',
            barWidth: 8,
            height: '124px',
            barColor: '#92D400',
            negBarColor: '#92D400'});
            });

    </script>    

</body>

</html>
