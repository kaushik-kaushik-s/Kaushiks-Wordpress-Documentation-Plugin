<?php
defined('ABSPATH') or die('No script kiddies please!');

class KaushikSannidhi_Documentation_Post_Type {
    public function __construct() {
        add_action('init', [$this, 'register_documentation_post_type']);
        add_action('init', [$this, 'register_documentation_taxonomies']);
    }

    public function register_documentation_post_type() {
        $labels = [
            'name'               => 'Documentation',
            'singular_name'      => 'Doc',
            'menu_name'          => 'Documentation',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Documentation',
            'edit_item'          => 'Edit Documentation',
            'new_item'           => 'New Documentation',
            'view_item'          => 'View Documentation',
            'search_items'       => 'Search Documentation',
            'not_found'          => 'No documentation found',
            'not_found_in_trash' => 'No documentation found in Trash'
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'documentation'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => 20,
            'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes']
        ];

        register_post_type('documentation', $args);
    }

    public function register_documentation_taxonomies() {
        $labels = [
            'name'              => 'Documentation Categories',
            'singular_name'     => 'Documentation Category',
            'search_items'      => 'Search Categories',
            'all_items'         => 'All Categories',
            'parent_item'       => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item'         => 'Edit Category',
            'update_item'       => 'Update Category',
            'add_new_item'      => 'Add New Category',
            'new_item_name'     => 'New Category Name',
            'menu_name'         => 'Documentation Categories',
        ];

        register_taxonomy('documentation_category', ['documentation'], [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'documentation-category'],
        ]);
    }
}