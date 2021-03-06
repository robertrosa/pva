$(document).ready(function() {   

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
            { "data": "IsecJobStatus" },
            { "data": "BuildStatus" },
            { "data": "DownloadStatus" },
            { "data": "Priority" }

        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            },
            {
          "targets": 8,
          "sDefaultContent": '<input type="checkbox" class="checkbox">'
        } ]         
    } );             

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
    
    var oTable = $('.queueDataTable').dataTable();

});

window.onbeforeunload = function() {
  sessionStorage.removeItem("queue");

};
