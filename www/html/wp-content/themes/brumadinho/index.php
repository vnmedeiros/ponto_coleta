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
					//$boxMain.addClass('loading').removeClass('active');
				},
				error: function() {
					// $boxMain.removeClass('loading');
					// $box.html('<span class="box-calendario__message">Não foi encontrado nenhum evento no dia selecionado.</span>');
				},
				success: function(html) {
					console.log('html: ', html);
					// var slides = JSON.parse(html),
					// 	dataInicialSeparada,
					// 	dataFinalSeparada;

					// $.each(slides,function(i, slide) {
						
					// 	dataInicialSeparada = slide.dataInicial.split('/');
					// 	dataFinalSeparada = slide.dataFinal.split('/');

					// 	mesInicial = base.calendario.transformarMes(dataInicialSeparada[1]);
					// 	mesFinal = base.calendario.transformarMes(dataFinalSeparada[1]);
						
					// 	var dataString = dataInicialSeparada[0] + '/' + mesInicial;
					// 	if (slide.dataInicial != slide.dataFinal) {
					// 		dataString += ' - ' + dataFinalSeparada[0] + '/' + mesFinal;
					// 	}

					// 	estrutura += '<li class="color-' + slide.areaSlug + '">\
					// 					<h3 class="box-calendario__data" data-inicial="' + slide.dataInicial + '" data-final="' + slide.dataFinal + '">' + dataString + '</h3>\
					// 					<h4 class="box-calendario__titulo">' + slide.titulo + '</h4>\
					// 					<hr>\
					// 					<div class="box-calendario__imagem" style="background-image: url(' + slide.imagem + ');">\
					// 						<div class="link-area">\
					// 							<a href="' + slide.areaLink + '">' + slide.areaSlug + '</a>\
					// 						</div>\
					// 					</div>\
					// 					<div class="box-calendario__linha">\
					// 						<div class="box-calendario__coluna-1">\
					// 							<span class="box-calendario__time">' + slide.horario + '</span>\
					// 							<span class="box-calendario__pin">' + slide.endereco + '</span>\
					// 						</div>\
					// 						<div class="box-calendario__coluna-2">\
					// 							<p>' + slide.texto + '</p>\
					// 							<a class="link-more" href="' + slide.url + '">Ler mais</a>\
					// 						</div>\
					// 					</div>\
					// 				</li>';

					// 	contador++;
						
					// });

					// if (contador <= 0) {
					// 	estrutura += '<li><h4 class="box-calendario__titulo">Não foi encontrado nenhum evento no dia selecionado.</h4></li>';
					// }

					// estrutura += '</ul>';

					// $box.append(estrutura);

					// base.carrossel.iniciarCalendarioCompacto();
					// $datepicker.datepicker('refresh');
					// $boxMain.removeClass('loading');
				}
			});
		});
	});
</script>