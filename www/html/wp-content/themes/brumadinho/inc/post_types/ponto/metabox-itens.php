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

<div id="modal-editar-item" class="modal">
	<div>
		<form></form> <!-- pq o modal remove o primeiro form? -->
		<form id="form_update_item">
			<input type="hidden" name="itens_meta_custombox" id="itens_meta_custombox" value="<?php echo $nonce; ?>" />
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
			<input type="hidden" name="item" id="item_id" value="-1" />
			<p>
				<label style="width: 100px;display: inline-block;">Item:</label>
				<input type="text" name="item_name" id="item_name" disabled style="min-width: 300px;"/>
			</p><p>
				<label style="width: 100px;display: inline-block;">entrada:</label>
				<input name="entrada" type="number" value="0" min="0"/>
			</p><p>
				<label style="width: 100px;display: inline-block;">saida:</label>
				<input name="saida" type="number" value="0" min="0"/>
			</p><p>
				<label style="width: 100px;display: inline-block;">Grau de necessidade:</label>
				<select name="necessidade" class="necessidade">
						<option value="0">Alta</option>
						<option value="1">Média</option>
						<option value="2">Baixa</option>
				</select>
			</p><p>
				<input type="submit" value="Adicionar" />
			</p>
		</form>
	</div>
</div>

<div id="modal-adicionar-item" class="modal">
	<div>
		<form></form> <!-- pq o modal remove o primeiro form? -->
		<form id="form_adicionar_item">
			<input type="hidden" name="itens_meta_custombox" id="itens_meta_custombox" value="<?php echo $nonce; ?>" />
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
			<input type="hidden" name="entrada" value="0" min="0"/>
			<input type="hidden" name="saida" value="0" min="0"/>
			<p>
				<label style="width: 100px;display: inline-block;">Item:</label>
				<select name="item" style="min-width: 300px;">
					<?php foreach($terms as $term): ?>
						<option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
					<?php endforeach; ?>
				</select>
			</p><p>
				<label style="width: 100px;display: inline-block;">Grau de necessidade:</label>
				<select name="necessidade">
						<option value="0">Alta</option>
						<option value="1">Média</option>
						<option value="2">Baixa</option>
				</select>
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
				<th>Cidade</th>
				<th>Telefone</th>
			</tr>
		</thead>
	</table>
</div>

<!-- Link to open the modal -->
<p><a href="#modal-adicionar-item" rel="modal:open">Adicionar Item</a></p>

<table id="ponto-itens" class="display" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>Necessidade</th>
			<th>Item</th>
			<th>Entrada</th>
			<th>Saida</th>
			<th>Saldo</th>
			<th>...</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($itens as $item): ?>
			<tr class="<?php echo "term-".$item['term_id']; ?>">
				<td class="necessidade">
					<?php
						if ($item['necessidade'] == 0 ) echo "Alta";
						if ($item['necessidade'] == 1 ) echo "Média";
						if ($item['necessidade'] == 2 ) echo "Baixa";
					?>
				</td>
				<td> <?php echo $item['term_name']; ?> </td>
				<td class="entrada"> <?php echo $item['entrada']; ?> </td>
				<td class="saida"> <?php echo $item['saida']; ?> </td>
				<td class="saldo"> <?php echo $item['saldo']; ?> </td>
				<td>
					<a class="btn-editar-item" href="#modal-editar-item" style="color: #399244 !important; text-decoration: none;" rel="modal:open" style="text-decoration: none;"
						 data-termid="<?php echo $item['term_id']; ?>"
						 data-termname="<?php echo $item['term_name']; ?>"
						 data-term_necessidade="<?php echo $item['necessidade']; ?>"
						 >
						<span class="dashicons dashicons-welcome-write-blog"></span>
					</a>
					<a class="btn-resumo-pontos" href="#modal-resumo-pontos" rel="modal:open" style="text-decoration: none;" data-term=<?php echo $item['term_id']; ?>>
						<span class="dashicons dashicons-info"></span> 
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>