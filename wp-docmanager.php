<?php
/*
Plugin Name: Kaushik Sannidhi's Wordpress Documentation Plugin
Description: A documentation plugin that creates a custom post type for docs with categories, a customizable docs page featuring search functionality, and theme customizer support.
Version: 1.0
Author: Kaushik Sannidhi
*/
defined('ABSPATH') or die('No script kiddies please!');

class KaushikSannidhi_Documentation_Plugin {
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->init_custom_post_types();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-documentation-post-type.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-events-post-type.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-documentation-search.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-documentation-shortcodes.php';
        require_once plugin_dir_path(__FILE__) . 'admin/class-documentation-admin.php';
        require_once plugin_dir_path(__FILE__) . 'public/class-documentation-public.php';
    }

    private function define_admin_hooks() {
        $admin = new KaushikSannidhi_Documentation_Admin();
        add_action('admin_menu', [$admin, 'add_documentation_menu']);
        add_action('admin_init', [$admin, 'register_settings']);
    }

    private function define_public_hooks() {
        $public = new KaushikSannidhi_Documentation_Public();
        add_action('wp_enqueue_scripts', [$public, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$public, 'enqueue_scripts']);
    }

    private function init_custom_post_types() {
        $docs_post_type = new KaushikSannidhi_Documentation_Post_Type();
        $events_post_type = new KaushikSannidhi_Events_Post_Type();
    }

    public function activate() {
        flush_rewrite_rules();
    }

    public function deactivate() {
        flush_rewrite_rules();
    }
}

function run_kaushik_sannidhi_docs_plugin() {
    $plugin = new KaushikSannidhi_Documentation_Plugin();
}

register_activation_hook(__FILE__, [new KaushikSannidhi_Documentation_Plugin(), 'activate']);
register_deactivation_hook(__FILE__, [new KaushikSannidhi_Documentation_Plugin(), 'deactivate']);

run_kaushik_sannidhi_docs_plugin();