

    <script src="js/inspinia.js"></script>

    <!-- Local -->
    <script src="js/order_setup.js" type="text/javascript"></script>
    <script src="js/order_validation.js" type="text/javascript"></script>

            <form method="post" class="form-horizontal" action="order_submit.php" onsubmit="return ValidateForm()">
                <div class="row">
                    <div class="col-lg-12">

<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ MAIN @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h3>Main  <!-- <small>Main</small> --></h3>
                            </div><!-- class="ibox-title" -->
                            <div class="ibox-content">
                            <!-- <form method="get" class="form-horizontal"> -->

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="sel_service">Select Service</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_service" id="sel_service">
<?php
$servtype = 'id';
include 'get_service_list.php';
$servtype = '';
?>
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
                                    <div class="col-sm-6 b-r">
                                        <h4>Volume</h4>
                                        <div class="row stack">
                                            <label class="col-sm-4 control-label" for="sel_volume">Select Measure</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="sel_volume" id="sel_volume">
                                                    <!-- <option selected disabled></option> -->
                                                    <!-- populated by get -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row stack">
                                            <label class="col-sm-4 control-label" for="txt_divisor">Set Measure Divisor</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Enter volume divisor" id="txt_divisor" name="txt_divisor">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-sm-4 control-label" for="txt_vol_title">Enter Measure Title</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Enter volume title" id="txt_vol_title" name="txt_vol_title">
                                            </div>
                                        </div>                                    
                                    </div><!-- class="col-sm-6 b-r" -->

                                <!-- </div> --><!-- class="form-group" -->

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                                                ATTRIBUTES
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                <!-- <div class="form-group"> -->
                                    <div class="col-sm-6">
                                        <h4>Attributes <small> - select up to 25</small></h4>
                                        <div class="row stack">
                                            <!-- <label class="col-sm-4 control-label" for="sel_attr">Select up to 25</label> -->
                                            <div class="col-sm-12">
                                                <select class="form-control" name="sel_attr[]" id="sel_attr" multiple>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="text-center col-sm-1">
                                            <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Names</a>
                                        </div> -->

                                        <!-- <div id="modal-form" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">

                                                        </div>
                                                    </div> -->
                                                <!-- </div> --><!-- class="modal-content" -->
                                            <!-- </div> --><!-- class="modal-dialog" -->
                                        <!-- </div> --><!-- id="modal-form" -->
                                    </div><!-- class="col-sm-6" -->

                                </div><!-- class="form-group" -->

