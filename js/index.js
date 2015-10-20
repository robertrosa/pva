$(document).ready(function() {

	$('#btnQueue').click(function(e){
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load("queue.html");		
	});

	$('#btnSerSummary').click(function(){
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva.php" );
	});		

	$('.getService').click(function(){		
		sessionStorage.setItem("activeService", this.name);
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva.php" );
	});
		$('#newPVsetup').click(function(){
		$( ".wrapper-content" ).empty();
		$( ".wrapper-content" ).load( "pva_new_order.php" );
	});		
});