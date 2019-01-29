<input type="hidden" name="itens_custombox" id="itens_meta_custombox" value="<?php echo $nonce; ?>" />
<?php
	wp_enqueue_script('theme-editor-itens-js', get_theme_file_uri() . '/inc/post_types/ponto/editor_itens.js', null, microtime(), true);

	$terms = get_terms( array(
		'taxonomy' => pontoColeta\taxItem::get_instance()->get_name(),
		'hide_empty' => false,
	) );
?>

<div id="ex1" class="modal">
  <!-- Modal HTML embedded directly into document -->
	<form action="">
		<p><label>Item:</label>
			<select>
				<?php foreach($terms as $term): ?>
					<option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>	
				<?php endforeach; ?>
			</select>
		</p>
		<p><label>entrada:</label><input type="number" /></p>
		<p><label>saida:</label><input type="number" /></p>
		<p><input type="submit" value="Adicionar" /></p>
	</form>
	<a href="#" rel="modal:close">Close</a>
</div>

<!-- Link to open the modal -->
<p><a href="#ex1" rel="modal:open">Open Modal</a></p>

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
        <tr>
            <td>Item - 1</td>
            <td>30</td>
						<td>20</td>
						<td>10</td>
        </tr>
        <tr>
						<td>Item - 2</td>
            <td>60</td>
						<td>30</td>
						<td>30</td>
        </tr>
    </tbody>
</table>