<?php
namespace pontoColeta;

class taxItem {
	use Singleton;

	private $name = 'item';
	public function get_name() {
		return $this->name;
	}

	protected function init() {
		add_action('init', array( &$this, "register_taxonomy" ), 9);
		add_action('wp_ajax_get_pontos_by_term', array(&$this, 'get_pontos_by_term'));
		add_action('wp_ajax_nopriv_get_pontos_by_term', array(&$this, 'get_pontos_by_term'));
		
		// Add the fields to taxonomy, using our callback function
		add_action( $this->name."_edit_form_fields", array(&$this, 'edit_taxonomy_custom_fields'), 10, 2);
		add_action( $this->name."_add_form_fields",  array(&$this, 'add_taxonomy_custom_fields'), 10, 1);
		// Save the changes made on taxonomy, using our callback function
		add_action( 'edited_'.$this->name, array(&$this, 'save_taxonomy_custom_fields'), 10, 2 );
	}

	public function register_taxonomy() {
		$labels = array(
			'name' =>'Itens',
			'singular_name' => 'Itens',
			'search_items' => 'Buscar Item',
			'all_items' => 'Todos os Itens',
			'parent_item' => 'Item',
			'parent_item_colon' => 'Item Acima:',
			'edit_item' => 'Editar Item',
			'update_item' => 'Atualizar Item',
			'add_new_item' => 'Adicionar Novo Item',
			'new_item_name' => 'Novo nome do Item',
		);
		register_taxonomy(
			$this->name,
			"None",
			array(
				'hierarchical' => true,
				'public' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 5,
				'show_in_rest' => true,
				'query_var' => true
			)
		);
	}

	function add_taxonomy_custom_fields($taxonomy) {
		?>
		<tr class="form-field">
			<th scope="row" valign="top">
					<label for="unidade"><?php _e('Unidade'); ?></label>
			</th>
			<td>
					<input type="text" name="term_meta[unidade]" id="term_meta[unidade]" size="25" style="width:60%;" value="un"><br />
			</td>
		</tr>
		<?php
	}

	function edit_taxonomy_custom_fields($term, $taxonomy) {
		// Check for existing taxonomy meta for the term you're editing
		$t_id = $term->term_id; // Get the ID of the term you're editing
		$term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
		?>
		<tr class="form-field">
			<th scope="row" valign="top">
					<label for="unidade"><?php _e('Unidade'); ?></label>
			</th>
			<td>
					<input type="text" name="term_meta[unidade]" id="term_meta[unidade]" size="25" style="width:60%;" value="<?php echo $term_meta['unidade'] ? $term_meta['unidade'] : 'un'; ?>"><br />
			</td>
		</tr>
		<?php
	}

	// A callback function to save our extra taxonomy field(s)
	function save_taxonomy_custom_fields( $term_id, $tt_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_term_$t_id" );
			$keys = array_keys( $_POST['term_meta'] );
			foreach ( $keys as $key ){
				if ( isset( $_POST['term_meta'][$key] ) ){
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			//save the option array
			update_option( "taxonomy_term_$t_id", $term_meta );
		}
	}

	public function get_pontos_by_term() {
		if (empty($_GET)) {
			wp_send_json_error('error ao recuperar pontos de coleta para o item');
			return false;
		}
		$term_id = strtoupper($_GET['term_id']);
		$key_meta = "itens-$term_id";
		$args = array(
			'post_type' => PontoColeta::get_instance()->get_post_type(),
			'meta_query' => array(
				array(
					'key' => $key_meta,
					'compare' => 'EXISTS'
				)
			)
		);
		$loop = new \WP_Query($args);
		$pontos = [];
		while ( $loop->have_posts() ) {
			$loop->the_post();
			$title = get_the_title();
			$item = get_post_meta(get_the_ID(), $key_meta, true);
			$cidade = get_post_meta(get_the_ID(), "ponto-cidade", true);
			$cidade = isset($cidade)? $cidade : '';
			$telefone = get_post_meta(get_the_ID(), "ponto-telefone", true);
			$telefone = isset($telefone)? $telefone : '';
			$pontos[] = ['title'=>$title, 'item' => $item, 'cidade' => $cidade, 'telefone' => $telefone];
		}
		wp_reset_query();
		wp_send_json($pontos, 200);
	}
	
}

taxItem::get_instance();
