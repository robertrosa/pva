/*
Contains validation routine for order setup form
*/

function ValidateForm() {
  var valid = true;

  console.log("Validating...");

  var service_val = document.getElementById('sel_service').value;
  if (service_val == "Make a selection...") {
    valid = false;
    console.log("No service selected");
  }

  var rf_val = document.getElementById('sel_rf').value;
  if (rf_val == "Select a reporting field..." || rf_val == "") {
    valid = false;
    console.log("No reporting field selected");
  }

  var vol_val = document.getElementById('sel_volume').value;
  if (vol_val == "Make a selection..." || vol_val == "") {
    valid = false;
    console.log("No volume measure selected");
  }

  var divisor_val = document.getElementById('sel_divisor');
  if (divisor_val == "Select an Option" || divisor_val == "") {
    //valid = false;
    console.log("No volume measure selected");
  }

  var attr_val = document.getElementById('sel_attr').value;
  if (attr_val == "Select some options" || attr_val == "") {
    valid = false;
    console.log("No attributes selected");
  }

  return valid;
}