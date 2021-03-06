<?php

function add_files() {
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );
	// CSS
	wp_enqueue_style('base-style', get_theme_file_uri() . '/assets/css/base.css');
	wp_enqueue_style('datatables-style', get_theme_file_uri() . '/assets/css/datatables.min.css');
	wp_enqueue_style('jquery-modal-style', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css');
	// Javascript	
	wp_enqueue_script('base-script', get_theme_file_uri() . '/assets/js/base.js');
	wp_enqueue_script('datatables-js', get_theme_file_uri() . '/assets/js/datatables.min.js', null, microtime(), true);
	wp_enqueue_script('jquery-modal-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js');
}
add_action('admin_enqueue_scripts', 'add_files');
add_action('wp_enqueue_scripts','add_files');


function config_ajaxurl() {
	$html = '<script type="text/javascript">';
	$html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
	$html .= '</script>';
	echo $html;
}
add_action('wp_head','config_ajaxurl');


require_once('inc/traits/singleton.php');

//includes - taxonomy
require_once('inc/taxonomy/item.php');

//includes - post type
require_once('inc/post_types/ponto/ponto.php');


$user = wp_get_current_user();
if ( in_array( 'author', (array) $user->roles ) ) {
	function remove_menus(){

		remove_menu_page( 'index.php' ); //Dashboard 
		remove_menu_page( 'edit.php' ); //Posts - publicações
		remove_menu_page( 'upload.php' ); //Media - imagens, vídeos, docs, etc...
		remove_menu_page( 'edit.php?post_type=page' ); //Pages - páginas
		remove_menu_page( 'edit-comments.php' ); //Comments - comentários
		remove_menu_page( 'themes.php' ); //Appearance - aparência (recomendo!)
		remove_menu_page( 'plugins.php' ); //Plugins (recomendo!)
		remove_menu_page( 'users.php' ); //Users - usuários 
		remove_menu_page( 'tools.php' ); //Tools - ferramentas (recomendo!)
		remove_menu_page( 'options-general.php' ); //Settings - configurações 
		remove_menu_page( 'admin.php?page=revslider' ); //revolution slider, se estiver instalado
		
		}
		add_action( 'admin_menu', 'remove_menus' );
}
