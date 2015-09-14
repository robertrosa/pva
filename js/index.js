$(document).ready(function() {

	$('#btnQueue').click(function(){
		$( ".wrapper-content" ).load( "queue.html" );
	});

	$('#btnSerSummary').click(function(){
		$( ".wrapper-content" ).load( "pva.php" );
	});		

	$('.getService').click(function(){		
		sessionStorage.setItem("activeService", this.name);
		$( ".wrapper-content" ).load( "pva.php" );
	});

});