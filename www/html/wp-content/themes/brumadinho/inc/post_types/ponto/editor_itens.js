jQuery(document).ready( function () {
	
	jQuery('#ponto-itens').DataTable();

	function insert_update_item(data, dataArray){
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: "action=update_item&"+data,
			success: function(msg) {
				if (undefined != msg.success && !msg.success) {
					alert("operação não permitida:\n" + msg.data);
					return;
				}
				var data = dataArray;
				var necessidade = "Alta";
				if (data.necessidade = 1) necessidade = "Média";
				else if (data.necessidade = 2) necessidade = "Baixa";

				jQuery(`.term-${data.item}`).find('.necessidade').text(necessidade);
				jQuery(`.term-${data.item}`).find('.entrada').text(parseInt(jQuery(`.term-${data.item}`).find('.entrada').html()) + parseInt(data.entrada));
				jQuery(`.term-${data.item}`).find('.saida').text(parseInt(jQuery(`.term-${data.item}`).find('.saida').html()) + parseInt(data.entrada));
				jQuery(`.term-${data.item}`).find('.saldo').text(
				parseInt(jQuery(`.term-${data.item}`).find('.saldo').html()) + (parseInt(data.entrada)-parseInt(data.saida)));
				document.getElementById("form_update_item").reset();
				jQuery.modal.close();
			},
			error: function(e) {
				console.log("error inesperado");
			}
		});
	}

	jQuery('#form_update_item input[type=submit]').click(function(e) {
		e.preventDefault();
		var data = jQuery('#form_update_item').serialize();
		var dataArray = {};
		jQuery("#form_update_item").serializeArray().map(function(x){dataArray[x.name] = x.value;});
		insert_update_item(data, dataArray);
	});

	jQuery('#form_adicionar_item input[type=submit]').click(function(e) {
		e.preventDefault();
		var data = jQuery('#form_adicionar_item').serialize();
		var dataArray = {};
		jQuery("#form_adicionar_item").serializeArray().map(function(x){dataArray[x.name] = x.value;});
		insert_update_item(data, dataArray);
	});

	jQuery('.btn-editar-item').click(function(e){
		jQuery('#item_id').val(this.dataset['termid']);
		jQuery('#item_name').val(this.dataset['termname']);
	});
	
	jQuery('.btn-resumo-pontos').click(function(e) {
		jQuery.ajax({
			type: "GET",
			url: ajaxurl,
			data: `action=get_pontos_by_term&term_id=${this.dataset['term']}`,
			success: function(data) {
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