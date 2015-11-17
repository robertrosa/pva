    <!-- General page manipulation -->
    <script src="js/pva.js"></script>

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


