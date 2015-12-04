/* Code for the order_setup page & form */
$(document).ready(function() {
  // Update the reporting field list determined by service
    $('#sel_service').change(function(e) {
        var service_val = $(this).val();

        if (service_val == '' || service_val == "Select Service") {
          console.log("Nothing selected");
        } else {
          console.log(service_val);

          $.ajax({
            method: "GET",
            url: "get_rf_list.php?servid=" + service_val,
            success: function (output) {
              $('#sel_rf').html(output).trigger("chosen:updated");
            }
          });
        }
    });
  // Update the attribute list determined by reporting field
    $('#sel_rf').change(function(e) {
        var rf_val = $(this).val();

        if (rf_val == '' || rf_val == "Select a reporting field...") {
          console.log("Nothing selected");
        } else {
          console.log(rf_val);

          $.ajax({
            method: "GET",
            url: "get_wt_list.php?rfnum=" + rf_val,
            success: function (output) {
              $('#sel_volume').html(output).trigger("chosen:updated");
            }
          });

          $.ajax({
            method: "GET",
            url: "get_attr_list.php?rfnum=" + rf_val,
            success: function (output) {
              $('#sel_attr').html(output).trigger("chosen:updated");
            }
          });          
        }
    });
  // update the measure title with the value chosen in the dropdown to begin with
    $('#sel_volume').change(function(e) {
      var vol_name = $(this).val();   //.split(" ").join(" ")
      if (vol_name == '' || vol_name == 'Make a selection...') {
        console.log("Nothing selected");
      } else {
        console.log(vol_name.split(" "));
        $('#txt_vol_title').val(vol_name);
      }
    });

  /*********************************************************
  ++++++++++++++++++++++++ Chosen +++++++++++++++++++++++++
  *********************************************************/
  // Initialisation
    $('select#sel_service').chosen({
      disable_search_threshold: 20
    });

    $('select#sel_rf').chosen({
      disable_search_threshold: 20,
      placeholder_text_single: 'Select a reporting field...'
    });

    $('select#sel_volume').chosen({disable_search_threshold: 10});

    $('select#sel_divisor').chosen({disable_search_threshold: 10});

    $('select#sel_attr').chosen({
      disable_search_threshold: 20,
      max_selected_options: 25,
      placeholder_text_multiple: 'Select some options'
    });

  // Update the text colours in the breadcrumbs
    $('select#sel_service').chosen().change(function(e){
      $('#bc-serv').attr("class", "bc-comp")
    });

    $('select#sel_rf').chosen().change(function(e){
      $('#bc-rf').attr("class", "bc-comp")
    });

    $('select#sel_volume').chosen().change(function(e){
      $('#bc-vol').attr("class", "bc-comp")
    });

  // Prompt user to choose an 8 character name if necessary (ie if not default value in SQL database)
  // Adjust displayed value in chosen select div
    var attr_count = 0;   // declare outisde function to make global
    $("#sel_attr").chosen().change(function(e){
      prev_attr_count = attr_count;
      attr_count = $('#sel_attr_chosen .chosen-choices li').length - 1;
      if (attr_count === prev_attr_count) {
        attr_count -= 1;
      }
    // Change the colour of the breadcrumb text if any attributes have been selected. Change back if removed.
      if (attr_count > 0) {
        $('#bc-attr').attr("class", "bc-comp");
      } else {
        $('#bc-attr').attr("class", "bc-req");
      }
    // Output for testing purposes
      alert("You have made " + attr_count + " selection(s). There were previously " + prev_attr_count + " selections.");
    });

  /*********************************************************
  ++++++++++++++++++++++++ Select2 +++++++++++++++++++++++++
  *********************************************************/
    /*$('select#sel_service').select2({
      minimumResultsForSearch: 50
    });*/

    /*$('select#sel_rf').select2({
      placeholder: "Select a reporting field...",
      allowClear: true,
      minimumResultsForSearch: 50
    });*/

    /*$('select#sel_attr').select2({
      minimumResultsForSearch: 50
    });*/
});
