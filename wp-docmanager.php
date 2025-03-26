<?php
/*
Plugin Name: Kaushik Sannidhi's Documentation Manager
Description: A comprehensive documentation management system for WordPress
Version: 1.0.0
Author: Kaushik Sannidhi
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/documentation-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/documentation-meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/documentation-taxonomies.php';
require_once plugin_dir_path(__FILE__) . 'includes/documentation-search.php';
require_once plugin_dir_path(__FILE__) . 'includes/documentation-shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/documentation-settings.php';

class KaushikSannidhiDocsManager {
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
    }

    public function init() {
        DocumentationPostType::register_post_type();
        DocumentationTaxonomies::register_taxonomies();
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_style('ks-docs-admin-style', plugin_dir_url(__FILE__) . 'assets/css/admin-style.css');
    }

    public function enqueue_frontend_scripts() {
        wp_enqueue_style('ks-docs-frontend-style', plugin_dir_url(__FILE__) . 'assets/css/frontend-style.css');
        wp_enqueue_script('ks-docs-search', plugin_dir_url(__FILE__) . 'assets/js/search.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script('ks-docs-search', 'ksDocsSearch', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    public static function activate() {
        DocumentationPostType::register_post_type();
        DocumentationTaxonomies::register_taxonomies();
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}

register_activation_hook(__FILE__, array('KaushikSannidhiDocsManager', 'activate'));
register_deactivation_hook(__FILE__, array('KaushikSannidhiDocsManager', 'deactivate'));

$ks_docs_manager = new KaushikSannidhiDocsManager();
