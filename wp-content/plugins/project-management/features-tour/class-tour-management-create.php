<?php
require_once(ABSPATH . 'wp-includes/class-phpass.php');

use function PHPSTORM_META\type;

class CreateTourManagement
{
    protected $post_type = 'tour-management';

    public function __construct()
    {
        // init register post type
        add_action('init', [$this, 'func_tour_management']);
        add_action('init', [$this, 'tour_cate_taxonomy']);
        add_action('init', [$this, 'tour_tag_taxonomy']);
        // add_action('admin_menu', [$this, 'func_submenu']);
        add_action('abc', [$this, 'text']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_media_library']);
        add_action("wp_ajax_thongbao", [$this, 'save_tb_callback']);
        add_action("wp_ajax_nopriv_thongbao", [$this, 'save_tb_callback']);

        add_shortcode('my_shortcode', [$this, 'my_custom_shortcode']);
        add_shortcode('list_tour_cate', [$this, 'list_cate_tour']);
        add_shortcode('book_now', [$this, 'book_now']);
        add_shortcode('all-tours', [$this, 'all_tours_shortcode']);
        add_shortcode('book_now', [$this, 'func_book_now']);

        add_action("wp_ajax_signup", [$this, 'signup_callback']);
        add_action("wp_ajax_nopriv_signup", [$this, 'signup_callback']);
        add_action("wp_ajax_save_member_in4", [$this, 'save_member_in4_callback']);
        add_action("wp_ajax_nopriv_save_member_in4", [$this, 'save_member_in4_callback']);
        add_action("wp_ajax_save_cusomter_theme", [$this, 'save_cusomter_theme_callback']);
        add_action("wp_ajax_nopriv_save_cusomter_theme", [$this, 'save_cusomter_theme_callback']);
        add_action("wp_ajax_signin", [$this, 'signin_callback']);
        add_action("wp_ajax_nopriv_signin", [$this, 'signin_callback']);
        add_action("wp_ajax_edit_customer_theme", [$this, 'edit_customer_theme_callback']);
        add_action("wp_ajax_nopriv_edit_customer_theme", [$this, 'edit_customer_theme_callback']);
        add_action("wp_ajax_del_customer_theme", [$this, 'del_customer_theme_callback']);
        add_action("wp_ajax_nopriv_del_customer_theme", [$this, 'del_customer_theme_callback']);
        add_action("wp_ajax_cancel_order", [$this, 'cancel_order_callback']);
        add_action("wp_ajax_nopriv_cancel_order", [$this, 'cancel_order_callback']);
        add_action("wp_ajax_signout", [$this, 'signout_callback']);
        add_action("wp_ajax_nopriv_signout", [$this, 'signout_callback']);
        add_action("wp_ajax_search_tours", [$this, 'search_tours_callback']);
        add_action("wp_ajax_nopriv_search_tours", [$this, 'search_tours_callback']);

        add_action("wp_ajax_save_attachment", [$this, 'save_attachment_callback']);
        add_action("wp_ajax_nopriv_save_attachment", [$this, 'save_attachment_callback']);
        add_action('manage_tour-management_posts_custom_column', [$this, 'custom_render_tour_management_columns'], 4, 2);
        //Hành động trash
        // add_action('before_delete_post', [$this, 'prevent_trash_tour']);
        // add_action('admin_notices', [$this, 'show_trash_tour_notice']);

        // add_filter('wp_trash_post', [$this, 'prevent_trash_tour'] , 10, 1);
        add_filter('manage_tour-management_posts_columns', [$this, 'custom_add_tour_management_columns']);
        add_filter('enter_title_here', [$this, 'custom_title_placeholder'], 10, 2);
        add_filter('mkd', [$this, 'mkd_callback'], 10, 2);
        add_filter('wp_insert_post_data', [$this, 'check_title_and_set_draft'], 10, 2);

        require_once PROJECT_MANAGEMENT_PATH . '/features-tour/class-tour-management-metabox.php';
    }

    
    function func_tour_management()
    {
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
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'tour'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-palmtree',
            'supports' => array('title', 'author', 'thumbnail', 'editor', 'comments'),
            // 'show_in_rest' => true,
        );
        // echo($this->post_type);
        // die();
        register_post_type($this->post_type, $args);
        // register_post_type('demo', $args);
    }
    function tour_tag_taxonomy()
    {
        $taxonomy_labels = array(
            'name' => 'Tour Tags',
            'singular_name' => 'Tour Tag',
            // Các nhãn khác cho taxonomy "tour-tag"
        );

        $taxonomy_args = array(
            'labels' => $taxonomy_labels,
            'public' => true,
            'hierarchical' => false,
            'show_admin_column' => true,
            // Các thiết lập khác cho taxonomy "tour-tag"
        );

        register_taxonomy('tour-tag', $this->post_type, $taxonomy_args);
    }
    
