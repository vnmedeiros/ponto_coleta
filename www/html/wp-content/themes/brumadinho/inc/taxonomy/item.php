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
			$pontos[] = ['title'=>$title, 'item' => $item];
		}
		wp_reset_query();
		wp_send_json($pontos, 200);
	}
	
}

taxItem::get_instance();
