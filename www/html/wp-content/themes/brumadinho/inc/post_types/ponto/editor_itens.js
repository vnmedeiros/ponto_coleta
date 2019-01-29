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
				console.log("error inesperado");
			}
		});
	});
	
	jQuery('.btn-resumo-pontos').click(function(e) {
		jQuery.ajax({
			type: "GET",
			url: ajaxurl,
			data: `action=get_pontos_by_term&term_id=${this.dataset['term']}`,
			success: function(data) {
				console.log(data);
				jQuery('#tabela-resumo-pontos').DataTable().destroy();
				jQuery('#tabela-resumo-pontos').empty();
				tabela_resumo_pontos = jQuery('#tabela-resumo-pontos').DataTable( {
					data: data,
					columns: [
							{ data: 'title' },
							{ data: 'item.saldo' }
					]
			} );
			}
		});
	});

});