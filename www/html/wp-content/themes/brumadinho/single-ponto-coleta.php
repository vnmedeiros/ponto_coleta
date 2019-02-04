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
?>
	<main role="main">

		<ul class="postos-lista postos-lista--type-b">
			<li>
				<button class="collapse-button" type="button"><strong>Ponto A</strong></button>
				<div class="box-collapse active">
					<span>Endereço completo, número 11 - Cidade</span>
					<span>1111-1111</span>
					<span>email@email.com</span>
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