<!-- 
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                              Buttons 
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-->
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <button class="btn btn-white" type="reset">Cancel</button>
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
                        <div class="ibox float-e-margins collapsed" id="ibox-store">
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

                                    <div class="col-sm-6">
                                        <div class="row stack">
                                            <label class="col-sm-4" for="sel_store_hier">Store Hierarchies</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="sel_store_hier[]" id="sel_store_hier" multiple>
                                                    <!-- <option selected disabled>Select store hierarchies...</option> -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        
                                        <div class="row stack">
                                            <label class="col-sm-4" for="sel_store_attr">Store Attributes</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="sel_store_attr[]" id="sel_store_attr" multiple>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row stack">
                                        <label class="col-sm-2 control-label" for="sel_store_hier">Store Hierarchies</label>
                                        <label class="col-sm-2 col-sm-offset-4 control-label" for="sel_store_attr">Store Attributes</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select class="form-control" name="sel_store_hier[]" id="sel_store_hier" multiple>
                                                <option selected disabled>Select store hierarchies...</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="sel_store_attr[]" id="sel_store_attr" multiple>
                                                
                                            </select>
                                        </div>
                                    </div> --><!-- class="row" -->

                                </div><!-- class="form-group" -->
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
                                            <!-- <option selected disabled>Select number of weeks...</option> -->
                                            <option>104</option>
                                            <option>156</option>
                                            <option selected>260</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="checkbox checkbox-success checkbox-inline">
                                            <input id="chk_every_day" type="checkbox" name="chk_every_day">
                                            <label for="chk_every_day">
                                                Create field containing every day
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-success checkbox-inline">
                                            <input id="chk_yr_qtr_mon" type="checkbox" name="chk_yr_qtr_mon" checked>
                                            <label for="chk_yr_qtr_mon">
                                                Create field containing years, quarters &amp; months 
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- class="form-group" -->

                                <div class="hr-line-dashed"></div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++ Fixed periods +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                
                                <div class="form-group">
                                    <div class="col-sm-6 b-r">
                                        <div class="checkbox checkbox-success">
                                            <input name="chk_inc_fixed" id="chk_inc_fixed" type="checkbox" checked>
                                            <label for="chk_inc_fixed">
                                                Include fixed quarterly periods in 'TIMETNS'
                                            </label>
                                        </div>
                                        <div class="row stack">
                                            <label class="col-sm-6 control-label" for="sel_fix_wk_lng_qtr">Weeks in longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_fix_wk_lng_qtr" id="sel_fix_wk_lng_qtr">
                                                    <!-- <option selected disabled>Select number of weeks...</option> -->
                                                    <option>13</option>
                                                    <option selected>16</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row stack">
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
                                        </div><!-- class="row" -->
                                    </div><!-- class="col-sm-6 b-r" -->

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++ Relative periods ++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                    
                                    <div class="col-sm-6">
                                        <div class="checkbox checkbox-success">
                                            <input name="chk_inc_rel" id="chk_inc_rel" type="checkbox" checked>
                                            <label for="chk_inc_rel">
                                                Include relative quarterly periods in 'TIMEREL'
                                            </label>
                                        </div>
                                        <div class="row stack">
                                            <label class="col-sm-6 control-label" for="sel_rel_wk_lng_qtr">Weeks in longest quarter</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sel_rel_wk_lng_qtr" id="sel_rel_wk_lng_qtr">
                                                    <option selected>13</option>
                                                    <option>16</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row stack">
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
                                    </div><!-- class="col-sm-6" -->
                                </div><!-- class="form-group" -->

                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->

<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ OTHER @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
                        <div class="ibox float-e-margins collapsed">
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
                                            <input name="chk_stan_recl" id="chk_stan_recl" type="checkbox" checked>
                                            <label for="chk_stan_recl">
                                                Standard Record Length
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2"><input type="text" class="form-control" name="txt_std_rec_length" value="500"></div>
                                    <label class="col-sm-4 control-label">Alternative ISEC Data Source ID</label>
                                    <div class="col-sm-2"><input type="text" class="form-control" name="txt_alt_isec_src_id" value="SPAN"></div>
                                </div><!-- class="form-group" -->

                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="checkbox checkbox-success">
                                            <input name="chk_aka" id="chk_aka" type="checkbox" checked>
                                            <label for="chk_aka">
                                                Produce AKA files for this order?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="checkbox checkbox-success">
                                            <input name="chk_palm" id="chk_palm" type="checkbox" checked>
                                            <label for="chk_palm">
                                                Include palm questions?
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label" for="sel_wt_type">Choose weight type</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="sel_wt_type" id="sel_wt_type">
                                            <option disabled selected>Leave blank for default</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- class="ibox-content" -->
                        </div><!-- class="ibox float-e-margins" -->

                    </div><!-- class="col-lg-12" -->
                </div><!-- class="row" -->
            </form><!-- class="form-horizontal" -->

            <div id="edit-select-modal" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit existing</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form role="form">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label for="sel-edit-service">Select Service</label>
                                            <select class="form-control" name="sel-edit-service" id="sel-edit-service">
                                                <!-- <option></option> -->

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label for="sel-edit-order-num">Select order number</label>
                                            <select class="form-control" name="sel-edit-order-num" id="sel-edit-order-num">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Retrieve</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- id="edit-select-modal" class="modal fade" -->

