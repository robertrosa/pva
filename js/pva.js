$(document).ready(function() {

	$services = ['Worldpanel', 'Food On The Go', 'Worldpanel Ireland', 'Combined Panel', 'Petrol Panel', 'Foods Online', 'Pulse'];

	function printChart(produced, delivered, hours){
		//*************************************************	
		//This next two lines are to avoid the chart keeping old information every time we update or change the service
		$("#lineChartDiv").empty();
		$("#lineChartDiv").html('<canvas id="lineChart" height="61" width="219" style="width:219px;height:51px;">');
		producedJSON = JSON.parse(produced);		
		deliveredJSON = JSON.parse(delivered);
		hoursJSON = JSON.parse(hours);
		var lineData = {
		    labels: [hoursJSON[0]+"h", (hoursJSON[1]<24)?hoursJSON[1]+"h":Math.round(hoursJSON[1]/24)+"d", (hoursJSON[2]<24)?hoursJSON[2]+"h":Math.round(hoursJSON[2]/24)+"d", (hoursJSON[3]<24)?hoursJSON[3]+"h":Math.round(hoursJSON[3]/24)+"d", (hoursJSON[4]<24)?hoursJSON[4]+"h":Math.round(hoursJSON[4]/24)+"d", (hoursJSON[5]<24)?hoursJSON[5]+"h":Math.round(hoursJSON[5]/24)+"d", (hoursJSON[6]<24)?hoursJSON[6]+"h":Math.round(hoursJSON[6]/24)+"d"],
		    datasets: [
		        {
		            label: "Databases delivered",
		            fillColor: "rgba(0,0,0,0)",
		            strokeColor: "rgba(220,220,220,1)",
		            pointColor: "rgba(220,220,220,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(220,220,220,1)",
		            data: [deliveredJSON[0], deliveredJSON[1], deliveredJSON[2], deliveredJSON[3], deliveredJSON[4], deliveredJSON[5], deliveredJSON[6]]
		        },
		        {
		            label: "Databases delivered",
		            fillColor: "rgba(0,0,0,0)",
		            strokeColor: "rgba(146,212,0,0.7)",
		            pointColor: "rgba(146,212,0,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(146,212,0,1)",
		            data: [producedJSON[0], producedJSON[1], producedJSON[2], producedJSON[3], producedJSON[4], producedJSON[5], producedJSON[6]]
		        }
		    ]
		};

		var lineOptions = {
		    scaleShowGridLines: true,
		    scaleGridLineColor: "rgba(0,0,0,.05)",
		    scaleGridLineWidth: 1,
		    bezierCurve: true,
		    bezierCurveTension: 0.4,
		    pointDot: true,
		    pointDotRadius: 4,
		    pointDotStrokeWidth: 1,
		    pointHitDetectionRadius: 20,
		    datasetStroke: true,
		    datasetStrokeWidth: 2,
		    datasetFill: true,
		    responsive: true,
		};


		var ctx = $("#lineChart").get(0).getContext("2d");
		var myNewChart = new Chart(ctx).Line(lineData, lineOptions);      
	}
	

	/*****************************************************************************************************************/
	/***************************************************** CALENDAR AREA *********************************************/
	/*****************************************************************************************************************/

	/* initialize the calendar
	 -----------------------------------------------------------------*/
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	$('#calendar').fullCalendar({       

	    header: {
	        left: 'prev,next',
	        center: 'title',
	        right: ''
	    },
	    firstDay: 1,
	    editable: true,
	    droppable: true, // this allows things to be dropped onto the calendar
	    drop: function() {
	        // is the "remove after drop" checkbox checked?
	        if ($('#drop-remove').is(':checked')) {
	            // if so, remove the element from the "Draggable Events" list
	            $(this).remove();
	        }
	    },
	    // add event name to title attribute on mouseover
	    eventMouseover: function(event, jsEvent, view) {
	        if (view.name !== 'agendaDay') {
	            $(jsEvent.target).attr('title', event.title);
	        }
	    },
	    events: [
	        {
	            title: 'All Day Event',
	            start: new Date(y, m, 1)
	        },
	        {
	            title: 'Long Event',
	            start: new Date(y, m, d-5),
	            end: new Date(y, m, d-2),
	        },
	        {
	            id: 999,
	            title: 'Repeating Event',
	            start: new Date(y, m, d+4, 16, 0),
	            allDay: false
	        },
	        {
	            title: 'Meeting',
	            start: new Date(y, m, d, 10, 30),
	            allDay: false
	        },
	        {
	            title: 'Birthday Party',
	            start: new Date(y, m, d+1, 19, 0),
	            end: new Date(y, m, d+1, 22, 30),
	            allDay: false
	        },
	        {
	            title: 'Click for Google',
	            start: new Date(y, m, 28),
	            end: new Date(y, m, 29),
	            url: 'http://google.com/'
	        }
	    ],
	});


	/*****************************************************************************************************************/
	/***************************************************** EVENTS AREA ***********************************************/
	/*****************************************************************************************************************/

	$(".fa-refresh").on('click', function(){
		$('#overlay').fadeIn('fast');		
		updateInfo(sessionStorage.getItem("activeService"));
	});

	$(".btn-xs").on('click', function(){
		var serviceId = this.id;
		$('#overlay').fadeIn('fast');	
		sessionStorage.setItem("activeService", serviceId);
		updateInfo(serviceId);
		$("#databasesServiceName").html(serviceId);
		$("#reworksServiceName").html(serviceId);
		$(".btn-xs").removeClass("active");
		$(this).addClass("active");		
	});	



	/*****************************************************************************************************************/
	/****************************************************** UPDATE FUNCTIONS *****************************************/
	/*****************************************************************************************************************/

	function getAdminServerStatus(){
		$.ajax({ url: 'db/queries.php',
	         data: {action: 'getAdminServerStatus'},
	         type: 'post',
	         success: function(output) {
	         			  var outputArray = JSON.parse(output);	
	         			  sessionStorage.setItem("adminServerStatus", JSON.stringify(outputArray));
	                  }
		});		
	}

	function updateAdminServerStatus(){

		var infoArray = JSON.parse(sessionStorage.getItem("adminServerStatus"));	
        if (infoArray["pvaStatusId"] == 2){
        	$("#adminStatus").removeClass("label-danger").addClass("label-info");
        } else {
        	$("#adminStatus").removeClass("label-info").addClass("label-danger");
        }

	}	

	function updateServersInfo(){
		$.ajax({ url: 'db/queries.php',
	         data: {action: 'getServersInfo'},
	         type: 'post',
	         success: function(output) {
	         			  var outputArray = JSON.parse(output);	
	                      sessionStorage.setItem("serversInfo", JSON.stringify(outputArray));
	                  }
		});
	}

	function getInfoPoint(point){	
		$.ajax({ url: 'db/queries.php',
	         data: {action: 'get' + point},
	         type: 'post',
	         success: function(output) {   
	         			  var outputArray = JSON.parse(output);	                 
	                      sessionStorage.setItem(point, JSON.stringify(outputArray));
	                  }
		});			
	}	

	function updateInfoPoint(point){	
		var infoArray = JSON.parse(sessionStorage.getItem(point));	     
        $("#" + point).html(infoArray);
	}		

	function updateEventsInfoPoint(point){	
                  
        var infoArray = JSON.parse(sessionStorage.getItem(point));
        $("#" + point).html(infoArray);
        $("#" + point + "Header").html(infoArray);
		
	}		

	function getDBInfo(type, service){	
		$.ajax({ url: 'db/queries.php',
			data: {action: 'get'+type+'Info', service: service},
			type: 'post',
			success: function(output) {
				var outputArray = JSON.parse(output);
				sessionStorage.setItem(type+"Info", JSON.stringify(outputArray));	
			}
		});

	}
	
	function updateDatabasesInfo(service){		
		// Databases info		
		var infoArray = {};
		var infoArrayTemp = JSON.parse(sessionStorage.getItem("DatabasesInfo"));
		if (infoArrayTemp != null) {			
			infoArray = infoArrayTemp;				
		}
		if (service+"-0" in infoArray) {
			var NrDatabasesCompleted = infoArray[service+"-0"].CompletedDatabases;
			var NrDatabasesWaiting = infoArray[service+"-0"].TotalDatabases - infoArray[service+"-0"].CompletedDatabases;
			var percentDatabasesCompleted = (infoArray[service+"-0"].CompletedDatabases/infoArray[service+"-0"].TotalDatabases*100).toFixed(0);
			$("#NrDatabasesCompleted").html(NrDatabasesCompleted);
			$("#chartNrDatabasesCompleted").html(NrDatabasesCompleted);
			$("#NrDatabasesWaiting").html(NrDatabasesWaiting);
			$("#chartNrDatabasesWaiting").html(NrDatabasesWaiting);
			$("#percentDatabasesCompleted").html(percentDatabasesCompleted);
			$("#chartPercentDatabasesCompleted").html(percentDatabasesCompleted);
			$("#chartBarPercentDatabasesCompleted").width(percentDatabasesCompleted+"%");
			if (percentDatabasesCompleted > 50){
				$("#databasesIcon").removeClass("fa-level-down").addClass("fa-level-up");
				$("#chartDatabasesIcon").removeClass("fa-level-down").addClass("fa-level-up");
			} else {
				$("#databasesIcon").removeClass("fa-level-up").addClass("fa-level-down");
				$("#chartDatabasesIcon").removeClass("fa-level-up").addClass("fa-level-down");
			}			
	    } else {
			$("#NrDatabasesCompleted").html("0");
			$("#chartNrDatabasesCompleted").html("0");
			$("#NrDatabasesWaiting").html("0");
			$("#chartNrDatabasesWaiting").html("0");
			$("#percentDatabasesCompleted").html("0");
			$("#chartPercentDatabasesCompleted").html("0");
			$("#chartBarPercentDatabasesCompleted").width("0%");
	        $("#databasesIcon").removeClass("fa-level-down").removeClass("fa-level-up");
	        $("#chartDatabasesIcon").removeClass("fa-level-down").removeClass("fa-level-up");
	    }			

		// Deliverables info
		var infoArrayDeliverables = {};
		var infoArrayDeliverablesTemp = JSON.parse(sessionStorage.getItem("DeliverablesInfo"));
		if (infoArrayDeliverablesTemp != null) {			
			infoArrayDeliverables = infoArrayDeliverablesTemp;				
		}
		if (service in infoArrayDeliverables) {
			var NrDeliverablesCompleted = infoArrayDeliverables[service].CompletedDeliverables;
			var NrDeliverablesWaiting = infoArrayDeliverables[service].TotalDeliverables - infoArrayDeliverables[service].CompletedDeliverables;
			var percentDeliverablesCompleted = (infoArrayDeliverables[service].CompletedDeliverables/infoArrayDeliverables[service].TotalDeliverables*100).toFixed(0);		
			$("#chartNrDeliverablesCompleted").html(NrDeliverablesCompleted);		
			$("#chartNrDeliverablesWaiting").html(NrDeliverablesWaiting);		
			$("#chartPercentDeliverablesCompleted").html(percentDeliverablesCompleted);
	        $("#chartBarPercentDeliverablesCompleted").width(percentDeliverablesCompleted+"%");

			if (percentDeliverablesCompleted > 50){			
				$("#chartDeliverablesIcon").removeClass("fa-level-down").addClass("fa-level-up");
			} else {
				$("#chartDeliverablesIcon").removeClass("fa-level-up").addClass("fa-level-down");
			}
	    } else {
			$("#chartNrDeliverablesCompleted").html("0");		
			$("#chartNrDeliverablesWaiting").html("0");		
			$("#chartPercentDeliverablesCompleted").html("0");
	        $("#chartBarPercentDeliverablesCompleted").width("0%");
	        $("#chartDeliverablesIcon").removeClass("fa-level-down").removeClass("fa-level-up");
	    }

		// CMA info
		var infoArrayCMA = {};
		var infoArrayCMATemp = JSON.parse(sessionStorage.getItem("CMAInfo"));
		if (infoArrayCMATemp != null) {			
			infoArrayCMA = infoArrayCMATemp;				
		}			
		if (service in infoArrayCMA) {
			var NrCMACompleted = infoArrayCMA[service].CompletedCMA;
			var NrCMAWaiting = infoArrayCMA[service].TotalCMA - infoArrayCMA[service].CompletedCMA;
			var percentCMACompleted = (infoArrayCMA[service].CompletedCMA/infoArrayCMA[service].TotalCMA*100).toFixed(0);		
			$("#chartNrCMACompleted").html(NrCMACompleted);		
			$("#chartNrCMAWaiting").html(NrCMAWaiting);		
			$("#chartPercentCMACompleted").html(percentCMACompleted);
	        $("#chartBarPercentCMACompleted").width(percentCMACompleted+"%");

			if (percentCMACompleted > 50){			
				$("#chartCMAIcon").removeClass("fa-level-down").addClass("fa-level-up");
			} else {
				$("#chartCMAIcon").removeClass("fa-level-up").addClass("fa-level-down");
			}
	    } else {
			$("#chartNrCMACompleted").html("0");		
			$("#chartNrCMAWaiting").html("0");		
			$("#chartPercentCMACompleted").html("0");
	        $("#chartBarPercentCMACompleted").width("0%");
	        $("#chartCMAIcon").removeClass("fa-level-down").removeClass("fa-level-up");
	    }

		// Reworks info
		var infoArrayReworks = {};
		var infoArrayReworksTemp = JSON.parse(sessionStorage.getItem("ReworksInfo"));
		if (infoArrayReworksTemp != null) {			
			infoArrayReworks = infoArrayReworksTemp;				
		}				
		if (service in infoArrayReworks) {
			var NrReworksCompleted = infoArrayReworks[service].CompletedReworks;
			var NrReworksWaiting = infoArrayReworks[service].TotalReworks - infoArrayReworks[service].CompletedReworks;
			var percentReworksCompleted = (infoArrayReworks[service].CompletedReworks/infoArrayReworks[service].TotalReworks*100).toFixed(0);
			$("#NrReworksCompleted").html(NrReworksCompleted);			
			$("#NrReworksWaiting").html(NrReworksWaiting);			
			$("#percentReworksCompleted").html(percentReworksCompleted);
			if (percentReworksCompleted > 50){
				$("#reworksIcon").removeClass("fa-level-down").addClass("fa-level-up");
			} else {
				$("#reworksIcon").removeClass("fa-level-up").addClass("fa-level-down");
			}
	    } else {
			$("#NrReworksCompleted").html("0");
			$("#NrReworksWaiting").html("0");
			$("#percentReworksCompleted").html("0");
	        $("#reworksIcon").removeClass("fa-level-down").removeClass("fa-level-up");
	    }		

	    var producedDatabases48 = "[0, "+(!infoArray[service+"-5"]?0:infoArray[service+"-5"].CompletedDatabases)+", "+(!infoArray[service+"-4"]?0:infoArray[service+"-4"].CompletedDatabases)+", "+(!infoArray[service+"-3"]?0:infoArray[service+"-3"].CompletedDatabases)+", "+(!infoArray[service+"-2"]?0:infoArray[service+"-2"].CompletedDatabases)+", "+(!infoArray[service+"-1"]?0:infoArray[service+"-1"].CompletedDatabases)+", "+(!infoArray[service+"-0"]?0:infoArray[service+"-0"].CompletedDatabases)+"]";
	    var producedDatabasesHours = "["+(!infoArray[service+"-0"]?0:infoArray[service+"-0"].hours)+", "+(!infoArray[service+"-1"]?0:infoArray[service+"-1"].hours)+", "+(!infoArray[service+"-2"]?0:infoArray[service+"-2"].hours)+", "+(!infoArray[service+"-3"]?0:infoArray[service+"-3"].hours)+", "+(!infoArray[service+"-4"]?0:infoArray[service+"-4"].hours)+", "+(!infoArray[service+"-5"]?0:infoArray[service+"-5"].hours)+", "+(!infoArray[service+"-6"]?0:infoArray[service+"-6"].hours)+"]";	    
	    var deliveredDatabases48 = "["+(!infoArray[service+"-6"]?0:infoArray[service+"-6"].TotalDatabases-infoArray[service+"-6"].DownloadedDatabases)+", "+(!infoArray[service+"-5"]?0:infoArray[service+"-5"].TotalDatabases-infoArray[service+"-5"].DownloadedDatabases)+", "+(!infoArray[service+"-4"]?0:infoArray[service+"-4"].TotalDatabases-infoArray[service+"-4"].DownloadedDatabases)+", "+(!infoArray[service+"-3"]?0:infoArray[service+"-3"].TotalDatabases-infoArray[service+"-3"].DownloadedDatabases)+", "+(!infoArray[service+"-2"]?0:infoArray[service+"-2"].TotalDatabases-infoArray[service+"-2"].DownloadedDatabases)+", "+(!infoArray[service+"-1"]?0:infoArray[service+"-1"].TotalDatabases-infoArray[service+"-1"].DownloadedDatabases)+", "+(!infoArray[service+"-0"]?0:infoArray[service+"-0"].TotalDatabases-infoArray[service+"-0"].DownloadedDatabases)+"]";  
	    printChart(producedDatabases48, deliveredDatabases48, producedDatabasesHours);	    	    

	}

	/*update queue*/
	function updateQueue(type){	
                  
        var infoArray = JSON.parse(sessionStorage.getItem(type+"Info"));  
        if (infoArray != null){
	        $.each(infoArray, function(key,value){  		
	    		$('#'+type+' tr:last').after('<tr><td>'+value.OrderNumber+'</td><td><b>'+(value.Priority!=undefined?value.Priority:value.ServerName)+'</b></td></tr>');
	    		//return key<2;
	  		});                
	  	}
		
	}

	/* get all info from DB using ajax */
	function getInfo(service){
		getAdminServerStatus();
		getInfoPoint("NrServersActive");
		getInfoPoint("NrServersOnStandby");
		getInfoPoint("NrServersInactive");		
		getInfoPoint("NrCriticalEvents");
		getInfoPoint("NrWarningEvents");
		getInfoPoint("NrInformationEvents");
		getInfoPoint("NrTotalEvents");		
		getDBInfo("Databases", service);
		getDBInfo("Deliverables", service);
		getDBInfo("CMA", service);
		getDBInfo("Reworks", service);
		getDBInfo("DatabasesInQueue", service);
		getDBInfo("DatabasesBeingProduced", service);		
	}


	/* fill all information once all is retrieved from DB */
	function fillInfo(service){
		updateAdminServerStatus();
		updateInfoPoint("NrServersActive");
		updateInfoPoint("NrServersOnStandby");
		updateInfoPoint("NrServersInactive");
		updateEventsInfoPoint("NrCriticalEvents");
		updateEventsInfoPoint("NrWarningEvents");
		updateEventsInfoPoint("NrInformationEvents");
		updateInfoPoint("NrTotalEvents");		
		updateDatabasesInfo(service);
		updateQueue("DatabasesInQueue");
		updateQueue("DatabasesBeingProduced");
		$('#overlay').fadeOut('slow'); 
	}

	/* frist get info from DB, once all retrieved using ajax, then fill the info in the page */
	function updateInfo(service){
		getInfo(service);
        function checkPendingRequest() {
            if ($.active > 0) {                     
                window.setTimeout(checkPendingRequest, 1000);
            }
            else {             
               fillInfo(service);
            }
        };

        window.setTimeout(checkPendingRequest, 1000);		
	}

	function initializeInfo(){
		if (sessionStorage.getItem("activeService") === null) {
			sessionStorage.setItem("activeService", "Worldpanel");
			updateInfo("Worldpanel");
		} else {
			var serviceId = sessionStorage.getItem("activeService");
			updateInfo(serviceId);
			$("#databasesServiceName").html(serviceId);
			$("#reworksServiceName").html(serviceId);
			$(".btn-xs").removeClass("active");
			$("#"+serviceId).addClass("active");	
		}
	}

	/* OnLoad call all update functions */
	initializeInfo();	 

});