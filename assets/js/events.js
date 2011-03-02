$(document).ready(function() {				   

        
	jQuery(function(){
					
		/* makes my fancy menus */		
		jQuery('ul.sf-menu').superfish();
	});
	
	

		
		/* Makes tables id'd businessTable sortable */
		$("#customerTable").tablesorter()
		.tablesorterPager({container: $("#pager")});
		 


}); 