    function tour_cate_taxonomy()
    {
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
            'show_admin_column' => true,
            'show_in_rest' => true,
            // Các thiết lập khác cho taxonomy "tour-tag"
        );

        register_taxonomy('tour-cate', $this->post_type, $taxonomy_args);
    }

    function search_tours_callback()
    {
        $content = $_POST['content'];
        $args = array(
            'post_type' => 'tour-management', // Loại bài viết là "tour"
            'posts_per_page' => -1, // Lấy tất cả các bài viết
            's' => $content, // Từ khóa tìm kiếm là "aba"
            // 'meta_query' => array(
            //     'relation' => 'OR',
            //     array(
            //         'key' => '_place_end',
            //         'compare' => 'LIKE',
            //         'value' => $content,
            //     ),

            // ),
        );
        $tours = get_posts($args);
        foreach ($tours as $v) {
            $v->post_image_url =  get_the_post_thumbnail_url($v->ID);
            $v->post_link = get_permalink($v->ID);
            $v->dep_date = date('d/m/Y', strtotime(get_post_meta($v->ID, '_dep_date', true)));
            $v->post_name = $v->post_name;
            $v->slot_remain = get_post_meta($v->ID, '_tour_slot_remain', true);
            $v->price = get_post_meta($v->ID, '_tour_price', true);
            $v->day_total = get_post_meta($v->ID, '_day_total', true);
            $v->place_end = get_post_meta($v->ID, '_place_end', true);
            $v->place_start = get_post_meta($v->ID, '_place_start', true);
        }
        wp_send_json_success($tours);
        die;
    }

    function cancel_order_callback()
    {
        $order_id = $_POST['order_id'];
        $order_quantity = (int)$_POST['order_quantity'];
        $tour_id = get_post_meta($order_id, '_order_tourID', true);
        $tour_slot_remain = (int)get_post_meta($tour_id, '_tour_slot_remain', true);
        $tour_slot_remain_update = $order_quantity + $tour_slot_remain;
        update_post_meta($tour_id, '_tour_slot_remain', $tour_slot_remain_update);
        // wp_send_json_success($order_quantity);
        // die;
        update_post_meta($order_id, '_order_status', '-1');
        wp_send_json_success(true);
        die;
    }

    function signout_callback()
    {
        wp_logout();
        wp_send_json_success(true);
        die;
    }

    function save_member_in4_callback()
    {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $customer_ID =  $_POST['customer_ID'];
        $order_id = $_POST['order_id'];
        $list = [
            'name' => $name,
            'phone' => $phone
        ];
        // wp_send_json_success($customer_ID);

        // die;
        $list_customer = (array)get_post_meta($order_id, '_list_customer', true);
        $len = count($list_customer); //7 
        if ($customer_ID <= $len && $customer_ID != '') {
            $list_customer[$customer_ID]['name'] = $name; 
            $list_customer[$customer_ID]['phone'] = $phone; 
            // wp_send_json_success($list_customer); //Ca mang dung
            delete_post_meta($order_id, '_list_customer');
            update_post_meta($order_id, '_list_customer', $list_customer);
            
        } else {
            array_push($list_customer, $list);
            update_post_meta($order_id, '_list_customer', $list_customer);
        }
        wp_send_json_success($customer_ID);

        die;
    }

    function edit_customer_theme_callback()
    {
        $customer_ID =  $_POST['customer_ID'];
        $order_ID =  $_POST['order_id'];
        $list_customer = get_post_meta($order_ID, '_list_customer', true);
        $customer_in4 = $list_customer[$customer_ID];
        $customer_in4['id'] = $customer_ID;
        // array_push($customer_in4, $test);
        wp_send_json_success($customer_in4);
        die;
    }

    function del_customer_theme_callback()
    {
        $customer_ID =  $_POST['customer_ID'];
        $order_ID =  $_POST['order_id'];
        $list_customer = get_post_meta($order_ID, '_list_customer', true);
        unset($list_customer[$customer_ID]);
        $list_customer = array_values($list_customer);
        // wp_send_json_success($list_customer);
        delete_post_meta($order_ID, '_list_customer');
        update_post_meta($order_ID, '_list_customer', $list_customer);
        wp_send_json_success($list_customer);
        // $customer_in4 = $list_customer[$customer_ID];
        // $customer_in4['id']=$customer_ID;
        // array_push($customer_in4, $test);
        die;
    }

    function save_cusomter_theme_callback()
    {
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $name = $_POST['name'];
        $payment = $_POST['payment'];
        $quantity = $_POST['quantity'];
        $tour_ID = $_POST['tourID'];
        $order_name = time();
        $post_data = array(
            'post_title' => $order_name,
            'post_status' => 'publish',
            'post_type' => 'order-management'
        );
        $message = 'true';

        // Thêm bài viết vào bảng wp_posts
        $post_id = wp_insert_post($post_data);
        update_post_meta($post_id, '_order_tourID', $_POST['tourID']);
        update_post_meta($post_id, '_order_status', '0');
        update_post_meta($post_id, '_order_payment_method', $_POST['payment']);
        update_post_meta($post_id, '_order_quantity', $_POST['quantity']);
        $tour_slot_remain_new = (int)$_POST['tour_slot_remain'] - (int)$_POST['quantity'];
        $tour_price = get_post_meta($tour_ID, '_tour_price', true);
        $total = (int)$quantity * (int)$tour_price;
        update_post_meta($tour_ID, '_tour_slot_remain', $tour_slot_remain_new);
        update_post_meta($post_id, '_order_total', $total);
        update_post_meta($post_id, '_order_member_name', $_POST['name']);
        update_post_meta($post_id, '_order_member_email', $_POST['email']);
        update_post_meta($post_id, '_order_member_phone', $_POST['phone']);
        wp_send_json_success($order_name);
        die();
    }

    function all_tours_shortcode()
    {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/all-tours-ui.php';
        return ob_get_clean();
    }
    function func_book_now()
    {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/book-now.php';
        return ob_get_clean();
    }

    function show_date()
    {
        return;
    }

    function book_now()
    {

        return '<button>' . get_the_ID() . 'Book now</button>';
    }

    function enqueue_media_library()
    {
        wp_enqueue_media();
    }

    function my_custom_shortcode()
    {
        return '<p>Helooooo what</p>';
    }


    function list_cate_tour()
    {
        $taxonomy = 'tour-cate';  // Tên taxonomy
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'fields' => 'ids',  // Chỉ lấy ID của term
        ));

        $list_tour_cate = '';

        // Lặp qua danh sách ID term
        foreach ($terms as $term_id) {
            $term = get_term($term_id); // Lấy thông tin của term

            if ($term && !is_wp_error($term)) {
                $term_name = $term->name; // Lấy tên của term
                // echo $term_name . '<br>';
                $term_slug = $term->slug;
                // $test = get_term_by
                // die(var_dump($term));
                $list_tour_cate = $list_tour_cate . '<a href="/wordpress/tourcate/' . $term_slug . '" class="text-dark fs-6 fw-bold ms-3 lh-lg" style="text-decoration:none;">' . $term_name . '</a> <br>';
            }
        }
        return $list_tour_cate;
    }

    function save_tb_callback()
    {
        $movie_name = (isset($_POST['movie_name'])) ? esc_attr($_POST['movie_name']) : "";
        wp_send_json_success($movie_name);
        die(); //bắt buộc phải có khi kết thúc
    }

    function save_attachment_callback()
    {
        if (isset($_POST['attachment_url']) && isset($_POST['tour_ID'])) {
            $attachment_url = $_POST['attachment_url'];
            $tour_ID = $_POST['tour_ID'];
            $test = array();
            // Lưu các giá trị trong mảng vào CSDL
            foreach ($attachment_url as $url) {
                // $test = $test . $url;
                array_push($test, $url);

                // Thực hiện các thao tác lưu trong CSDL tại đây
                // Ví dụ: lưu vào bảng wp_posts và wp_postmeta
            }
            update_post_meta($tour_ID, '_attachment_url', $test);

            // wp_send_json_success($test);

            // Phản hồi Ajax thành công
        }
    }

    function signup_callback()
    {
        $message = '';
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user_query = new WP_User_Query(
            array(
                'search' => $email,
                'search_columns' => array('user_email'),
            )
        );
        $user = $user_query->get_results();
        if (count($user) == 0) {
            $user_data = array(
                'user_login' => $email,
                'user_email' => $email,
                'display_name' => $email,
                'user_pass' => $password,
            );
            $user_id = wp_insert_user($user_data);
            $message = 'true';
        } else {
            $message = 'Already';
        }

        wp_send_json_success($message);
        die();
    }

    function signin_callback()
    {
        // global $wpdb;
        // $check_user="select user_pass from wp_users WHERE user_email='$email'";  
        // $wp_hasher = new PasswordHash(8, TRUE);
        // $password_hashed = $wpdb->get_var($check_user);

        // if($wp_hasher->CheckPassword($password, $password_hashed)) {
        //     $user_id_query="select ID from wp_users WHERE user_email='$email'";  
        //     $user_id=$wpdb->get_var($user_id_query);  
        //     wp_set_auth_cookie($user_id);
        //     do_action('wp_login', $user->user_login);
        //     $message = 'true';
        // } else {
        //     $message = "false";
        // }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user_query = new WP_User_Query(
            array(
                'search' => $email,
                'search_columns' => array('user_email')
            ),
        );
        $users = $user_query->get_results();
        $user = $users[0];
        $user_id = $user->ID;
        $password_hashed = get_userdata($user_id)->user_pass;
        $wp_hasher = new PasswordHash(8, TRUE);
        if ($wp_hasher->CheckPassword($password, $password_hashed)) {
            //hander set current user
            $curr_user =  new WP_User($user_id, $user->user_login);
            // print_r($curr_user); // This trace is showed below.
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login);
            // wp_logout();
            $message =  "true";
        } else {
            $message =  "false";
        }
        wp_send_json_success($message);
        die();
    }

    function text()
    {
        echo 'Footer edited';
    }

    function mkd_callback()
    {
        return 'custom filter footer';
    }

    function check_title_and_set_draft($data)
    {
        // Kiểm tra xem trường 'post_title' có giá trị hay không
        if (empty($data['post_title'])) {
            // Đặt trạng thái 'draft' cho bài viết mới
            $data['post_status'] = 'draft';
        }
        return $data;
    }

    function custom_title_placeholder()
    {
        // Kiểm tra xem loại post có phải là "tour" hay không
        $title_placeholder = '';
        $post = get_current_screen();
        if ($post->post_type === 'tour-management') {
            $title_placeholder = 'Tour name';
        } else if ($post->post_type === 'member') {
            $title_placeholder = 'Member mới';
        }
        return $title_placeholder;
    }
    function custom_add_tour_management_columns($columns)
    {
        $columns['tour_slot_remain'] = 'Slot remain';
        $columns['tour_thumbnail'] = 'Thumbnail';
        $columns['tour_departure'] = 'Departure day';
        return $columns;
    }
    // Hiển thị giá trị của cột "Mã tour"
    function custom_render_tour_management_columns($column, $post_id)
    {
        if ($column === 'tour_slot_remain') {
            // Lấy giá trị của meta 'tour_code' cho tour
            $tour_slot_remain = get_post_meta($post_id, '_tour_slot_remain', true);
            $tour_slot = get_post_meta($post_id, '_tour_slot', true);
            //Số lượng hành khách đã đặt ===> $tour_slot - $tour_slot_remain;
            echo $tour_slot_remain;
        }
        if ($column === 'tour_thumbnail') {
            // Lấy giá trị của meta 'tour_code' cho tour
            echo get_the_post_thumbnail($post_id, 'thumbnail');
        }
        if ($column === 'tour_departure') {
            $tour_departure = get_post_meta($post_id, '_dep_date', true);
            // die(var_dump($tour_departure));
            echo $tour_departure;
            // die();
            // return $tour_departure; ========> NO return
        }
    }
}
