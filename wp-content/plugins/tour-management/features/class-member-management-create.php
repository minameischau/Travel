<?php

class CreateMemberManagement {
    protected $post_type = 'member-management';

    public function __construct(){
        // init register post type
        add_action('init', [$this, 'func_member_management']);
        add_action('init', [$this, 'member_cate_taxonomy']);

        add_filter('enter_title_here', [$this, 'custom_title_placeholder'], 10, 2);
        
        require_once TOUR_MANAGEMENT_PATH . '/features/class-member-management-metabox.php';
        
    }

    function func_member_management() {
        $labels = array(
            'name' => __('Member List'),
            'singular_name' => __('Member'),
            'menu_name' => __('Members'),
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
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => array('slug' => 'service'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-buddicons-buddypress-logo',
            'supports' => array('title', 'thumbnail'),
        );

        register_post_type($this->post_type, $args);
    }
    
    function custom_title_placeholder($title_placeholder, $post) {
        // Kiểm tra xem loại post có phải là "tour" hay không
        if ($post->post_type === 'member-management') {
            $title_placeholder = 'Em change title duoc oi';
        }
        return $title_placeholder;
    }

    function member_cate_taxonomy() {
        $taxonomy_cate_labels = array(
            'name' => 'Member cate',
            'singular_name' => 'Member cate',
            // Các nhãn khác cho taxonomy "tour-tag"
        );

        $taxonomy_args = array(
            'labels' => $taxonomy_cate_labels,
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'memcate'),
            // Các thiết lập khác cho taxonomy "tour-tag"
        );

        register_taxonomy('mem-cate', $this->post_type, $taxonomy_args);
    }
}