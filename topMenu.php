<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!--<form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>-->
        </div>

        <div id="topMenuTitle"><h2><?php echo $page_title; ?></h2></div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>  <span id="NrTotalEvents" class="label label-primary">0</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> <span id="NrCriticalEventsHeader">0</span> Critical events
                                <!--<span class="pull-right text-muted small">4 minutes ago</span>-->
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="profile.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> <span id="NrWarningEventsHeader">0</span> Warning events
                                <!--<span class="pull-right text-muted small">12 minutes ago</span>-->
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="grid_options.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> <span id="NrInformationEventsHeader">0</span> Information events
                                <!--<span class="pull-right text-muted small">4 minutes ago</span>-->
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="javascript:void(0);">
                                <strong>See All Events</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            <li>
                <a class="right-sidebar-toggle">
                    <i class="fa fa-refresh"></i>
                </a>
            </li>
        </ul>

    </nav>
</div>