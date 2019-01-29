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

<div id="modal-item" class="modal">
	<div>
		<form></form> <!-- pq o modal remove o primeiro form? -->
		<form id="form_update_item">
			<input type="hidden" name="itens_meta_custombox" id="itens_meta_custombox" value="<?php echo $nonce; ?>" />
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
			<p>
			<label style="width: 60px;display: inline-block;">Item:</label>
			<select name="item">
				<?php foreach($terms as $term): ?>
					<option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>	
				<?php endforeach; ?>
			</select>
			</p><p>
			<label style="width: 60px;display: inline-block;">entrada:</label>
			<input name="entrada" type="number" value="0" min="0"/>
			</p><p>
			<label style="width: 60px;display: inline-block;">saida:</label>
			<input name="saida" type="number" value="0" min="0"/>
			</p><p>
			<input type="submit" value="Adicionar" />
			</p>
		</form>
	</div>
</div>

<div id="modal-resumo-pontos" class="modal">
	<table id="tabela-resumo-pontos" class="display" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>Ponto</th>
				<th>Saldo</th>
			</tr>
		</thead>
	</table>
</div>

<!-- Link to open the modal -->
<p><a href="#modal-item" rel="modal:open">Adicionar Item</a></p>

<table id="ponto-itens" class="display" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>Item</th>
			<th>Entrada</th>
			<th>Saida</th>
			<th>Saldo</th>
			<th>...</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($itens as $item): ?>
			<tr>
				<td> <?php echo $item['term_name']; ?> </td>
				<td> <?php echo $item['entrada']; ?> </td>
				<td> <?php echo $item['saida']; ?> </td>
				<td> <?php echo $item['saldo']; ?> </td>
				<td>
					<a class="btn-resumo-pontos" href="#modal-resumo-pontos" rel="modal:open" style="text-decoration: none;" data-term=<?php echo $item['term_id']; ?>>
						<span class="dashicons dashicons-info"></span> 
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>