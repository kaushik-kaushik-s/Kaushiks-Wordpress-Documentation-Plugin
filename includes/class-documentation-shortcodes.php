<?php
defined('ABSPATH') or die('No script kiddies please!');

class KaushikSannidhi_Documentation_Shortcodes {
    public function __construct() {
        add_shortcode('documentation_list', [$this, 'documentation_list_shortcode']);
        add_shortcode('documentation_categories', [$this, 'documentation_categories_shortcode']);
    }

    public function documentation_list_shortcode($atts) {
        $atts = shortcode_atts([
            'category' => '',
            'posts_per_page' => 10,
            'orderby' => 'title',
            'order' => 'ASC'
        ], $atts);

        $args = [
            'post_type' => 'documentation',
            'posts_per_page' => $atts['posts_per_page'],
            'orderby' => $atts['orderby'],
            'order' => $atts['order']
        ];

        if (!empty($atts['category'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'documentation_category',
                    'field' => 'slug',
                    'terms' => $atts['category']
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();
        if ($query->have_posts()) {
            echo '<div class="documentation-list">';
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="documentation-item">';
                echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                echo '<div class="documentation-excerpt">' . get_the_excerpt() . '</div>';
                echo '</div>';
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No documentation found.</p>';
        }

        return ob_get_clean();
    }

    public function documentation_categories_shortcode() {
        $categories = get_terms([
            'taxonomy' => 'documentation_category',
            'hide_empty' => true,
        ]);

        ob_start();
        if (!empty($categories)) {
            echo '<div class="documentation-categories">';
            echo '<h3>Documentation Categories</h3>';
            echo '<ul>';
            foreach ($categories as $category) {
                echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
            }
            echo '</ul>';
            echo '</div>';
        }

        return ob_get_clean();
    }
}