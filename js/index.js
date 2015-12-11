$(document).ready(function() {


	/*****************************************************************************************************************/
	/*********************************************** DECLARATIONS AREA ***********************************************/
	/*****************************************************************************************************************/


	$services = ['Worldpanel', 'Food On The Go', 'Worldpanel Ireland', 'Combined Panel', 'Petrol Panel', 'Foods Online', 'Pulse'];



	/*****************************************************************************************************************/
	/***************************************************** EVENTS AREA ***********************************************/
	/*****************************************************************************************************************/
	
	$(document).on("click", "#btnQueue", function(event){
		event.preventDefault();
		$("#topMenuTitle").html("<h2>Queue<h2>");
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load("queue.html");		
	});

	$(document).on("click", "#allEventsLink", function(event){ 
		event.preventDefault();
		$("#topMenuTitle").html("<h2>Events<h2>");
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load("events.html");		
	});	
	
	$(document).on("click", "#btnSerSummary", function(event){
		event.preventDefault();		
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva.php" );
	});		
	
	$(document).on("click", ".getService", function(event){
		event.preventDefault();
		sessionStorage.setItem("activeService", this.name);
		$("#topMenuTitle").html("<h2>"+this.name+"<h2>");
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva.php" );
	});

	$(document).on("click", "#newPVsetup", function(event){
		event.preventDefault();
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva_new_order.php" );
	});		


	/*****************************************************************************************************************/
	/****************************************************** UPDATE FUNCTIONS *****************************************/
	/*****************************************************************************************************************/


	/* get all info from DB using ajax */
	function getMainInfo(service){		
		//getAdminServerStatus();
		//getInfoPoint("NrServersActive");
		//getInfoPoint("NrServersOnStandby");
		//getInfoPoint("NrServersInactive");		
		getInfoPoint("NrCriticalEvents");
		getInfoPoint("NrWarningEvents");
		getInfoPoint("NrInformationEvents");
		getInfoPoint("NrTotalEvents");		
		//getDBInfo("Databases", service);
		//getDBInfo("Deliverables", service);
		//getDBInfo("CMA", service);
		//getDBInfo("Reworks", service);
		//getDBInfo("DatabasesInQueue", service);
		//getDBInfo("DatabasesBeingProduced", service);	
		//getQueueInfo("Queue");			
		getDatabasesInfoMain();
		getDeliverablesInfoMain();
		getCMAInfoMain();
	}


	/* fill all information once all is retrieved from DB */
	function fillMainInfo(service){
		//updateAdminServerStatus();
		//updateInfoPoint("NrServersActive");
		//updateInfoPoint("NrServersOnStandby");
		//updateInfoPoint("NrServersInactive");
		updateEventsInfoPoint("NrCriticalEvents");
		updateEventsInfoPoint("NrWarningEvents");
		updateEventsInfoPoint("NrInformationEvents");
		updateInfoPoint("NrTotalEvents");		
		//updateDatabasesInfo(service);
		//updateQueue("DatabasesInQueue");
		//updateQueue("DatabasesBeingProduced");
		//updateQueueInfo();
		updateDatabasesInfoMain();
		updateDeliverablesInfoMain();
		updateCMAInfoMain();		
		$('#overlay').fadeOut('slow'); 
	}

	/* frist get info from DB, once all retrieved using ajax, then fill the info in the page */
	function updateMainInfo(){
		getMainInfo();
        function checkPendingRequest() {
            if ($.active > 0) {                     
                window.setTimeout(checkPendingRequest, 1000);
            }
            else {             
               fillMainInfo();
            }
        };

        window.setTimeout(checkPendingRequest, 1000);		
	}

	/* OnLoad call all update functions */
	updateMainInfo();

});


	/*****************************************************************************************************************/
	/************************ COMMON UPDATE FUNCTIONS AVAILABLE FROM THE REST OF THE PAGES  **************************/
	/*****************************************************************************************************************/

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

	function getQueueInfo(type){	
		$.ajax({ url: 'db/queries.php',
			data: {action: 'get'+type+'Info'},
			type: 'post',
			success: function(output) {
				var outputArray = JSON.parse(output);
				sessionStorage.setItem(type+"Info", JSON.stringify(outputArray));	
			}
		});

	}

	function getDatabasesInfoMain(){		
		$.ajax({ url: 'db/queries.php',
			data: {action: 'getDatabasesInfoMain'},
			type: 'post',
			success: function(output) {			
				var outputArray = JSON.parse(output);		
				sessionStorage.setItem("DatabasesInfoMain", JSON.stringify(outputArray));	
			}
		});		
	}

	function getDeliverablesInfoMain(){		
		$.ajax({ url: 'db/queries.php',
			data: {action: 'getDeliverablesInfoMain'},
			type: 'post',
			success: function(output) {					
				var outputArray = JSON.parse(output);		
				sessionStorage.setItem("DeliverablesInfoMain", JSON.stringify(outputArray));	
			}
		});		
	}	

	function getCMAInfoMain(){		
		$.ajax({ url: 'db/queries.php',
			data: {action: 'getCMAInfoMain'},
			type: 'post',
			success: function(output) {			
				var outputArray = JSON.parse(output);		
				sessionStorage.setItem("CMAInfoMain", JSON.stringify(outputArray));	
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

	function updateQueueInfo(){
		var infoArray = JSON.parse(sessionStorage.getItem("QueueInfo"));		

        if (infoArray != null){
	        $.each(infoArray, function(key,value){  		
	    		//$('#'+type+' tr:last').after('<tr><td>'+value.OrderNumber+'</td><td><b>'+(value.Priority!=undefined?value.Priority:value.ServerName)+'</b></td></tr>');	    		
	    		console.log(value.service + " / " + value.BuildStatus + " / " + value.Nr);
	  		});                
	  	}

	  	/*
        if (infoArray["pvaStatusId"] == 2){
        	$("#adminStatus").removeClass("label-danger").addClass("label-info");
        } else {
        	$("#adminStatus").removeClass("label-info").addClass("label-danger");
        }
        */		
	}

	function updateDatabasesInfoMain(){
		var infoArray = JSON.parse(sessionStorage.getItem("DatabasesInfoMain"));

		$.each(infoArray, function(key,value){
			var color = "#92D400";
			var service = value.service.replace(/ +/g, "");
			var latestPeriod = value.LatestPeriod;
			var totalDatabases = value.TotalDatabases;
			var completedDatabases = value.CompletedDatabases;
			var waitingDatabases = totalDatabases - completedDatabases;
			var totalStatus = Math.round((completedDatabases/totalDatabases)*100);
			var queueStatus = (waitingDatabases == 0 ? 100 : Math.round(100 - (waitingDatabases/totalDatabases)*100));			
			//console.log("Service: " + service + "<br>totalDatabases: " + totalDatabases + "<br>CompletedDatabases " + value.CompletedDatabases + "<br>waitingDatabases " + waitingDatabases + "<br>totalStatus " + totalStatus + "<br>queueStatus " + queueStatus + "<br><br>");
			$("#"+service+"Period").html(latestPeriod);
			$("#"+service+"TotalDatabases").html(completedDatabases);
			$("#"+service+"WaitingDatabases").html(waitingDatabases);

			if (totalStatus < 35){
				color = "#FF504B";
			} else if (queueStatus < 70){
				color = "#FF8200";
			}			
		    Circles.create({
		        id:         'circle-'+service,
		        percentage: totalStatus,
		        radius:     50,
		        width:      5,
		        number:     totalStatus,
		        text:       '%',
		        colors:     ['#eee', color],
		        duration:   1000
		    })
			$("#"+service+"QueueStatus").width(queueStatus+"%");
			$("#"+service+"QueueStatusNr").html(queueStatus+"%");
			if (queueStatus < 35){
				$("#"+service+"QueueStatus").addClass("progress-bar-red");
			} else if (queueStatus < 70){
				$("#"+service+"QueueStatus").addClass("progress-bar-orange");
			}
		});
		
	}

	function updateDeliverablesInfoMain(){
		var infoArray = JSON.parse(sessionStorage.getItem("DeliverablesInfoMain"));
		
		$.each(infoArray, function(key,value){
			var service = value.service.replace(/ +/g, "");
			//var latestPeriod = value.LatestPeriod;
			var totalDeliverables = value.TotalDeliverables;
			var completedDeliverables = value.CompletedDeliverables;
			var waitingDeliverables = totalDeliverables - completedDeliverables;
			//$("#"+service+"Period").html(latestPeriod);
			$("#"+service+"TotalDeliverables").html(completedDeliverables);
			$("#"+service+"WaitingDeliverables").html(waitingDeliverables);
		});
		
	}

	function updateCMAInfoMain(){
		var infoArray = JSON.parse(sessionStorage.getItem("CMAInfoMain"));

		$.each(infoArray, function(key,value){
			var service = value.service.replace(/ +/g, "");
			//var latestPeriod = value.LatestPeriod;
			var totalCMA = value.TotalCMA;
			var completedCMA = value.CompletedCMA
			var waitingCMA = totalCMA - completedCMA;
			//$("#"+service+"Period").html(latestPeriod);
			$("#"+service+"TotalCMA").html(completedCMA);
			$("#"+service+"WaitingCMA").html(waitingCMA);
		});
		
	}