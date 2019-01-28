<?php
namespace funarte;

class taxItem {
	use Singleton;

	private $name = 'item';
	public function get_name() {
		return $this->name;
	}

	protected function init() {
		add_action('init', array( &$this, "register_taxonomy" ), 9);
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
				'labels' => $labels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => false
			)
		);
	}
}

taxItem::get_instance();
