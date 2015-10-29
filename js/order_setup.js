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

        if (rf_val == '' || rf_val == "Select Reporting Field") {
          console.log("Nothing selected");
        } else {
          console.log(rf_val);

          $.ajax({
            method: "GET",
            url: "get_attr_list.php?rfid=" + rf_val,
            success: function (output) {
              $('#sel_attr').html(output);
            }
          });
        }
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

  /*********************************************************
  ++++++++++++++++++++++++ Chosen +++++++++++++++++++++++++
  *********************************************************/
    $('select#sel_service').chosen({
      disable_search_threshold: 50
    });

    $('select#sel_rf').chosen({
      disable_search_threshold: 50
    });

    $('select#sel_volume').chosen({disable_search_threshold: 10});

    $('select#sel_divisor').chosen({disable_search_threshold: 10});

    $('select#sel_attr').chosen({
      disable_search_threshold: 50
    });

});
