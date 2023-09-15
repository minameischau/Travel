<?php

class CreateMemberManagement {
    protected $post_type = 'member-management';

    public function __construct(){
        // init register post type
        add_action('init', [$this, 'func_member_management']); 
        add_action('init', [$this, 'member_cate_taxonomy']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_custom_scripts']);
        add_action('manage_member-management_posts_custom_column', [$this, 'custom_render_member_management_columns'], 4, 2);

        add_filter('manage_member-management_posts_columns', [$this, 'custom_add_member_management_columns' ]);
        add_filter('enter_title_here', [$this, 'custom_title_placeholder'], 10, 2);
        
        require_once PROJECT_MANAGEMENT_PATH . '/features-member/class-member-management-metabox.php';
    }

    function custom_add_member_management_columns($columns) {
        $columns['member_tour'] = 'Tour';
        return $columns;
    }

    // Hiển thị giá trị của cột "Mã tour"
    function custom_render_member_management_columns($column, $post_id) {
        if ($column === 'member_tour') {
            // Lấy giá trị của meta 'tour_code' cho tour
            $member_tourID = get_post_meta($post_id, '_member_tour', true);
            $tour_name = get_the_title($member_tourID);
            //Số lượng hành khách đã đặt ===> $tour_slot - $member_name;
            echo $tour_name;
        }
    }
    function enqueue_custom_scripts() {
        // Thêm thư viện jQuery
        wp_enqueue_script('jquery');
        
        // Thêm thư viện jQuery Validate
        wp_enqueue_script('jquery-validate', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js', array('jquery'), '1.19.5', true);
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
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'member'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-buddicons-buddypress-logo',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,

        );

        // echo($this->post_type);
        register_post_type($this->post_type, $args);
        // die('Vaoooo');
    }

    function custom_title_placeholder($title_placeholder, $post) {
        // Kiểm tra xem loại post có phải là "tour" hay không
        if ($post->post_type === 'member-management') {
            $title_placeholder = 'Member name';
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
            'show_admin_column' => true

            // Các thiết lập khác cho taxonomy "tour-tag"
        );

        register_taxonomy('mem-cate', $this->post_type, $taxonomy_args);
    }
    
}