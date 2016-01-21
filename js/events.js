$(document).ready(function() {   

    var oTable = "";

    function updateDatatable(action, severity) {

        $('.eventsDataTable').DataTable( {        
            "ajax": {
                "url": "db/queries.php",
                "dataSrc": "",
                "type": "POST",
                "data": {"action": action, "severity": severity},                    
            },
            "columns": [
                { "data": "pvaEventId"},
                { "data": "pvaProdId" },
                { "data": "OrderId" },                    
                { "data": "DateStamp.date" },
                { "data": "SeverityID" },
                { "data": "Severity" },
                { "data": "Summary"  },
                { "data": "Detail" },
                { "data": "Status" },
                { "data": "CallingProgram" },
                { "data": "ClearedBy" },
                { "data": "ClearedWhen" },
                { "data": "ServerId" },
                { "data": "ServerName" }
            ],
            "columnDefs": [
                {
                    "targets": [ 0, 1, 4, 8, 9, 10, 11, 12 ],
                    "visible": false
                },            
                {
              "targets": 14,
              "sDefaultContent": '<input type="checkbox" class="checkbox">'
            }],
            "rowCallback": function( row, data, index) {
                if (data["Severity"].trim() == "Critical") {                    
                    $('td:eq(2)', row).css('color', '#FF504B');
                } else if (data["Severity"].trim() == "Warning") {
                    $('td:eq(2)', row).css('color', '#FF8200');
                } else if (data["Severity"].trim() == "Information") {
                    $('td:eq(2)', row).css('color', '#92D400');
                }                
            }

        } );    

        oTable = $('.eventsDataTable').dataTable();
     
        $('.eventsDataTable').on( 'draw.dt', function () {            
            if(sessionStorage.getItem("events") !== null){
                $.each( JSON.parse(sessionStorage.getItem("events")), function( key, value ) {                
                    $('.eventsDataTable tbody tr').each(function () {                       
                            var tr = $(this);                                
                            var index = oTable.fnGetPosition(tr[0]);
                            var value1 = oTable.fnGetData(index)["pvaEventId"];
                            if (value == value1){
                                //tr.toggleClass('DTTT_selected');                                  
                                $(tr).find("input[type=checkbox]").attr("checked", true);
                            }                                                        
                    });
                });                    
            } 
        } );

    }

  
    if (sessionStorage.getItem("severity") === null){
        updateDatatable('getTotalEvents', '');    
    } else {
        updateDatatable('getEvents', sessionStorage.getItem("severity"));
        $("select#severity").prop('value', sessionStorage.getItem("severity"));
        sessionStorage.removeItem("severity");
    }

    //Code to reset left-menu
    UpdateMenuDisplay();
    //Code to highlight the right left-menu option    
    $('#summary').click();
    $('#btnEvents').parent().parent().parent().attr('class', 'active');
    $('#btnEvents').parent().attr('class', 'active');

    $(document).on('change', '.checkbox', function(){       
        var tr = $(this).closest('tr');    
        var index = oTable.fnGetPosition(tr[0]);
        var value = oTable.fnGetData(index)["pvaEventId"];

        var events = [];
        if (sessionStorage.getItem("events") != null) {
            events = JSON.parse(sessionStorage.getItem("events"));
        }

        if (!$(this).is(':checked')){
            var index = events.indexOf(value);
            if (index >= 0) {
              events.splice(index, 1);
            }       
        } else {
            events.push(value);          
        }
        sessionStorage.setItem("events", JSON.stringify(events));
    });

    /*$(document).on('click', '.eventsDataTable tbody tr', function(){
        var tr = $(this);    
        tr.toggleClass('DTTT_selected');        
        var index = oTable.fnGetPosition(tr[0]);
        var value = oTable.fnGetData(index)["pvaEventId"];

        var events = [];
        if (sessionStorage.getItem("events") != null) {
            events = JSON.parse(sessionStorage.getItem("events"));
        }                

        if (!$(this).hasClass("DTTT_selected")){
            var index = events.indexOf(value);
            if (index >= 0) {
              events.splice(index, 1);
            }           
        } else {
            events.push(value);         
        }
        sessionStorage.setItem("events", JSON.stringify(events));
        //console.log(sessionStorage.getItem("events"));        
    });*/
    
    $("#action").on('change', function(){
        if ($( "#action option:selected" ).attr("value") == 1) { 
            event.preventDefault();
            $('#cd-popup-change').addClass('is-visible');            
        } else if ($( "#action option:selected" ).attr("value") == 2) {
            event.preventDefault();
            $('#cd-popup-clear-all').addClass('is-visible');   
        } else if ($( "#action option:selected" ).attr("value") == 3) {
            event.preventDefault();
            $('#cd-popup-select-all').addClass('is-visible');                                 
        } else if ($( "#action option:selected" ).attr("value") == 4) {
            event.preventDefault();
            $('#cd-popup-unselect-all').addClass('is-visible');
        }
        $("select#action").prop('selectedIndex', 0);        
    });  

    $("#severity").on('change', function(){
        //oTable.ClearTable();
        //oTable.Draw();
        oTable.remove();        
        $data =  "<table class='table table-striped table-bordered table-hover eventsDataTable' width='100%'><thead><tr><th>Event Id</th><th>Production Id</th><th>Order Id</th><th>Date</th><th>SeverityID</th><th>Severity</th><th>Summary</th><th>Detail</th><th>Status</th><th>Calling Program</th><th>Cleared By</th><th>Cleared When</th><th>Server Id</th><th>Server Name</th><th>Action</th></tr></thead></table>";                        
        $(".table-responsive").children().remove();
        $(".table-responsive").html($data);           

        if ($( "#severity option:selected" ).attr("value") != 0) {                                             
            updateDatatable('getEvents', $( "#severity option:selected" ).attr("value"));
        } else {
            updateDatatable('getTotalEvents', '');
        }
        //$("select#severity").prop('selectedIndex', 0);        
    });    
  
    //Answer "Yes" to the question "Are you sure you want to clear the selected events?"  
    $('#cd-popup-yes').on('click', function(event){
        $.ajax({ url: 'db/queries.php',
             data: {action: 'clearEvents', ids: JSON.parse(sessionStorage.getItem("events"))},
             type: 'post',
             success: function(output) {
                        $('.cd-popup').removeClass('is-visible');
                        $('#cd-popup-ok').addClass('is-visible');
                        sessionStorage.removeItem("events");
                        $("select#severity").prop('selectedIndex', 0);                            
                        $data =  "<table class='table table-striped table-bordered table-hover eventsDataTable' width='100%'><thead><tr><th>Event Id</th><th>Production Id</th><th>Order Id</th><th>Date</th><th>SeverityID</th><th>Severity</th><th>Summary</th><th>Detail</th><th>Status</th><th>Calling Program</th><th>Cleared By</th><th>Cleared When</th><th>Server Id</th><th>Server Name</th><th>Action</th></tr></thead></table>";                        
                        $(".table-responsive").children().remove();
                        $(".table-responsive").html($data);                        
                        updateDatatable('getTotalEvents', '');
                      }
        });                
    });   

    //Answer "Yes" to the question "Are you sure you want to clear all events?"  
    $('#cd-popup-clear-all-yes').on('click', function(event){
        
        var events = [];
        var rows = $(".eventsDataTable").dataTable().fnGetNodes();
        for(var i=0;i<rows.length;i++)
        {
            var tr = rows[i];              
            var index = oTable.fnGetPosition(tr);
            var value = oTable.fnGetData(index)["pvaEventId"];
            
            events.push(value);             
                        
        }        

        
        $.ajax({ url: 'db/queries.php',
             data: {action: 'clearEvents', ids: events},
             type: 'post',
             success: function(output) {
                        $('.cd-popup').removeClass('is-visible');
                        $('#cd-popup-clear-all-ok').addClass('is-visible');
                        sessionStorage.removeItem("events");                         
                        $data =  "<table class='table table-striped table-bordered table-hover eventsDataTable' width='100%'><thead><tr><th>Event Id</th><th>Production Id</th><th>Order Id</th><th>Date</th><th>SeverityID</th><th>Severity</th><th>Summary</th><th>Detail</th><th>Status</th><th>Calling Program</th><th>Cleared By</th><th>Cleared When</th><th>Server Id</th><th>Server Name</th><th>Action</th></tr></thead></table>";                        
                        $(".table-responsive").children().remove();
                        $(".table-responsive").html($data);                        
                        updateDatatable('getTotalEvents', '');
                      }
        });
    });       

    //Answer "Yes" to the question "Are you sure you want to select all events?"  
    $('#cd-popup-select-all-yes').on('click', function(event){
        
        var events = [];
        var rows = $(".eventsDataTable").dataTable().fnGetNodes();
        for(var i=0;i<rows.length;i++)
        {
            var tr = rows[i];              
            var index = oTable.fnGetPosition(tr);
            var value = oTable.fnGetData(index)["pvaEventId"];
            
            events.push(value);             
                        
        }        

        sessionStorage.setItem("events", JSON.stringify(events));

        oTable.remove();        
        $data =  "<table class='table table-striped table-bordered table-hover eventsDataTable' width='100%'><thead><tr><th>Event Id</th><th>Production Id</th><th>Order Id</th><th>Date</th><th>SeverityID</th><th>Severity</th><th>Summary</th><th>Detail</th><th>Status</th><th>Calling Program</th><th>Cleared By</th><th>Cleared When</th><th>Server Id</th><th>Server Name</th><th>Action</th></tr></thead></table>";                        
        $(".table-responsive").children().remove();
        $(".table-responsive").html($data);           

        updateDatatable('getTotalEvents', '');

        $('.cd-popup').removeClass('is-visible');

    });   

    //Answer "Yes" to the question "Are you sure you want to unselect all events?"  
    $('#cd-popup-unselect-all-yes').on('click', function(event){
        var events = [];
        /*$('.eventsDataTable tbody tr').each(function () {                       
                var tr = $(this);          
                var checkbox = $(tr).find("input[type=checkbox]");                      
                if (checkbox.attr("checked", true)){
                    checkbox.attr("checked", false);                    
                }
                                                   
        });*/  

        oTable.$('input').removeAttr( 'checked' );   

        sessionStorage.setItem("events", JSON.stringify(events));

        $('.cd-popup').removeClass('is-visible');
    });       

    //Answer "Ok" to the info "Events succefully cleared"    
    $('#cd-popup-ok').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });

    //Answer "Ok" to the info "All events succefully cleared"    
    $('#cd-popup-clear-all-ok').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });    

    //Answer "No" to the question "Are you sure you want to clear the selected events?"    
    $('#cd-popup-no').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });  

    //Answer "No" to the question "Are you sure you want to clear all events?"    
    $('#cd-popup-clear-all-no').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });  

    //Answer "No" to the question "Are you sure you want to select all events?"    
    $('#cd-popup-select-all-no').on('click', function(event){
        $('.cd-popup').removeClass('is-visible');
    });      

    //Answer "No" to the question "Are you sure you want to unselect all events?"    
    $('#cd-popup-unselect-all-no').on('click', function(event){
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
  sessionStorage.removeItem("events");
};