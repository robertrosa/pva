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
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load("queue.html");		
	});

	$(document).on("click", "#allEventsLink", function(event){ 
		event.preventDefault();
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
	
});