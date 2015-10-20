/* Code for the order_setup page & form */
$(document).ready(function() {
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
              $('#sel_rf').html(output);
            }
          });
        }
    });

    $('select#sel_service').select2({
      minimumResultsForSearch: infinity
    });

    $('select#sel_rf').select2({
      placeholder: "Select a reporting field...",
      allowClear: true,
      minimumResultsForSearch: 50
    });
});
