<?php

class CreateOrderManagement {
    protected $post_type = 'order-management';

    public function __construct(){
        // init register post type
        add_action('init', [$this, 'func_order_management']);
        // add_action('admin_init', [$this, 'change_order_status'] );
        add_action('manage_order-management_posts_custom_column', [$this, 'custom_render_order_management_columns'], 4, 2);
        add_action("wp_ajax_save_customer", [$this, 'save_customer_callback']);
        add_action("wp_ajax_nopriv_save_customer", [$this, 'save_customer_callback']);
        add_action("wp_ajax_edit_customer", [$this, 'edit_customer_callback']);
        add_action("wp_ajax_nopriv_edit_customer", [$this, 'edit_customer_callback']);
        add_action("wp_ajax_del_customer", [$this, 'del_customer_callback']);
        add_action("wp_ajax_nopriv_del_customer", [$this, 'del_customer_callback']);
        // add_action("wp_ajax_publish_ord", [$this, 'publish_ord_callback']);
        // add_action("wp_ajax_nopriv_publish_ord", [$this, 'publish_ord_callback']);
        // add_action('wp_insert_post', [$this, 'change_order_status'], 10, 3);
        
        // add_filter('default_post_status', [$this, 'set_default_post_status'], 10, 2);
        // add_filter('wp_insert_post_data', 'set_order_status_pending', 10, 2);
        add_filter('manage_order-management_posts_columns', [$this, 'custom_add_order_management_columns' ]);
        add_filter('enter_title_here', [$this, 'custom_title_placeholder'], 10, 2);
        // add_filter('wp_insert_post_data', [$this, 'set_order_status_pending'], 10, 2 );
        require_once PROJECT_MANAGEMENT_PATH . '/features-order/class-order-management-metabox.php';
        
    }

    

    // function set_default_post_status($post_status, $post_type) {
        // Chỉ áp dụng cho post type là 'post'
        
        // var_dump($post_status);
        //     die;
    //     if ($post_type == 'order-management') {
    //         return 'pending';
    //     }
    //     return $post_status;
    // }
    
    function set_default_post_status( $status, $post_type ) {
        var_dump(get_current_screen());
        die;
        if ( $post_type === 'order-management' && get_current_screen()->action === 'add' && ! isset( $_POST['post_status'] ) ) {
            return 'pending';
        }
        return $status;
    }

    // Hàm sẽ được gọi trước khi bài viết được lưu vào CSDL
    function set_order_status_pending($data, $postarr) {
    //     $_POST['post_status'] = 'pending';
        // var_dump($_GET);
        // var_dump($_GET['action']);
        // var_dump($_POST);
        // var_dump($data['post_status']);
        echo '<pre>';
        var_dump($postarr);
        // echo !isset($_POST['action']);
        echo '</pre>';
        echo '<pre>';
        // var_dump($postarr['post_status']== 'publish');
        var_dump($data);
        // echo !isset($_POST['action']);
        echo '</pre>';
        die;

        // // die;
        // // Kiểm tra nếu post type là "order" và trạng thái là "publish"
        // if ($postarr['post_type'] == 'order-management' && $data['post_status'] == 'publish' && $postarr['action'] == 'editpost') {
        //     // Đặt trạng thái thành "pending"
        //     $data['post_status'] = 'publish';
        //     // die;
        // } elseif ($postarr['post_type'] == 'order-management' && $data['post_status'] == 'publish') {
        //     $data['post_status'] = 'pending';
        // }
        // return $data;
        // if ( $data['post_status'] == 'publish') { 
            // if (!isset($_POST['action'])) {
                
        // $data['post_status'] = 'auto-draft';
        // if ($_POST['action'] == 'editpost' && $data['post_status'] == 'publish') {
            // $data['post_status'] = 'pending';
        // }
            // }
            // die;
        // } else {
        //     $data['post_status'] = 'pending';
        // }
        // return $data;

        // if ( $post_data['post_status'] == 'auto-draft' ) { // Kiểm tra xem đây có phải là bài viết mới không
        //     $post_data['post_status'] = 'pending'; // Đặt trạng thái là "pending"
        // }
        // return $post_data;

        // if ( empty( $data['post_content'] ) && $data['post_status'] == 'pending' ) {
        //     $data['post_status'] = 'auto-draft';
        // }
        // return $data;


        if ($postarr['post_status']== 'publish') { // Kiểm tra nếu không có ID bài viết (tức là bài viết mới)
            $data['post_status'] = 'pending'; // Đặt trạng thái mặc định là "pending"
        }
        return $data;
    }

