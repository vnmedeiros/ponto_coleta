<?php
namespace pontoColeta;

class PontoColeta {
	use Singleton;

	private $POST_TYPE = "ponto-coleta";
	private $prefix = 'itens';

	public function get_post_type() {
		return $this->POST_TYPE;
	}

	protected function init() {
		add_action('init', array( &$this, "register_post_type" ));
		add_action('add_meta_boxes', array(&$this, 'add_custom_box'));
		add_action('save_post', array(&$this, 'save_custom_box'));
		add_action('wp_ajax_update_item', array(&$this, 'update_item_ajax'));
		add_action('wp_ajax_get_pontos_by_uf', array(&$this, 'get_pontos_by_UF'));
		add_action('wp_ajax_nopriv_get_pontos_by_uf', array(&$this, 'get_pontos_by_UF'));
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
		
		add_meta_box('endereco_custombox', __( 'endereço do ponto de coleta'),
					array(&$this, 'endereco_custom_box'), $this->POST_TYPE, 'normal', 'high');
	}

	public function save_custom_box($post_id) {
		global $post;
		if ($post && $post->post_type != $this->POST_TYPE) {
			return $post_id;
		}
		$this->save_endereco_custom_box($post_id);
	}

	public function itens_custom_box() {
		$THEME_FOLDER = get_template_directory();
		$DS = DIRECTORY_SEPARATOR;
		$META_FOLDER = $THEME_FOLDER . $DS . 'inc' . $DS . 'post_types' . $DS . 'ponto' . $DS;
		require_once($META_FOLDER . 'metabox-itens.php');
	}

	public function endereco_custom_box() {
		global $post;
		$endereco = ['uf'=>"", 'cidade'=>"", 'endereco'=>"", 'telefone'=>"", 'email'=>""];
		$endereco = [	'uf' 			=> get_post_meta($post->ID, "ponto-uf", true),
									'cidade'	=> get_post_meta($post->ID, "ponto-cidade", true),
									'endereco'=> get_post_meta($post->ID, "ponto-endereco", true),
									'telefone'=> get_post_meta($post->ID, "ponto-telefone", true),
									'email'		=> get_post_meta($post->ID, "ponto-email", true)];

		$THEME_FOLDER = get_template_directory();
		$DS = DIRECTORY_SEPARATOR;
		$META_FOLDER = $THEME_FOLDER . $DS . 'inc' . $DS . 'post_types' . $DS . 'ponto' . $DS;
		require_once($META_FOLDER . 'metabox-endereco.php');
	}

	public function save_endereco_custom_box($post_id) {
		if (empty($_POST)) {
			return $post_id;
		}
		// if (!wp_verify_nonce($_POST['itens_meta_custombox'], __FILE__)) {
		// 	return $post_id;
		// }
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		if (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		$fields = array('cidade', 'endereco', 'telefone', 'email');
		$endereco = $_POST['endereco'];
		foreach ($endereco as $field => &$value) {
			if (in_array($field, $fields)) {
				update_post_meta($post_id, "ponto-$field", $value);
			}
		}
		$value = $_POST['endereco-estado'];
		update_post_meta($post_id, "ponto-uf", $value);
		return $endereco;
	}

	function update_item_ajax() {
		if (empty($_POST)) {
			wp_send_json_error();
			return false;
		}

		$post_id			= $_POST['post_id'];
		$post_item		= $_POST['item'];
		$post_entrada = $_POST['entrada'];
		$post_saida 	= $_POST['saida'];

		// if (!wp_verify_nonce($_POST['itens_meta_custombox'], __FILE__)) {
		// 	wp_send_json_error("verify_nonce");
		// 	return $post_id;
		// }
		if (!isset($post_id) ||	!isset($post_item) || !isset($post_entrada) ||	!isset($post_saida)) {
			wp_send_json_error("data not found");
			return $post_id;
		}
		if ($post_entrada < 0 || $post_saida < 0) {
			wp_send_json_error("invalid data");
			return $post_id;
		}
		if (!current_user_can('edit_post', $post_id)) {
			wp_send_json_error("user can't edit");
		 	return $post_id;
		}

		$key_meta = "$this->prefix-$post_item";
		$value = ['entrada'	=>	$post_entrada,
							'saida'		=>	$post_saida,
							'saldo'		=>	($post_entrada - $post_saida)];

		$item = get_post_meta($post_id, $key_meta, true);
		if (!empty($item)) {
			$value['entrada']	= $item['entrada'] + $value['entrada'];
			$value['saida']		= $item['saida'] + $value['saida'];
			$value['saldo']		= $value['entrada'] - $value['saida'];
		}
		update_post_meta($post_id, $key_meta, $value);
		wp_send_json([$key_meta => $value], 201);
	}

	function get_pontos_by_UF() {
		if (empty($_GET)) {
			wp_send_json_error('error ao recuperar pontos de coleta');
			return false;
		}
		$UF = strtoupper($_GET['uf']);

		$args = array(
			'post_type' => $this->POST_TYPE,
			'meta_query' => array(
				array('key' => 'ponto-uf', 'value' => $UF, 'compare' => '=')
			)
		);
		$loop = new \WP_Query($args);
		$pontos = [];
		while ( $loop->have_posts() ) {
			$loop->the_post();
			$title = get_the_title();
			$itens = $this->get_itens(get_the_ID());
			$pontos[] = [	'titulo' => $title, 
										'endereco' => $this->get_endereco(get_the_ID()),
										'itens' => $itens ];
		}
		wp_reset_query();
		wp_send_json($pontos, 200);
	}

	private function get_itens($post_id) {
		$post_metas = get_post_meta($post_id);
		$itens = [];
		foreach ($post_metas as $key => $element) {
			$exp_key = explode('-', $key);
			if($exp_key[0] == 'itens') {
				$item = unserialize($element[0]);
				$item['term_id'] = $exp_key[1];
				$term_name = get_term($item['term_id'], taxItem::get_instance()->get_name())->name;
				$item['term_name'] = $term_name;
				$itens[] = $item;
			}
		}
		return $itens;
	}

	private function get_endereco($post_id) {
		$endereco = [	'uf' 			=> get_post_meta($post_id, "ponto-uf", true),
									'cidade'	=> get_post_meta($post_id, "ponto-cidade", true),
									'endereco'=> get_post_meta($post_id, "ponto-endereco", true),
									'telefone'=> get_post_meta($post_id, "ponto-telefone", true),
									'email'		=> get_post_meta($post_id, "ponto-email", true)];
		return $endereco;
	}

}

PontoColeta::get_instance();