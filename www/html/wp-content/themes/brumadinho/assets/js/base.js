jQuery(document).ready(function() {
	ativarAjax();
});

function ativarAjax() {
	jQuery('.form-estado').on('submit',function() {
		var estado = jQuery('#estado-lista').val(),
			$box = jQuery('.box-estado');

		if (estado == '') {
			$box.html('');
		} else {
			jQuery.ajax({
				type: 'GET',
				url: ajaxurl + '?action=get_pontos_by_uf&uf=' + estado,
				beforeSend: function() {
					$box.html('').addClass('loading');
				},
				error: function() {
					$box.removeClass('loading');
					$box.html('<ul class="postos-lista"><li><strong>Ocorreu um erro. Tente novamente mais tarde.</strong></li></ul>');
				},
				success: function(html) {
					var estrutura = '<a href="#" id="inicio-ajax" class="sr-only">Início do conteúdo carregado dinamicamente. Os botões da lista abaixo exibem conteúdo escondido.</a><ul class="postos-lista">',
						necessidade = '',
						contador = 0;

					jQuery.each(html,function(i, info) {
						estrutura += '<li>\
											<button class="collapse-button" type="button"><strong>' + info.titulo + '</strong></button>\
											<div class="box-collapse">\
												<a href="#" class="inicio-escondido sr-only">Início do conteúdo escondido.</a>\
												<span>' + info.endereco.endereco + ' - ' + info.endereco.cidade + '</span>\
												<span>' + info.endereco.telefone + '</span>\
												<span>' + info.endereco.email + '</span>';

						if (info.itens.length > 0) {
							estrutura += '<a href="#" class="sr-only">Início da tabela de duas colunas.</a><table>\
												<thead>\
													<tr><td>Item</td><td>Necessidade</td></tr>\
												</thead>\
												<tbody>';

							info.itens.sort(function(a, b){return a.necessidade - b.necessidade});

							jQuery.each(info.itens,function(i, dado) {
								switch(dado.necessidade) {
									case '0':
										necessidade = 'Alta';
										break;
									case '1':
										necessidade = 'Média';
										break;
									case '2':
										necessidade = 'Baixa';
										break;
								}

								estrutura += '<tr><td>' + dado.term_name + '</td><td>' + necessidade + '</td></tr>';
							});

							estrutura += '</tbody></table><a href="#" class="sr-only">Fim da tabela de duas colunas.</a>';
						}

						estrutura += '<a href="#" class="sr-only">Fim do conteúdo escondido.</a></div></li>';

						contador++;
					});

					if (contador <= 0) {
						estrutura += '<li><span>Não foi encontrado nenhum ponto no estado selecionado.</span>';
					}

					estrutura += '</ul>';

					$box.html(estrutura);

					ativarCollapse();
					$box.removeClass('loading');
					jQuery('#inicio-ajax').focus();
				}
			});
		}

		return false;
	});
}

function ativarCollapse() {
	jQuery('.collapse-button').on('click',function() {
		jQuery(this).siblings('.box-collapse').slideToggle(200).find('.inicio-escondido').focus();
	});
}