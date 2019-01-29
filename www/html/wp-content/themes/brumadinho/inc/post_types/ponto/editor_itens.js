jQuery(document).ready( function () {
	
	jQuery('#ponto-itens').DataTable();

	jQuery('#form_update_item input[type=submit]').click(function(e) {
		e.preventDefault();
		var data = jQuery('#form_update_item').serialize();
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: "action=update_item&"+data,
			success: function(msg) {
				document.getElementById("form_update_item").reset();
				jQuery.modal.close();
			},
			error: function(e) {
				console.log("erro....");
			}
		});
	});
});