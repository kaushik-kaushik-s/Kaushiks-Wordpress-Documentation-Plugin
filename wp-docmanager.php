<?php
/*
Plugin Name: Kaushik Sannidhi's Wordpress Documentation Plugin
Description: A documentation plugin that creates a custom post type for docs with categories, a customizable docs page featuring search functionality, and theme customizer support.
Version: 1.0
Author: Kaushik Sannidhi
*/
add_action('init', function(){
	register_post_type('doc', array(
		'labels' => array(
			'name' => 'Docs',
			'singular_name' => 'Doc',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Doc',
			'edit_item' => 'Edit Doc',
			'new_item' => 'New Doc',
			'view_item' => 'View Doc',
			'search_items' => 'Search Docs',
			'not_found' => 'No docs found',
			'not_found_in_trash' => 'No docs found in Trash'
		),
		'public' => true,
		'has_archive' => true,
		'supports' => array('title','editor','author','thumbnail','excerpt','revisions'),
		'menu_icon' => 'dashicons-media-document',
		'rewrite' => array('slug' => 'docs')
	));
	register_taxonomy('doc_category', 'doc', array(
		'labels' => array(
			'name' => 'Doc Categories',
			'singular_name' => 'Doc Category',
			'search_items' => 'Search Doc Categories',
			'all_items' => 'All Doc Categories',
			'edit_item' => 'Edit Doc Category',
			'update_item' => 'Update Doc Category',
			'add_new_item' => 'Add New Doc Category',
			'new_item_name' => 'New Doc Category Name'
		),
		'hierarchical' => true,
		'rewrite' => array('slug' => 'doc-category')
	));
});
add_action('customize_register', function($wp_customize){
	$wp_customize->add_section('kswdp_section', array('title' => 'Documentation Settings', 'priority' => 30));
	$wp_customize->add_setting('kswdp_heading_color', array('default' => '#000000', 'transport' => 'refresh'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kswdp_heading_color_control', array('label' => 'Heading Color', 'section' => 'kswdp_section', 'settings' => 'kswdp_heading_color')));
	$wp_customize->add_setting('kswdp_background_color', array('default' => '#ffffff', 'transport' => 'refresh'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kswdp_background_color_control', array('label' => 'Background Color', 'section' => 'kswdp_section', 'settings' => 'kswdp_background_color')));
});
add_action('wp_head', function(){
	$heading_color = get_theme_mod('kswdp_heading_color', '#000000');
	$background_color = get_theme_mod('kswdp_background_color', '#ffffff');
	echo '<style>.kswdp-doc-page h2{color:'.$heading_color.';} .kswdp-doc-page{background-color:'.$background_color.'; padding:20px;}</style>';
});
add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('kswdp-style', plugin_dir_url(__FILE__).'assets/css/kswdp-style.css');
	wp_enqueue_script('kswdp-script', plugin_dir_url(__FILE__).'assets/js/kswdp-script.js', array('jquery'), null, true);
});
add_shortcode('documentation_page', function(){
	$output = '<div class="kswdp-doc-page">';
	$output .= '<form method="get" action="'.esc_url(get_post_type_archive_link('doc')).'"><input type="text" name="doc_search" placeholder="Search Docs" value="'.(isset($_GET['doc_search']) ? esc_attr($_GET['doc_search']) : '').'"/><input type="submit" value="Search"/></form>';
	$args = array('post_type' => 'doc','posts_per_page' => -1);
	if(isset($_GET['doc_search']) && !empty($_GET['doc_search'])){
		$args['s'] = sanitize_text_field($_GET['doc_search']);
	}
	$docs = new WP_Query($args);
	$grouped = array();
	if($docs->have_posts()){
		while($docs->have_posts()){
			$docs->the_post();
			$terms = get_the_terms(get_the_ID(), 'doc_category');
			$cat = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Uncategorized';
			$grouped[$cat][] = array('title' => get_the_title(), 'link' => get_permalink());
		}
		wp_reset_postdata();
	}
	foreach($grouped as $category => $items){
		$output .= '<h2>'.esc_html($category).'</h2><ul>';
		foreach($items as $item){
			$output .= '<li><a href="'.esc_url($item['link']).'">'.esc_html($item['title']).'</a></li>';
		}
		$output .= '</ul>';
	}
	$output .= '</div>';
	return $output;
});
