$(document).ready(function() {	
		

	/*****************************************************************************************************************/
	/*********************************************** DECLARATIONS AREA ***********************************************/
	/*****************************************************************************************************************/


	$services = ['Worldpanel', 'Food On The Go', 'Worldpanel Ireland', 'Combined Panel', 'Petrol Panel', 'Foods Online', 'Pulse'];


	/*****************************************************************************************************************/
	/********************************************* INITIALIZATION AREA ***********************************************/
	/*****************************************************************************************************************/

	CirclesMaster.initCirclesMaster1();
	$("#sparkline").sparkline([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], {
	    type: 'bar',
	    barWidth: 8,
	    height: '124px',
	    barColor: '#92D400',
	    negBarColor: '#92D400'
	});



	/*****************************************************************************************************************/
	/***************************************************** EVENTS AREA ***********************************************/
	/*****************************************************************************************************************/
	
	$(document).on("click", "#btnQueue", function(event){
		loadQueue();
	});

	$(document).on("click", "#btnEvents", function(event){
		loadEvents();
	});

	$(document).on("click", "#allEventsLink", function(event){ 
		loadEvents();
	});	

	$(document).on("click", "#criticalEventsLink", function(event){ 
		loadCriticalEvents();
	});	

	$(document).on("click", "#warningEventsLink", function(event){ 
		loadWarningEvents();
	});	

	$(document).on("click", "#informationEventsLink", function(event){ 
		loadInformationEvents();
	});				
	
	$(document).on("click", "#btnSerSummary", function(event){
		showServiceSummary();
	});		
	
	$(document).on("click", ".getService", function(event){
		event.preventDefault();
		sessionStorage.setItem("activeService", this.name);
		$("#topMenuTitle").html("<h2>"+this.name+"<h2>");
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva.php" );
		location.hash = "serSummary";
	});

/* Create new / edit existing orders */
	$(document).on("click", "#newPVsetup", function(event){
		event.preventDefault();

		loadOrderSetup();
	});

	$(document).on("click", "#existingPVsetup", function(event){
		event.preventDefault();

		loadEditOrder();
	});

	$(document).on("click", ".plus-info", function(event){
		event.preventDefault();

		obj = "#"+this.name+"-extra-info";
		
		if ($(obj).css("display") == "none"){
			$("#"+this.name+"-extra-info").css("display", "block");
		} else {
			$("#"+this.name+"-extra-info").css("display", "none");
		}
		
	});		

	$(document).on("click", ".btn-danger", function(event){
		event.preventDefault();
		
		sessionStorage.setItem("activeService", this.name);
		sessionStorage.setItem("type", this.value);
		
		$("#topMenuTitle").html("<h2>"+this.name+" Failed to "+this.value+"<h2>");
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "failed.html" );
		location.hash = "failed";				
	});		




	/*****************************************************************************************************************/
	/****************************************************** UPDATE FUNCTIONS *****************************************/
	/*****************************************************************************************************************/


	/* get all info from DB using ajax */
	function getMainInfo(service){	
		getServersPerHour();
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
		//getQueueInfoMain();		
		getDatabasesInfoMain();
		getDeliverablesInfoMain();
		getCMAInfoMain();
		getFailedInfoMain("Build");
		getFailedInfoMain("Copy");
	}


	/* fill all information once all is retrieved from DB */
	function fillMainInfo(service){
		updateServersPerHour();
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
		updateFailedInfoMain("Build");
		updateFailedInfoMain("Copy");
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

	if (location.hash == "" || location.hash == "#index") {
		/* OnLoad call all update functions */
		location.hash = "index";
		updateMainInfo();
	} else {
		hashSelector();
	}

});


	/*****************************************************************************************************************/
	/************************ COMMON UPDATE FUNCTIONS AVAILABLE FROM THE REST OF THE PAGES  **************************/
	/*****************************************************************************************************************/

	// Get NodeLists of the first level (header) list items and the second level list items
	var nav_list_items = document.querySelectorAll("ul#side-menu > li");
	var nav_secondlevel_list_items = document.querySelectorAll("ul.nav-second-level > li");

	function getServersPerHour(){	
		$.ajax({ url: 'db/queries.php',
	         data: {action: 'getServersPerHour'},
	         type: 'post',
	         success: function(output) {   
	         			  var outputArray = JSON.parse(output);	                 
	                      sessionStorage.setItem("ServersPerHour", JSON.stringify(outputArray));
	                  }
		});			
	}		
	
	function UpdateMenuDisplay () {
	// remove the class attribute from all list elements, first & second level
	  for (i=0; i<nav_list_items.length; i++) {
	    nav_list_items[i].removeAttribute("class");
	  }
	  for (i=0; i<nav_secondlevel_list_items.length; i++) {
	    nav_secondlevel_list_items[i].removeAttribute("class");
	  }
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

	/*
	function getQueueInfoMain(){	
		$.ajax({ url: 'db/queries.php',
			data: {action: 'getQueueInfoMain'},
			type: 'post',
			success: function(output) {
				var outputArray = JSON.parse(output);
				sessionStorage.setItem("queueInfoMain", JSON.stringify(outputArray));	
			}
		});

	}*/	

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

	function getFailedInfoMain(type){	
		$.ajax({ url: 'db/queries.php',
			data: {action: 'getFailed'+type+'InfoMain'},
			type: 'post',
			success: function(output) {
				var outputArray = JSON.parse(output);
				sessionStorage.setItem("Failed"+type+"InfoMain", JSON.stringify(outputArray));	
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
	    		//console.log(value.service + " / " + value.BuildStatus + " / " + value.Nr);
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

	function updateServersPerHour(){
		var infoArray = JSON.parse(sessionStorage.getItem("ServersPerHour"));		
		var sparkArray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		var date = new Date();				
		var now = date.getHours();
		var start = now;

		var hoursArray = [];

		for (i=1;i<25;i++){			
			hoursArray.push(start > 23 ? start-24 : start);			
			start = now + i;
		}


		$.each(infoArray, function(key,value){

			sparkArray[value.HourPart] = value.Running;
			
		});

		$("#sparkline").sparkline([sparkArray[hoursArray[0]], sparkArray[hoursArray[1]], sparkArray[hoursArray[2]], sparkArray[hoursArray[3]], sparkArray[hoursArray[4]], sparkArray[hoursArray[5]], sparkArray[hoursArray[6]], sparkArray[hoursArray[7]], sparkArray[hoursArray[8]], sparkArray[hoursArray[9]], sparkArray[hoursArray[10]], sparkArray[hoursArray[11]], sparkArray[hoursArray[12]], sparkArray[hoursArray[13]], sparkArray[hoursArray[14]], sparkArray[hoursArray[15]], sparkArray[hoursArray[16]], sparkArray[hoursArray[17]], sparkArray[hoursArray[18]], sparkArray[hoursArray[19]], sparkArray[hoursArray[20]], sparkArray[hoursArray[21]], sparkArray[hoursArray[22]], sparkArray[hoursArray[23]]], {
		    type: 'bar',
		    barWidth: 8,
		    height: '124px',
		    barColor: '#92D400',
		    negBarColor: '#92D400',
		    tooltipFormat: '{{offset:offset}} {{value}}',
		    tooltipValueLookups: {
		        'offset': {
		            0: hoursArray[0]+'h: ',
		            1: hoursArray[1]+'h: ',
		            2: hoursArray[2]+'h: ',
		            3: hoursArray[3]+'h: ',
		            4: hoursArray[4]+'h: ',
		            5: hoursArray[5]+'h: ',
		            6: hoursArray[6]+'h: ',
		            7: hoursArray[7]+'h: ',
		            8: hoursArray[8]+'h: ',
		            9: hoursArray[9]+'h: ',
		            10: hoursArray[10]+'h: ',
		            11: hoursArray[11]+'h: ',
		            12: hoursArray[12]+'h: ',
		            13: hoursArray[13]+'h: ',
		            14: hoursArray[14]+'h: ',
		            15: hoursArray[15]+'h: ',
		            16: hoursArray[16]+'h: ',
		            17: hoursArray[17]+'h: ',
		            18: hoursArray[18]+'h: ',
		            19: hoursArray[19]+'h: ',
		            20: hoursArray[20]+'h: ',
		            21: hoursArray[21]+'h: ',
		            22: hoursArray[22]+'h: ',
		            23: hoursArray[23]+'h: '
		        }		
		    }	    
		});
		
	}	

	function updateDatabasesInfoMain(){
		var infoArray = JSON.parse(sessionStorage.getItem("DatabasesInfoMain"));
		var infoArrayQueue = JSON.parse(sessionStorage.getItem("queueInfoMain"));

		$.each(infoArray, function(key,value){
			var color = "#92D400";
			var service = value.service.replace(/ +/g, "");
			var latestPeriod = value.LatestPeriod;
			var totalDatabases = value.TotalDatabases;
			var completedDatabases = value.CompletedDatabases;
			var waitingDatabases = totalDatabases - completedDatabases;
			var totalStatus = Math.round((completedDatabases/totalDatabases)*100);
			
			$("#"+service+"Period").html(latestPeriod);
			$("#"+service+"TotalDatabases").html(completedDatabases);
			$("#"+service+"WaitingDatabases").html(waitingDatabases);

			if (totalStatus < 35){
				color = "#FF504B";
			} else if (totalStatus < 70){
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

	function updateFailedInfoMain(type){
		var infoArray = JSON.parse(sessionStorage.getItem("Failed"+type+"InfoMain"));

		$.each(infoArray, function(key,value){
			var service = value.service.replace(/ +/g, "");
			var nr = value.Nr;

			$("#"+service+"Failed"+type).html(nr);
			 $("#"+service+"Failed"+type).prop('disabled', false);

			if (nr > 0){
				$("#"+service+"Failed"+type).removeClass("btn-default").addClass("btn-danger");
			}				
		});
		
	}	

	function loadMain(){
		alert("main");
	}

	function loadQueue(){
		event.preventDefault();
		/*$("#topMenuTitle").html("<h2>Queue<h2>");*/
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load("queue.html");		
		location.hash = "queue";	
	}

	function loadEvents(){
		event.preventDefault();
		/*$("#topMenuTitle").html("<h2>Events<h2>");*/
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load("events.html");		
		location.hash = "allEvents";	
	}

	function loadCriticalEvents(){
		event.preventDefault();
		$("#topMenuTitle").html("<h2>Events<h2>");
		$( ".wrapper-content" ).empty();
		sessionStorage.setItem("severity","16");
		$( ".wrapper-content" ).load("events.html");				
		location.hash = "criticalEvents";			
	}

	function loadWarningEvents(){
		event.preventDefault();
		$("#topMenuTitle").html("<h2>Events<h2>");
		$( ".wrapper-content" ).empty();
		sessionStorage.setItem("severity","48");
		$( ".wrapper-content" ).load("events.html");		
		location.hash = "warningEvents";			
	}	

	function loadInformationEvents(){
		event.preventDefault();
		$("#topMenuTitle").html("<h2>Events<h2>");
		$( ".wrapper-content" ).empty();
		sessionStorage.setItem("severity","64");
		$( ".wrapper-content" ).load("events.html");	
		location.hash = "informationEvents";			
	}	

	function showServiceSummary(){
		event.preventDefault();		
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva.php" );
		location.hash = "serSummary";	
	}

	function loadOrderSetup(){
		/*location.href = 'order_setup.php';*/
		/*$("#topMenuTitle").html("<h2>New Order Setup<h2>");*/
		
		$( ".sub-header" ).empty();
		$( ".sub-header" ).load( "os_sub_header.html" );

		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "order_setup.php" );
		location.hash = "orderSetup";
	}

	function loadEditOrder(){
		/*location.href = 'order_setup.php';*/
		/*$("#topMenuTitle").html("<h2>Edit Existing Order<h2>");*/

		$( ".sub-header" ).empty();
		$( ".sub-header" ).load( "os_sub_header.html" );

		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "order_setup.php" );
		
		$('#edit-select-modal').modal('show');
  // populate the service select list
    $.ajax({
      method: "GET",
      url: "get_service_list.php",
      success: function (output) {
        $('#sel-edit-service').html(output).trigger("chosen:updated");
      }
    });

		location.hash = "editOrder";
	}

	function hashSelector(){
		switch(location.hash) {
		    case "#queue":
		        loadQueue();
		        break;
		    case "#queue":
		        loadQueue();
		        break;
		    case "#allEvents":
		        loadEvents();
		        break;	
		    case "#criticalEvents":
		        loadCriticalEvents();
		        break;	       	        
		    case "#warningEvents":
		        loadWarningEvents();
		        break;	
		    case "#informationEvents":
		        loadInformationEvents();
		        break;	
		    case "#serSummary":
			    	showServiceSummary();
			    	break;
			  case "#orderSetup":
			  		loadOrderSetup();
			  		break;
			  case "#editOrder":
			  		loadOrderSetup();
			  		break;
		    case "#failed":
		    		//location.href = "/";
		    		break;
		}
	}

	$(window).on('hashchange',function(){ 
	// Do something, inspect History.getState() to decide what
	//alert(location.hash);
	//alert(History.getState());
		hashSelector();
	});
