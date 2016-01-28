$(document).ready(function() {   

    function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" width="100%" class="table">'+
            '<tr>'+
                '<td><b>Data Period:</b></td>'+
                '<td>'+d.DataPeriod+'</td>'+

                '<td><b>Number of Periods:</b></td>'+
                '<td>'+d.NumPeriods+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td><b>Build Mode:</b></td>'+
                '<td>'+d.BuildMode+'</td>'+

                '<td><b>Server Id:</b></td>'+
                '<td>'+d.ServerId+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td><b>PVA Mode:</b></td>'+
                '<td>'+d.pvaMode+'</td>'+

                '<td><b>Status Description:</b></td>'+
                '<td>'+d.StatusDescription+'</td>'+
            '</tr>'+
        '</table>';
    }

    function updateDatatable() {
        $('.serversDataTable').DataTable( {        
            "ajax": {
                "url": "db/queries.php",
                "dataSrc": "",
                "type": "POST",
                "data": {"action": 'getServersInfo'},                    
            },
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "ServerName" },
                { "data": "pvaStatus" },
                { "data": "OrderNumber" },                
                { "data": "BuildTimeStart" },
                { "data": "AverageBuildTime" },
                { "data": "ETA" }

            ],
            'columnDefs': [
                {
                   'targets': 4,
                   'render': function(data, type, full, meta){
                      if(type === 'display'){  
                        if (data) {
                            data = data.date.substring(11, 16);
                        }
                      }
                     
                      return data;
                   }
                },
                {
                   'targets': 5,
                   'render': function(data, type, full, meta){
                      if(type === 'display'){  
                        if (data) {
                            data = SecondsTohhmmss(data);
                        }
                      }

                      return data;
                   }
                },
                {
                   'targets': 6,
                   'render': function(data, type, full, meta){
                      if(type === 'display'){  
                        if (data) {
                            data = data.date.substring(11, 16);
                        }
                      }
                     
                      return data;
                   }
                }
            ],
            "rowCallback": function( row, data, index) {
                if (data["pvaStatus"].trim() == "Active") {                    
                    $('td:eq(2)', row).css('color', '#92D400').css("font-weight", "bold");
                } else if (data["pvaStatus"].trim() == "On Standby") {
                    $('td:eq(2)', row).css('color', '#FF8200').css("font-weight", "bold");
                } else if (data["pvaStatus"].trim() == "Inactive") {
                    $('td:eq(2)', row).css('color', '#FF504B').css("font-weight", "bold");
                }                
            }

        } );             
    } 

    function updateAdminDatatable() {
        $('.adminDataTable').DataTable( {     
            "searching": false,
            "ordering": false,
            "bPaginate": false,
            "info": false,
            "ajax": {
                "url": "db/queries.php",
                "dataSrc": "",
                "type": "POST",
                "data": {"action": 'getAdminServerInfoDetail'},                    
            },
            "columns": [
                { "data": "ServerId" },
                { "data": "pvaStatusId" },            
                { "data": "ServerName" },                
                { "data": "pvaMode" },
                { "data": "pvaStatus" },
                { "data": "LastTimeCheck.date" },                
                { "data": "NextPvDemon.date" },
                { "data": "NextPvJobSub.date" },
                { "data": "NextPvDownload.date" }
            ],
            "rowCallback": function( row, data, index) {
                if (data["pvaStatus"].trim() == "Active") {                    
                    $('td:eq(4)', row).css('color', '#92D400').css("font-weight", "bold");
                } else if (data["pvaStatus"].trim() == "On Standby") {
                    $('td:eq(4)', row).css('color', '#FF8200').css("font-weight", "bold");
                } else if (data["pvaStatus"].trim() == "Inactive") {
                    $('td:eq(4)', row).css('color', '#FF504B').css("font-weight", "bold");
                }                
            }
        } );             
    }     

    updateDatatable();
    updateAdminDatatable();

    var oTable = $('.serversDataTable').DataTable();
    var oAdminTable = $('.adminDataTable').DataTable();

    // Add event listener for opening and closing details
    $(document).on('click', '.serversDataTable tbody td.details-control', function () {        
        var tr = $(this).closest('tr');
        var row = oTable.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

});

function toSeconds( time ) {
    var parts = time.split(':');
    return (+parts[0]) * 60 * 60 + (+parts[1]) * 60 + (+parts[2]); 
}

var SecondsTohhmmss = function(totalSeconds) {
  var hours   = Math.floor(totalSeconds / 3600);
  var minutes = Math.floor((totalSeconds - (hours * 3600)) / 60);
  var seconds = totalSeconds - (hours * 3600) - (minutes * 60);

  // round seconds
  seconds = Math.round(seconds * 100) / 100

  var result = (hours < 10 ? "0" + hours : hours);
      result += "h " + (minutes < 10 ? "0" + minutes : minutes);
      result += "m " + (seconds  < 10 ? "0" + seconds : seconds);
      result += "s";
  return result;
}