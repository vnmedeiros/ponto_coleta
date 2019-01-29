<?php
namespace pontoColeta;

class PontoColeta {
	use Singleton;

	private $POST_TYPE = "ponto-coleta";

	protected function init() {
		add_action('init', array( &$this, "register_post_type" ));
		add_action('add_meta_boxes', array(&$this, 'add_custom_box'));
		// add_action('save_post', array(&$this, 'save_custom_box'));
		add_action('wp_ajax_update_item', array(&$this, 'update_item_ajax'));
	}

	public function register_post_type() {
		$POST_TYPE_NAME_PLURAL = "Pontos de Coleta";
		$POST_TYPE_NAME_SINGULAR = "Ponto de Coleta";

		$post_type_labels = array(
			'edit_item' => 'Editar',
			'add_new' => 'Adicionar Novo',
			'search_items' => 'Pesquisar',
			'name' => $POST_TYPE_NAME_PLURAL,
			'menu_name' => $POST_TYPE_NAME_PLURAL,
			'singular_name' => $POST_TYPE_NAME_SINGULAR,
			'new_item' => 'Novo ' . $POST_TYPE_NAME_PLURAL,
			'view_item' => 'Visualizar ' . $POST_TYPE_NAME_PLURAL,
			'add_new_item' =>'Adicionar ' . $POST_TYPE_NAME_SINGULAR,
			'parent_item_colon' => $POST_TYPE_NAME_PLURAL . ' acima:',
			'not_found' => 'Nenhum ' . $POST_TYPE_NAME_PLURAL . ' encontrado',
			'not_found_in_trash' => 'Nenhum ' . $POST_TYPE_NAME_PLURAL . ' encontrado na lixeira'
		);
		$post_type_args = array(
			'labels' => $post_type_labels,
			'public' => true,
			'show_ui' => true,
			'rewrite' => true,
			'query_var' => true,
			'can_export' => true,
			'has_archive' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'show_in_nav_menus' => false,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'supports' => array('title'),
			'taxonomies' => [
				taxItem::get_instance()->get_name()
			]
		);

		register_post_type($this->POST_TYPE, $post_type_args);
	}

	public function add_custom_box() {
		add_meta_box('itens_custombox', __( 'Itens do ponto de coleta'),
					array(&$this, 'itens_custom_box'), $this->POST_TYPE, 'normal', 'high');
	}

	// public function save_custom_box($post_id) {
	// 	global $post;
	// 	if ($post && $post->post_type != $this->POST_TYPE) {
	// 		return $post_id;
	// 	}
	// 	$this->save_espaco_cultural_custom_box($post_id);
	// }

	public function itens_custom_box() {
		global $post;
		$nonce = wp_create_nonce(__FILE__);
		$prefix = 'itens';
		$itens = get_post_meta($post->ID, "{$prefix}-saldo", true);
		if ($post->ID && empty($espaco)) {
			$espaco = [
				// "item_slug" => [
				// 	'item_descricao' 			=> "",
				// 	'quantidade entrada' 	=> 0,
				// 	'quantidade saida' 		=> 0,
				// 	'saldo' 							=> 0]
			];
		}

		$THEME_FOLDER = get_template_directory();
		$DS = DIRECTORY_SEPARATOR;
		$META_FOLDER = $THEME_FOLDER . $DS . 'inc' . $DS . 'post_types' . $DS . 'ponto' . $DS;
		require_once($META_FOLDER . 'metabox-itens.php');
	}

	function update_item_ajax() {
		$post_id = $_POST['id'];
		echo "AQUI...";
		return "aqui...";
	}
	

}

PontoColeta::get_instance();