    function save_customer_callback(){
        $name =  $_POST['name'];
        $phone =  $_POST['phone'];
        $customer_ID =  $_POST['customer_ID'];
        $order_ID =  $_POST['order_ID'];
        $list = [
            'name' => $name,
            'phone' => $phone
        ];
        $list_customer = (array)get_post_meta($order_ID, '_list_customer', true);
        // $test = array();
        // array_push($test, $list_customer);
        $len = count($list_customer); //7 
        // var_dump($customer_ID);
        if ($customer_ID <= $len && $customer_ID != '') {
            $list_customer[$customer_ID]['name'] = $name; 
            $list_customer[$customer_ID]['phone'] = $phone; 
            // wp_send_json_success($list_customer); //Ca mang dung
            delete_post_meta($order_ID, '_list_customer');
            update_post_meta($order_ID, '_list_customer', $list_customer);
            
        } else {
            array_push($list_customer, $list);
            update_post_meta($order_ID, '_list_customer', $list_customer);
        }
        // var_dump($list_customer);
        // die($list_customer);
        // add_post_meta($order_ID, '_list_customer', $list);
        // $list = $list + $list_customer;
        // wp_send_json_success($name);
        wp_send_json_success($customer_ID);
        
        die;
    }

    // function publish_ord_callback(){
    //     $order_ID = (int)$_POST['order_ID'];
    //     $state = $_POST['state'];
        
    //     if ($state == 'edit') {
    //        $post_data = array(
    //             'ID' => $order_ID,  // ID của bài viết
    //             'post_status' => 'pending',  // Tiêu đề mới
    //         ); 
    //         // $result = 455454;
    //     } else {
    //         $post_data = array(
    //             'ID' => $order_ID,  // ID của bài viết
    //             'post_status' => 'pending',  // Tiêu đề mới
    //         ); 
    //         // $result = 00000;

    //     }
    //     $result = wp_update_post($post_data);
        
    //     // $order_ID =  (int)$_POST['order_ID'];
    //     // $post_data = array(
    //     //     'ID' => $order_ID,  // ID của bài viết
    //     //     'post_title' => 'publish',  // Tiêu đề mới
    //     // );
    //     // $list_customer = get_post_meta($order_ID, '_list_customer', true);
    //     // $customer_in4 = $list_customer[$customer_ID];
    //     // $customer_in4['id']=$customer_ID;
    //     // array_push($customer_in4, $test);
    //     // wp_update_post($post_data);
    //     wp_send_json_success($state);
    //     die;
    // }

    function edit_customer_callback(){
        $customer_ID =  $_POST['customer_ID'];
        $order_ID =  $_POST['order_ID'];
        $list_customer = get_post_meta($order_ID, '_list_customer', true);
        $customer_in4 = $list_customer[$customer_ID];
        $customer_in4['id']=$customer_ID;
        // array_push($customer_in4, $test);
        wp_send_json_success($customer_in4);
        die;
    }

    function del_customer_callback(){
        $customer_ID =  $_POST['customer_ID'];
        $order_ID =  $_POST['order_ID'];
        $list_customer = get_post_meta($order_ID, '_list_customer', true);
        unset($list_customer[$customer_ID]);
        $list_customer = array_values($list_customer);
        // wp_send_json_success($list_customer);
        delete_post_meta($order_ID, '_list_customer');
        update_post_meta($order_ID, '_list_customer', $list_customer);

        // $customer_in4 = $list_customer[$customer_ID];
        // $customer_in4['id']=$customer_ID;
        // array_push($customer_in4, $test);
        die;
    }

    function custom_add_order_management_columns($columns) {
        $columns['member_tour'] = 'Tour';
        return $columns;
    }

    // Hiển thị giá trị của cột "Mã tour"
    function custom_render_order_management_columns($column, $post_id) {
        if ($column === 'member_tour') {
            // Lấy giá trị của meta 'tour_code' cho tour
            $tourID = get_post_meta($post_id, '_order_tourID', true);
            $tour_name = get_the_title($tourID);
            //Số lượng hành khách đã đặt ===> $tour_slot - $member_name;
            echo $tour_name;
        }
    }

    function func_order_management() {
        $labels = array(
            'name' => __('Order List'),
            'singular_name' => __('Order'),
            'menu_name' => __('Orders'),
            'add_new' => __('Add New Order'),
            'add_new_item' => __('New Order'),
            'edit' => __('Edit Order'),
            'edit_item' => __('Edit Order'),
            'search_items' => __('Search Order'),
            'not_found' => __('Not found Order'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'order'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-palmtree',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,
        );
        register_post_type($this->post_type, $args);
    }

    function custom_title_placeholder($title_placeholder, $post) {
        // Kiểm tra xem loại post có phải là "tour" hay không
        if ($post->post_type === 'order-management') {
            $title_placeholder = 'Order name';
        }
        return $title_placeholder;
    }
}