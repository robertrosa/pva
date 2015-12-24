/* &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
          Code for the order_setup page & form 
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& */

$(document).ready(function() {
  // Update the reporting field list determined by service
    $('#sel_service').on('change', function(e) {
        var service_val = $(this).val();

        if (service_val == '' || service_val == "Select Service") {
          console.log("Nothing selected");
        } else {
          console.log(service_val);

        // populate the reporting field select list
          $.ajax({
            method: "GET",
            url: "get_rf_list.php?servid=" + service_val,
            success: function (output) {
              $('#sel_rf').html(output).trigger("chosen:updated");
            }
          });
        
        // populate the store list select
          $.ajax({
            method: "GET",
            url: "get_store_lists.php",
            success: function (output) {
              $('#sel_store_hier').html(output);  //.trigger("chosen:updated");
            }
          });

        // populate the store attribute select
          $.ajax({
            method: "GET",
            url: "get_store_attribs.php",
            success: function (output) {
              $('#sel_store_attr').html(output).trigger("chosen:updated");
            }
          });
        }
    });


  // Update the attribute list determined by reporting field
    $('#sel_rf').on('change', function(e) {
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
            // populate the attribute select and trigger the update method on the chosen object
              $('#sel_attr').html(output).trigger("chosen:updated");
            // also populate the product splitter and filter selects but hide all the options. May wish to add the disabled option after adding the hidden-option class
              $('#sel_split').html('<option selected disabled>Select a reporting field...</option>' + output).children().attr('class', 'hidden-option');
              $('#sel_filter').html('<option selected disabled>Select a reporting field...</option>' + output).children().attr('class', 'hidden-option');
            }
          });          
        }
    });


  // update the measure title with the value chosen in the dropdown. User can edit.
    $('#sel_volume').chosen().on('change', function(e) {
      var vol_name = $(this).val();   //.split(" ").join(" ")
      if (vol_name == '' || vol_name == 'Make a selection...') {
        console.log("Nothing selected");
      } else {
      // splice out any extra spaces
        var vol_arr = vol_name.split(" ");
        for (var i=vol_arr.length - 1; i>=0; i--) {
          if (vol_arr[i] == "") {
            vol_arr.splice(i, 1);
          }
        }
      // splice out the weight code at the start
        vol_arr.splice(0, 1);
      // recreate the string minus the extra whitespace
        vol_name = vol_arr.join(" ");
      // add it to the measure title input box
        $('#txt_vol_title').val(vol_name);
      }
    });

  
  // if the menu item is not already active, trigger a click event on the menu when loading the page from a link
    if ($('#edit_create').parent().attr('class') != 'active') {
      $('#edit_create').click();
    }
  // set the list item that's the parent of the anchor to active if it isn't already
    if ($('#newPVsetup').parent().attr('class') != 'active') {
      $('#newPVsetup').parent().attr('class', 'active');
    }


  /*********************************************************
  ++++++++++++++++++++++++ Chosen +++++++++++++++++++++++++
  *********************************************************/
  
  /* @@@@@@@@@@@@@@@@@ Initialisation @@@@@@@@@@@@@@@@ */

  // MAIN
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

  // STORE
    $('select#sel_store_hier').chosen({
      disable_search_threshold: 20,
      max_selected_options: 10,
      width: '95%',
      placeholder_text_multiple: 'Select some options...'
    });

    $('select#sel_store_attr').chosen({
      disable_search_threshold: 20,
      width: '95%',
      placeholder_text_multiple: 'Select one or more options...'
    });

  // NEED TO TRAP WAHTEVER EVENT IS TRIGGERED WHEN UNCOLLAPSING IBOX CONTROL AND TRIGGER CHOSEN UPDATE
    $('#ibox-content').on('show', function(){
      $('select#sel_store_hier').chosen();
      $('select#sel_store_attr').chosen();
    });

  
  // Update the breadcrumb classes
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
    var attr_count = 0;   // declared outside function to make global
    
    $("#sel_attr").chosen().on('change', function(e){
    // whenever the select attribute select is changed, repopulate the product splitter select
      console.log($(this).val());
      prev_attr_count = attr_count;
      attr_count = $('#sel_attr_chosen .chosen-choices li').length - 1;
      if (attr_count === prev_attr_count) {
        attr_count -= 1;
      }

    // each time an attribute is selected or deselected, add or remove it from the product splitter and filter selects
      for (var i=0; i<$('#sel_split option').length; i++) {
        if ($.inArray($('#sel_split').children(':eq(' + i + ')').val(), $(this).val()) > -1) {
          $('#sel_split').children(':eq(' + i + ')').removeClass('hidden-option');
          $('#sel_filter').children(':eq(' + i + ')').removeClass('hidden-option');
        } else {
          if (!$('#sel_split').children(':eq(' + i + ')').hasClass('hidden-option')) {
            $('#sel_split').children(':eq(' + i + ')').attr('class', 'hidden-option');
            $('#sel_filter').children(':eq(' + i + ')').attr('class', 'hidden-option');
          }
        }
      }


    // Change the colour of the breadcrumb text if any attributes have been selected. Change back if removed.
      if (attr_count > 0) {
        $('#bc-attr').attr("class", "bc-comp");
      } else {
        $('#bc-attr').attr("class", "bc-req");
      }
    // Output for testing purposes
      //alert("You have made " + attr_count + " selection(s). There were previously " + prev_attr_count + " selections.");
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
