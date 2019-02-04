<?php
	get_header();
	if (have_posts()): the_post();
	$post_id = get_the_ID();
	$post_metas = get_post_meta($post_id);
	$itens = [];
	foreach ($post_metas as $key => $element) {
		$exp_key = explode('-', $key);
		if($exp_key[0] == 'itens') {
			$item = unserialize($element[0]);
			$item['term_id'] = $exp_key[1];
			$term_name = get_term($item['term_id'], pontoColeta\taxItem::get_instance()->get_name())->name;
			$item['term_name'] = $term_name;
			$itens[] = $item;
		}
	}
	$endereco = [	'uf' 			=> get_post_meta($post_id, "ponto-uf", true),
								'cidade'	=> get_post_meta($post_id, "ponto-cidade", true),
								'endereco'=> get_post_meta($post_id, "ponto-endereco", true),
								'telefone'=> get_post_meta($post_id, "ponto-telefone", true),
								'email'		=> get_post_meta($post_id, "ponto-email", true)];
?>

	<header>
		<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/mctic.jpg' ?>" alt="MCTIC - Ministério da Ciência, Tecnologia, Inovações e Comunicações - Patria Amada, Brasil - Governo Federal"></a>

		<h1><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/ibict.png' ?>" alt="Ibict - Instituto Brasileiro de Informação em Ciência e Tecnologia"></a></h1>

		<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/lgo/correios.png' ?>" alt="Correios"></a>
	</header>

	<main role="main">
		<ul class="postos-lista postos-lista--type-b">
			<li>
				<button class="collapse-button" type="button"><strong><?php the_title(); ?></strong></button>
				<div class="box-collapse active">
					<span> <?php echo isset($endereco['endereco'])? $endereco['endereco'] : ''; ?> </span>
					<span> <?php echo isset($endereco['telefone'])? $endereco['telefone'] : ''; ?> </span>
					<span> <?php echo isset($endereco['ponto-email'])? $endereco['ponto-email'] : ''; ?> </span>
					<a href="#" class="sr-only">Início da tabela.</a>

					<table width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Item</th>
								<th>Entrada</th>
								<th>Saida</th>
								<th>Saldo</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($itens as $item): ?>
								<tr>
									<td> <?php echo $item['term_name']; ?> </td>
									<td> <?php echo $item['entrada']; ?> </td>
									<td> <?php echo $item['saida']; ?> </td>
									<td> <?php echo $item['saldo']; ?> </td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<a href="#" class="sr-only">Fim da tabela.</a>
				</div>
			</li>
		</ul>
	</main>
<?php 
endif;
get_footer();