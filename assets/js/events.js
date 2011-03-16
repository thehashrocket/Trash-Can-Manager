$(document).ready(function() {				   

		/* Makes tables id'd businessTable sortable */
		$("#customerTable").tablesorter()
		.tablesorterPager({container: $("#pager")});

    // Add a new row
	$('a#add-row').click(function(){

		// Remove if there are others to clone
		row = $('#invoice-items tbody tr:first-child').clone();

		$('input.item_description', row).val('');
		$('input.item_quantity', row).val(1);
		$('input.item_rate', row).val('1.00');
		$('input.item_cost', row).val( '1.00' );
		$('span.item_cost', row).text( '1.00' );
		$('#invoice-items tbody').append(row);
		$.uniform.update('.tax_id');
		return false;
	});

    // Is Recurring?

    $('select[name=is_recurring]').change(function() {

		this.value == 1
			? $('div#recurring-options').slideDown('slow')
			: $('div#recurring-options').slideUp('slow')

		return false;
	}).change();
		 
}); 

