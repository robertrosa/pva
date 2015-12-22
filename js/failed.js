$(document).ready(function() {   
    var service = sessionStorage.getItem("activeService");
    var type = sessionStorage.getItem("type");
    /* In the select we use BuildStatus (for Failed to Build) or DatabaseStatus (for Failed to Copy). 
       So here we adapt the variable to make the construction of the query more simple in queries.php */
    if (type == "Copy"){type = "Database";}

    function updateDatatable() {
        $('.failedDataTable').DataTable( {        
            "ajax": {
                "url": "db/queries.php",
                "dataSrc": "",
                "type": "POST",
                "data": {"action": 'getFailedInfoMain', "service": service, "type": type},                    
            },
            "columns": [
                { "data": "OrderNumber"},
                { "data": "rfnum" },
                { "data": "orderdescription" },                    
                { "data": "StatusDescription" }
            ]
        } );             
    } 

    updateDatatable();

    var oTable = $('.failedDataTable').dataTable();

});