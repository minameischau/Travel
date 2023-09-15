<?php

class CreateOrderManagementMetaBox extends CreateOrderManagement {

    public function __construct(){
        add_action('admin_head', [$this, 'mark_new_post'] );
        add_action('add_meta_boxes', [$this, 'custom_order_metabox']);
        add_action('save_post', [$this, 'save_custom_order_metabox'], 20);
        add_action('add_meta_boxes', [$this, 'custom_member_order_metabox']);
        add_action('save_post', [$this, 'save_custom_member_order_metabox'], 20);
        add_action('save_post', [$this, 'save_post_status_2'], 20);
    }
    /**************************************************
     * Start Customize meta box project information
     **************************************************/
    function custom_order_metabox()
    {
        add_meta_box(
            // ID của metabox, phải là duy nhất
            'custom_order_metabox',
            // Tiêu đề của metabox
            'Order infomation',
            // Callback function để hiển thị nội dung metabox
            [$this, 'custom_order_metabox_callback'],
            // Tên của custom post type mà bạn muốn thêm metabox vào
            $this->post_type,
            // Vị trí của metabox: normal (bên cạnh editor), side (ở bên phải) hoặc advanced (ở dưới editor)
            'normal',
            // Ưu tiên hiển thị của metabox (high, core hoặc default)
            'high'
        );
    }

    function custom_order_metabox_callback($post)
    {
        require_once PROJECT_MANAGEMENT_PATH . 'inc/metabox-order-information-ui.php';
    }

    function save_custom_order_metabox ($post_id) {
        if (isset($_POST['order_tourID'])) {
            update_post_meta($post_id, '_order_tourID', sanitize_text_field($_POST['order_tourID']));
        }
        if (isset($_POST['order_status'])) {
            update_post_meta($post_id, '_order_status', sanitize_text_field($_POST['order_status']));
        }
        if (isset($_POST['order_payment_method'])) {
            update_post_meta($post_id, '_order_payment_method', sanitize_text_field($_POST['order_payment_method']));
        }
        if (isset($_POST['order_quantity'])) {
            update_post_meta($post_id, '_order_quantity', sanitize_text_field($_POST['order_quantity']));
        }          
        $order_tourID = get_post_meta($post_id, '_order_tourID', true);
        
        if (isset($_POST['order_tourID']) && isset($_POST['order_quantity'])) {
            $tour_slot_remain_new = (int)$_POST['tour_slot_remain'] - (int)$_POST['order_quantity'];
            // echo '<pre>';
            // print_r($tour_slot_remain);
            // echo '</pre>'; 
            // echo ($_POST['tour_slot_remain']);
            // die;
            // die;
            $order_book = $_POST['order_quantity'];
            $tour_price = get_post_meta($order_tourID, '_tour_price', true);
            $total = (int)$order_book*(int)$tour_price;
            // echo $order_book;
            // echo $tour_price;
            // echo $total;
            // var_dump($order_book);
            // var_dump($tour_price);
            // var_dump($total);
            // die();
        }
        if (isset($_POST['tour_slot_remain'])) {
            update_post_meta($order_tourID, '_tour_slot_remain', $tour_slot_remain_new);
            update_post_meta($post_id, '_order_total', $total);
        }
    }

    function custom_member_order_metabox() {
        add_meta_box(
            // ID của metabox, phải là duy nhất
            'custom_member_order_metabox',
            // Tiêu đề của metabox
            'Customer infomation',
            // Callback function để hiển thị nội dung metabox
            [$this, 'custom_member_order_metabox_callback'],
            // Tên của custom post type mà bạn muốn thêm metabox vào
            $this->post_type,
            // Vị trí của metabox: normal (bên cạnh editor), side (ở bên phải) hoặc advanced (ở dưới editor)
            'normal',
            // Ưu tiên hiển thị của metabox (high, core hoặc default)
            'high'
        );
    }
    function custom_member_order_metabox_callback($post)
    {
        require_once PROJECT_MANAGEMENT_PATH . 'inc/metabox-member-order-information-ui.php';
    }

