jQuery(document).ready( function () {
	jQuery('#ponto-itens').DataTable();

	jQuery('input[type=submit]').click(function(e) {
		console.log("passou aqui.." + ajaxurl);
		e.preventDefault();
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: "action=update_item&id=15",
			success: function(msg){
				console.log(msg);
			},
		});
	});
} );

