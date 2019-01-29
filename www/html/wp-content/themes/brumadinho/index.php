<?php
	get_header();
?>

<header>
	<h1><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/ibict.jpg' ?>" alt="Ibict"></a></h1>

	<h2>Pontos de coleta de doações para Brumadinho</h2>
</header>

<main>
	<form class="form-estado" action="#" method="post">
		<fieldset>
			<legend>Formulário de seleção de Estados</legend>

			<label for="estado-lista">Selecione o estado para ver a lista de pontos de coleta</label>
			<select id="estado-lista" name="uf">
				<option value="">Selecione</option>
				<option value="AC">Acre</option>
				<option value="AL">Alagoas</option>
				<option value="AP">Amapá</option>
				<option value="AM">Amazonas</option>
				<option value="BA">Bahia</option>
				<option value="CE">Ceará</option>
				<option value="DF">Distrito Federal</option>
				<option value="ES">Espírito Santo</option>
				<option value="GO">Goiás</option>
				<option value="MA">Maranhão</option>
				<option value="MT">Mato Grosso</option>
				<option value="MS">Mato Grosso do Sul</option>
				<option value="MG">Minas Gerais</option>
				<option value="PA">Pará</option>
				<option value="PB">Paraíba</option>
				<option value="PR">Paraná</option>
				<option value="PE">Pernambuco</option>
				<option value="PI">Piauí</option>
				<option value="RJ">Rio de Janeiro</option>
				<option value="RN">Rio Grande do Norte</option>
				<option value="RS">Rio Grande do Sul</option>
				<option value="RO">Rondônia</option>
				<option value="RR">Roraima</option>
				<option value="SC">Santa Catarina</option>
				<option value="SP">São Paulo</option>
				<option value="SE">Sergipe</option>
				<option value="TO">Tocantins</option>
			</select>
		</fieldset>
	</form>

	<div class="box-estado">
		
	</div>
</main>


<?php
	get_footer();
?>
<script>
	jQuery(document).ready(function() {
		jQuery('#estado-lista').on('change',function() {
			var estado = jQuery(this).val();
			console.log('estado: ',estado);

			jQuery.ajax({
				type: 'GET',
				url: ajaxurl + '?action=get_pontos_by_uf&uf=' + estado,
				beforeSend: function() {
					console.log('before');
					//$boxMain.addClass('loading').removeClass('active');
				},
				error: function() {
					console.log('error');
					// $boxMain.removeClass('loading');
					jQuery('.box-estado').html('<ul class="postos-lista"><li><strong>Ocorreu um erro. Tente novamente mais tarde.</strong></li></ul>');
				},
				success: function(html) {
					console.log('success');
					var estrutura = '<ul class="postos-lista">',
						contador = 0;

					jQuery.each(html,function(i, info) {
						console.log('i: ',i);
						console.log('info: ',info);

						estrutura += '<li>\
											<strong>' + info.titulo + '</strong>\
											<span>' + info.endereco.endereco + ' - ' + info.endereco.cidade + '</span>\
											<span>' + info.endereco.telefone + '</span>\
											<span>' + info.endereco.email + '</span>';

						if (info.itens.length > 0) {
							estrutura += '<table>\
												<thead>\
													<tr><td>Item</td><td>Entrada</td><td>Saída</td><td>Saldo</td></tr>\
												</thead>\
												<tbody>';

							console.log('info.itens: ',info.itens.length);

							jQuery.each(info.itens,function(i, dado) {
								estrutura += '<tr><td>' + dado.term_name + '</td><td>' + dado.entrada + '</td><td>' + dado.saida + '</td><td>' + dado.saldo + '</td></tr>';
							});

							estrutura += '</tbody></table></li>';
						}

						contador++;
					});

					if (contador <= 0) {
						estrutura += '<li><span>Não foi encontrado nenhum ponto no estado selecionado.</span>';
					}

					estrutura += '</ul>';

					jQuery('.box-estado').html(estrutura);

					// $boxMain.removeClass('loading');
				}
			});
		});
	});
</script>