    function save_post_status_2($post_id) {
        $list_customer = (array)get_post_meta($post_id, '_list_customer', true);
        $order_quantity = (int)get_post_meta($post_id, '_order_quantity', true);
        global $wpdb;
        $table_name = $wpdb->prefix . 'posts'; // Tên bảng wp_posts với tiền tố
        if (!empty($_POST['action'])) {
            // echo '<pre>';
            // var_dump($order_quantity);
            // var_dump($_POST);
            // var_dump(count($list_customer));
            // var_dump($order_quantity == count($list_customer)-1);
            // echo '</pre>';
            // die;

            if ($order_quantity != 0 && $order_quantity == count($list_customer)-1) {
                $query = $wpdb->prepare("UPDATE $table_name SET post_status = %s WHERE ID = %d", 'publish', $post_id);
                $result = $wpdb->query($query);
            } 
            if ($order_quantity != 0 && $order_quantity != count($list_customer)-1)
            {
                $query = $wpdb->prepare("UPDATE $table_name SET post_status = %s WHERE ID = %d", 'pending', $post_id);
                $result = $wpdb->query($query);
            }

        }
        // die;    
        
    }

    function save_custom_member_order_metabox ($post_id) {
        if (isset($_POST['order_member_name'])) {
            update_post_meta($post_id, '_order_member_name', sanitize_text_field($_POST['order_member_name']));
        }
        if (isset($_POST['order_member_email'])) {
            update_post_meta($post_id, '_order_member_email', sanitize_text_field($_POST['order_member_email']));
        }
        if (isset($_POST['order_member_phone'])) {
            update_post_meta($post_id, '_order_member_phone', sanitize_text_field($_POST['order_member_phone']));
        }
    }
    function save_post_status ($post_id) {
        // Kiểm tra xem có phải là lần đầu tạo bài viết hay không
        // $is_new_post = get_post_meta($post_id, '_is_new_post', true);
        global $pagenow;
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'posts'; // Tên bảng wp_posts với tiền tố
        
        $query = "SELECT ID FROM $table_name ORDER BY ID DESC LIMIT 1";
        $table_length = (int)$wpdb->get_var($query);
        
        // Kiểm tra xem bài viết có trạng thái "pending" hay không
        $post_status = get_post_status($post_id);
        $list_ord_pending = get_posts(array(
            'post_type' => 'order-management',
            'post_status' => 'pending',
            'posts_per_page' => -1, // Lấy tất cả các bài viết
        ));
        $list_ord = get_posts(array(
            'post_type' => 'any',
            'post_status' => 'any',
            // 'posts_per_page' => -1, // Lấy tất cả các bài viết
        ));
        // $test = current_user_can('edit_others_posts');
        // die();
        $postnew = 'post-new.php';
        $previous_page = $_SERVER['HTTP_REFERER']; 
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $trash_id = $_GET['post'];
        } else {
            $action = '';
            $trash_id = '';
        }
        $check = strpos($previous_page, $postnew); // Tra ve FALSE hoac khong co gi
        if ($post_id <= $table_length && !$check && $action != 'trash') {
            // Đặt trạng thái "pending" khi thêm mới bài viết
            // var_dump($test);
            // echo '<pre>';
            // var_dump($list_ord_pending);
            // echo '</pre>';
            // var_dump($_GET);
            // var_dump($post_id);
            // var_dump($post_status);
            // var_dump($table_length);
            // die();
            // wp_update_post(array(
                //     'ID' => $post_id,
                //     'post_status' => 'pending'
                // ));
                // die;
                $query = $wpdb->prepare("UPDATE $table_name SET post_status = %s WHERE ID = %d", 'publish', $post_id);
                $result = $wpdb->query($query);
        } 
        if ($action == 'trash' ) {
            // die($trash_id);
            $query = $wpdb->prepare("UPDATE $table_name SET post_status = %s WHERE ID = %d", 'trash', $trash_id);
            $result = $wpdb->query($query);
        } 
        // else {
        //     // $query = $wpdb->prepare("INSERT $table_name SET post_status = %s WHERE ID = %d", 'publish', $post_id);
        //     // $result = $wpdb->query($query);
            
        //     wp_update_post(array(
        //         'ID' => $post_id,
        //         'post_status' => 'pending'
        //     ));
        // }
        // elseif ($pagenow == 'post.php') {
        //     // Đặt trạng thái "publish" khi chỉnh sửa và nhấn nút "Publish"
        //     $published = isset($_POST['publish']) && $_POST['publish'] !== '';
        //     if ($published) {
        //         wp_update_post(array(
        //             'ID' => $post_id,
        //             'post_status' => 'pending'
        //         ));
        //     }
        // }
    }

    function mark_new_post() {
        // Kiểm tra xem có phải trang tạo bài viết hay không
        global $pagenow;
        // die($pagenow);
        if ($pagenow == 'post-new.php') {
            // Đánh dấu bài viết là "lần đầu tạo"
            echo '<input type="hidden" name="_is_new_post" value="1">';
        }
    }
}
new CreateOrderManagementMetaBox();