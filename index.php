<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PowerView Administrator</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                            <span class="label label-info pull-right">201507</span>
                            <h3><a href="javascript:void(0);" class="getService" name="Combined Panel">Combined Panel</a></h3>
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-4"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>3</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>0</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">100%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>                      

                </div>
                <div class="col-lg-3">

                                        <div class="ibox">
                        <div class="ibox-title">   
                            <span class="label label-info pull-right">201508</span>                         
                            <h3><a href="javascript:void(0);" class="getService" name="Worldpanel">Worldpanel</a></h3>
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-1"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>933</div>
                                    <div>227</div>
                                    <div>284</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>48</div>
                                    <div>4</div>
                                    <div>42</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">6%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 6%;" class="progress-bar progress-bar-red"></div>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">    
                            <span class="label label-info pull-right">201508</span>       
                            <h3><a href="javascript:void(0);" class="getService" name="Petrol Panel">Petrol Panel</a></h3>                 
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-5"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>1</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>0</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">100%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>                    

                </div>
                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-title">  
                            <span class="label label-info pull-right">201508</span>                          
                            <h3><a href="javascript:void(0);" class="getService" name="Food On The Go">Food On The Go</a></h3>
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-2"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>22</div>
                                    <div>4</div>
                                    <div>3</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>2</div>
                                    <div>1</div>
                                    <div>1</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">50%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 50%;" class="progress-bar progress-bar-orange"></div>
                                </div>
                            </div>   
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">      
                            <span class="label label-info pull-right">201507</span>  
                            <h3><a href="javascript:void(0);" class="getService" name="Foods Online">Foods Online</a></h3>                    
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-6"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>230</div>
                                    <div>0</div>
                                    <div>75</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>5</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">3%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 3%;" class="progress-bar progress-bar-red"></div>
                                </div>
                            </div>   
                        </div>
                    </div>                    


                </div>
                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-title">        
                            <span class="label label-info pull-right">201508</span>  
                            <h3><a href="javascript:void(0);" class="getService" name="Worldpanel Ireland">Worldpanel Ireland</a></h3>                  
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-3"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>168</div>
                                    <div>0</div>
                                    <div>58</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>15</div>
                                    <div>0</div>
                                    <div>11</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">85%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 85%;" class="progress-bar"></div>
                                </div>
                            </div>   
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">       
                            <span class="label label-info pull-right">201509</span>     
                            <h3><a href="javascript:void(0);" class="getService" name="Pulse">Pulse</a></h3>               
                        </div>                        
                        <div class="ibox-content">
                            <div class="circle" id="circle-7"></div>

                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">&nbsp;</div>
                                    <div class="font-bold">Total</div>                                    
                                    <div class="font-bold">Deliverable</div>
                                    <div class="font-bold">CMA</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Completed</div>
                                    <div>8</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Waiting</div>
                                    <div>0</div>
                                    <div>0</div>
                                    <div>0</div>
                                </div>
                            </div>  

                            <div>&nbsp;</div>

                            <div>
                                <div class="font-bold">Queue Status<div class="stat-percent">100%</div></div>                                
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar"></div>
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
