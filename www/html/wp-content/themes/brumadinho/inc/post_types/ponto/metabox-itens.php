<?php
	wp_enqueue_script('theme-editor-itens-js', get_theme_file_uri() . '/inc/post_types/ponto/editor_itens.js', null, microtime(), true);
	$post_id = get_the_ID();
	$terms = get_terms(array(
		'taxonomy' => pontoColeta\taxItem::get_instance()->get_name(),
		'hide_empty' => false,
	));

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

<div id="ex1" class="modal">
	<div>
		<form></form> <!-- pq o modal remove o primeiro form? -->
		<form id="form_update_item">
			<input type="hidden" name="itens_meta_custombox" id="itens_meta_custombox" value="<?php echo $nonce; ?>" />
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
			
			<label>Item:</label>
			<select name="item">
				<?php foreach($terms as $term): ?>
					<option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>	
				<?php endforeach; ?>
			</select>
			
			<label>entrada:</label>
			<input name="entrada" type="number" />

			<label>saida:</label>
			<input name="saida" type="number" />

			<input type="submit" value="Adicionar" />
		</form>
		<a href="#" rel="modal:close">Fechar</a>
	</div>
</div>

<!-- Link to open the modal -->
<p><a href="#ex1" rel="modal:open">Adicionar Item</a></p>

<table id="ponto-itens" class="display" width="100%" cellspacing="0">
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