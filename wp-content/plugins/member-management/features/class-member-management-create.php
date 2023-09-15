<?php

class CreateMemberManagement {
    protected $post_type = 'member-management-plugin';

    public function __construct(){
        // init register post type
        add_action('init', [$this, 'func_member_management']);

        require_once TOUR_MANAGEMENT_PATH . '/features/class-member-management-metabox.php';

    }

    function func_member_management() {
        $labels = array(
            'name' => __('Member List'),
            'singular_name' => __('Member'),
            'menu_name' => __('Members Plugin'),
            'add_new' => __('Add New Member'),
            'add_new_item' => __('New Member'),
            'edit' => __('Edit Member'),
            'edit_item' => __('Edit Member'),
            'search_items' => __('Search Member'),
            'not_found' => __('Not found Member'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'service'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'thumbnail'),
        );

        register_post_type($this->post_type, $args);
    }
}