$(document).ready(function() {   
    function updateDatatable() {
        $('.queueDataTable').DataTable( {        
            "ajax": {
                "url": "db/queries.php",
                "dataSrc": "",
                "type": "POST",
                "data": {"action": 'getDatabasesInQueueTotal'},                    
            },
            "columns": [
                { "data": "PvaProdId"},
                { "data": "service" },
                { "data": "OrderNumber" },                    
                { "data": "NumPeriods" },
                { "data": "PvaJobStatus" },
                { "data": "Priority" }

            ],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false
                },            
                {
              "targets": 6,
              "sDefaultContent": '<input type="checkbox" class="checkbox">'
            } ]
        } );             
    }

    updateDatatable();

    var oTable = $('.queueDataTable').dataTable();

	$(document).on('change', '.checkbox', function(){		
	    var tr = $(this).closest('tr');    
	    var index = oTable.fnGetPosition(tr[0]);
	    var value = oTable.fnGetData(index)["PvaProdId"];

		var queue = [];
	    if (sessionStorage.getItem("queue") != null) {
	   		queue = JSON.parse(sessionStorage.getItem("queue"));
	   	}

	    if (!$(this).is(':checked')){
			var index = queue.indexOf(value);
			if (index >= 0) {
			  queue.splice(index, 1);
			}	    	
	    } else {
		    queue.push(value);		    
	    }
	    sessionStorage.setItem("queue", JSON.stringify(queue));
    });
    
    $("#action").on('change', function(){
        if ($( "#action option:selected" ).attr("value") == 1) {
            //alert("Test: " + sessionStorage.getItem("queue"));  
            event.preventDefault();
            $('#cd-popup-change').addClass('is-visible');            
        } else if ($( "#action option:selected" ).attr("value") == 2) {
            event.preventDefault();
            $('#cd-popup-hold').addClass('is-visible');
        }
        $("select#action").prop('selectedIndex', 0);        
    });  

    //Code to reset left-menu
    UpdateMenuDisplay();
    //Code to highlight the right left-menu option    
    $('#summary').click();
    $('#btnQueue').parent().parent().parent().attr('class', 'active');
    $('#btnQueue').parent().attr('class', 'active');
  

    //Answer "Yes" to the question "Are you sure you want to change the priority of the selected orders?"    
    $('#cd-popup-yes').on('click', function(event){
        //alert("yes");
        $('.cd-popup').removeClass('is-visible');
        $('#cd-popup-pri').addClass('is-visible');
    });

    //Answer "Yes" to the question "Are you sure you want to put on hold the selected orders?"    
    $('#cd-popup-hold-yes').on('click', function(event){
        $.ajax({ url: 'db/queries.php',
             data: {action: 'putOnHold', ids: JSON.parse(sessionStorage.getItem("queue"))},
             type: 'post',
             success: function(output) {
                        $('.cd-popup').removeClass('is-visible');
                        $('#cd-popup-hold-ok').addClass('is-visible');
                        sessionStorage.removeItem("queue");                   
                        oTable.remove(); 
                        $data =  "<table class='table table-striped table-bordered table-hover queueDataTable' width='100%'><thead><tr><th>Id</th><th>Service</th><th>Order</th><th>Nr of periods</th><th>Job status</th><th>Priority</th><th>Action</th></tr></thead></table>";                        
                        $(".table-responsive").children().remove();
                        $(".table-responsive").html($data);                        
                        updateDatatable();
                      }
        });                       
    });    

    //Select "Ok" at the window "Please, select the new priority for the selected orders"
    $('#cd-popup-pri-yes').on('click', function(event){        
        $.ajax({ url: 'db/queries.php',
             data: {action: 'updatePriority', priority: $( "#newPriority option:selected" ).attr("value"), ids: JSON.parse(sessionStorage.getItem("queue"))},
             type: 'post',
             success: function(output) {
                        $('.cd-popup').removeClass('is-visible');
                        $('#cd-popup-ok').addClass('is-visible');
                        sessionStorage.removeItem("queue");                   
                        oTable.remove(); 
                        $data =  "<table class='table table-striped table-bordered table-hover queueDataTable' width='100%'><thead><tr><th>Id</th><th>Service</th><th>Order</th><th>Nr of periods</th><th>Job status</th><th>Priority</th><th>Action</th></tr></thead></table>";                        
                        $(".table-responsive").children().remove();
                        $(".table-responsive").html($data);                        
                        updateDatatable();
                      }
        });        
        
    });     

    //Answer "No" to the question "Are you sure you want to change the priority of the selected orders?"    
    $('#cd-popup-ok').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });

    //Answer "No" to the question "Are you sure you want to change the priority of the selected orders?"    
    $('#cd-popup-no').on('click', function(event){
        //alert("no");
        $('.cd-popup').removeClass('is-visible');
    });

    //Answer "No" to the question "Are you sure you want to put on hold the selected orders?"    
    $('#cd-popup-hold-no').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });    

    //Answer "Ok" to the comment "Orders successfully put on hold"    
    $('#cd-popup-ok-hold').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });       

    //Select "Cancel" at the window "Please, select the new priority for the selected orders"    
    $('#cd-popup-pri-no').on('click', function(event){
        $('.cd-popup').removeClass('is-visible'); 
    });      

    //close popup
    $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
            $('.cd-popup').removeClass('is-visible');            
        }
    });  

});

window.onbeforeunload = function() {
  sessionStorage.removeItem("queue");
};