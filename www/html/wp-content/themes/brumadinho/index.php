<?php
	get_header();
?>

<header>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/mctic.jpg' ?>" alt="MCTIC - Ministério da Ciência, Tecnologia, Inovações e Comunicações - Patria Amada, Brasil - Governo Federal"></a>

	<h1><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/ibict.png' ?>" alt="Ibict - Instituto Brasileiro de Informação em Ciência e Tecnologia"></a></h1>

	<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/correios.png' ?>" alt="Correios"></a>
</header>

<main>
	<h2>Pontos de coleta de doações para Brumadinho</h2>
	
	<p>Por meio do presente sistema, será possível que o gestor do ponto de coleta, que deverá ser gerenciado por cada agência de serviço dos <a href="https://www.correios.com.br/a-a-z/busca-agencias" target="_blank">Correios</a>, 
	cadastre os itens necessários de doação, definindo o nível de necessidade (baixa, média ou alta) de cada item, além da quantidade recebida e remetida do item aos pontos 
	de distribuição ao beneficiário. Ao usuário que pratica a doação é possível obter a informação dos endereços e telefones dos pontos de coleta, e também o nível de necessidade 
	de cada item por ponto de coleta.</p>

	<form class="form-estado" action="#" method="post">
		<fieldset>
			<legend>Formulário de seleção de Estados</legend>

			<label for="estado-lista">Selecione o estado para ver a lista de pontos de coleta</label>

			<div class="form-row">
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

				<button type="submit"><img src="<?php echo get_template_directory_uri() . '/assets/img/ico/lupa.svg' ?>" alt="Pesquisar"></button>
			</div>
		</fieldset>
	</form>

	<div class="box-estado"></div>
</main>

<?php
	get_footer();
?>