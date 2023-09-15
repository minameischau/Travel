

<?php

class CreateTourManagement {
    protected $post_type = 'tour-management';

    public function __construct(){
        // init register post type
        add_action('init', [$this, 'func_tour_management']);
        add_action('init', [$this, 'tour_tag_taxonomy']);
        add_action('init', [$this, 'tour_cate_taxonomy']);
        add_action('admin_menu', [$this, 'func_submenu']);
        //placeholder
        add_filter('enter_title_here', [$this, 'custom_title_placeholder'], 10, 2);
        add_filter('wp_insert_post_data', [$this, 'check_title_and_set_draft'], 10, 2);
        // require_once TOUR_MANAGEMENT_PATH . '/features/class-replace-author-box.php';
        require_once TOUR_MANAGEMENT_PATH . '/features/class-tour-management-metabox.php';
    }

    function check_title_and_set_draft($data, $postarr) {
        // Kiểm tra xem trường 'post_title' có giá trị hay không
        if (empty($data['post_title'])) {
            // Đặt trạng thái 'draft' cho bài viết mới
            $data['post_status'] = 'draft';
        }
        return $data;
    }

    function func_tour_management() {
        $labels = array(
            'name' => __('Tour List'),
            'singular_name' => __('Tour'),
            'menu_name' => __('Tours'),
            'add_new' => __('Add New Tour'),
            'add_new_item' => __('New Tour'),
            'edit' => __('Edit Tour'),
            'edit_item' => __('Edit Tour'),
            'search_items' => __('Search Tour'),
            'not_found' => __('Not found Tour'),
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
            'menu_icon' => 'dashicons-palmtree',
            'supports' => array('title', 'thumbnail'),
        );

        register_post_type($this->post_type, $args);
    }

    function tour_tag_taxonomy() {
        $taxonomy_labels = array(
            'name' => 'Tour Tags',
            'singular_name' => 'Tour Tag',
            // Các nhãn khác cho taxonomy "tour-tag"
        );

        $taxonomy_args = array(
            'labels' => $taxonomy_labels,
            'public' => true,
            'hierarchical' => false,
            // Các thiết lập khác cho taxonomy "tour-tag"
        );

        register_taxonomy('tour-tag', $this->post_type, $taxonomy_args);
    }

    
    function tour_cate_taxonomy() {
        $taxonomy_cate_labels = array(
            'name' => 'Tour cate',
            'singular_name' => 'Tour cate',
            // Các nhãn khác cho taxonomy "tour-tag"
        );

        $taxonomy_args = array(
            'labels' => $taxonomy_cate_labels,
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'tourcate'),
            // Các thiết lập khác cho taxonomy "tour-tag"
        );

        register_taxonomy('tour-cate', $this->post_type, $taxonomy_args);
    }

    function func_submenu() {
        add_menu_page(
            'Manage Tour', //Tieu de trang
            'Tour Management',// 'Ten menu',
            'manage_options',
            'toursubmenu', //Slug menu cha
            [$this, 'toursubmenu_callback'], //Xu ly trang chu
            'dashicons-palmtree',
            30 //Vi tri hien thi
        );
        // Thêm submenu cho menu chính
        add_submenu_page(
            'toursubmenu', // Slug của menu cha
            'Manage Tour', // Tiêu đề của submenu
            'Tour', // Tên của submenu
            'manage_options', // Quyền truy cập để truy cập submenu
            'edit.php?post_type=tour-management' // Slug của trang tương ứng với submenu
        );
        // Thêm submenu cho menu chính
        add_submenu_page(
            'toursubmenu', // Slug của menu cha
            'Manage Member', // Tiêu đề của submenu
            'Member', // Tên của submenu
            'manage_options', // Quyền truy cập để truy cập submenu
            'edit.php?post_type=member-management' // Slug của trang tương ứng với submenu
        );
    }
    
    function toursubmenu_callback() {
        // Hiển thị nội dung của menu chính ở đây
        echo '<h1>This is a custom menu page</h1>';
        echo '<p>This is the content of the custom menu page.</p>';
    }

    function custom_title_placeholder($title_placeholder, $post) {
        // Kiểm tra xem loại post có phải là "tour" hay không
        if ($post->post_type === 'tour-management') {
            $title_placeholder = 'Em change title duoc oi';
        }
        return $title_placeholder;
    }
    
}