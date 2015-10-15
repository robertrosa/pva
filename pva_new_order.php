<?php
    include 'db/conn_database.php';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PowerView New Order</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    
    <!--chosen select plugin-->
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">


    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">


    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <style>
    #padme { padding: 50px 50px;   }

    </style>

</head>
<body>
<!--     <div id="overlay" style="opacity:1;background:#FFF;width:100%;height:100%;z-index:2147483647;top:0;left:0;position:fixed;">
        <img src="img/loading.gif" style="position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);" alt="Loading" />     
    </div> -->
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    <h2>Powerview New Order Form</h2>
                    <p>
                    <span style="color: green;" class="">Client&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span style="color: green;" class="">Reporting Field&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span style="color: green;" class="">Volume&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span style="color: green;" class="">Attributes&nbsp;</span><i class="fa fa-long-arrow-right"></i>

                    <span style="color: #DADADA;" class="">Products&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span style="color: orange;" class="">Store&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span style="color: #DADADA;" class="">Time&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span style="color: #DADADA;" class="">Others&nbsp;</span><i class="fa fa-long-arrow-right"></i>
                    <span class="">Delivery&nbsp;</span>

                    </p>

                </div>

            </div>


    <div id="wrapper">



        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
        <div class="col-lg-12">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                        <h5>Details<small>&nbsp;&nbsp;</small><i style="color:green;" class="fa fa-check"></i></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div> <!-- ibox-tools -->
                </div> <!-- ibox-title -->
                 <div class="ibox-content">


                    <div class="form-group">
                        <label class="font-noraml">Select Client</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">2 sisters</option>
                            <option value="United Kingdom">ABP</option>
                            <option value="Afghanistan">Adams Food</option>
                            <option value="Aland Islands">Debenhams</option>
                            <option value="Albania">Devro PLC</option>
                            <option value="Algeria">Dr Oetekar</option>
                            <option value="American Samoa">Premier Foods</option>
                            <option value="Andorra">Propak</option>
                            <option value="Angola">Nestle</option>
                            <option value="Anguilla">Aldi</option>
                            <option value="Antarctica">Waitrose</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->

                    <div class="form-group">
                        <label class="font-noraml">Select Reporting Field</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">1- shampoo</option>
                            <option value="United Kingdom">2 - washing up liquids</option>
                            <option value="Afghanistan">3 - total cream</option>
                            <option value="Aland Islands">4 - herbs n spices</option>
                            <option value="Albania">5 - Total Biscuit</option>
                            <option value="Algeria">6 - mushrooms</option>
                            <option value="American Samoa">7 - other random crap</option>
                            <option value="Andorra">222 - chilled products</option>
                            <option value="Angola">333 - more rubish</option>
                            <option value="Anguilla">345 - oatcakes</option>
                            <option value="Antarctica">321 - cereals</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->

                    <div class="form-group">
                        <label class="font-noraml">Select Volume</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">option1</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->


                <div class="form-group">
                    <label class="font-noraml">Select Attributes</label>
                    <div class="input-group">
                        <select data-placeholder="Choose a Attributes to include..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                            <option value="">Select</option>
                            <option value="United States">Manufacturer</option>
                            <option value="United Kingdom">Brand</option>
                            <option value="Afghanistan">Size</option>
                            <option value="Aland Islands">Type</option>
                            <option value="Albania">Packaging</option>
                            <option value="Algeria">Country of Origin</option>
                            <option value="American Samoa">Variety</option>
                            <option value="Andorra">Banana Size</option>
                            <option value="Angola">Fairtrade</option>
                            <option value="Anguilla">Potato Variety</option>
                        </select>
                    </div>
                </div>

                <div id="padme"></div>




                </div> <!-- ibox-content end -->
            </div> <!-- ibox float-e-margins -->

          <div> <h5 style="color:grey;"> Advanced Options  </h5>
          </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Products<small></small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div> <!-- ibox-tools -->
                </div> <!-- ibox-title -->
                 <div class="ibox-content">


                    <div class="form-group">
                        <label class="font-noraml">Select Client</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->

                                  
                <div class="form-group">
                    <label class="font-noraml">Select Attributes</label>
                    <div class="input-group">
                        <select data-placeholder="Choose a Attributes to include..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                        </select>
                    </div>
                </div>

                <div id="padme"></div>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox float-e-margins -->

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Store<small>&nbsp;&nbsp;</small><i style="color:orange;"class="fa fa-exclamation"></i></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div> <!-- ibox-tools -->
                </div> <!-- ibox-title -->
                 <div class="ibox-content">


                    <div class="form-group">
                        <label class="font-noraml">Select Client</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->

                                  
                <div class="form-group">
                    <label class="font-noraml">Select Attributes</label>
                    <div class="input-group">
                        <select data-placeholder="Choose a Attributes to include..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                        </select>
                    </div>

                </div>

                <div id="padme"></div>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox float-e-margins -->
        </div> <!--col-12-->
    <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Time<small></small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div> <!-- ibox-tools -->
                </div> <!-- ibox-title -->
                 <div class="ibox-content">


                    <div class="form-group">
                        <label class="font-noraml">Select Client</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->

                                  
                <div class="form-group">
                    <label class="font-noraml">Select Attributes</label>
                    <div class="input-group">
                        <select data-placeholder="Choose a Attributes to include..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                        </select>
                    </div>
                </div>

                <div id="padme"></div>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox float-e-margins -->
    </div> <!--col 6 -->
    <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Others<small></small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div> <!-- ibox-tools -->
                </div> <!-- ibox-title -->
                 <div class="ibox-content">


                    <div class="form-group">
                        <label class="font-noraml">Select Client</label>
                        <div class="input-group">
                        <select data-placeholder="Select Client..." class="chosen-select" style="width:350px;" tabindex="2">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                        </select>
                        </div>
                    </div> <!-- form group end -->

                                  
                <div class="form-group">
                    <label class="font-noraml">Select Attributes</label>
                    <div class="input-group">
                        <select data-placeholder="Choose a Attributes to include..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                            <option value="">Select</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                        </select>
                    </div>
                </div>
    </div><!--col 6-->
                <div id="padme"></div>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox float-e-margins -->
                                      

        </div> <!-- row -->
        </div> <!-- wrapper-content      -->   

    </div>

    <!-- Mainly scripts -->
    <script src="js/plugins/fullcalendar/moment.min.js"></script>
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

      <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <!-- General page manipulation -->
    <script src="js/pva.js"></script>

 <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>

</body>
</html>
