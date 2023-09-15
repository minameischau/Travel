<?php
/*
Plugin Name: Project Tour Management
Description: Plugin tour management for manage tour, ...
Version: 1.0.0
Author: Chau
Author URI: fb.com/ngocchau.ha1801
License: Giấy phép sử dụng của plugin (ví dụ: GPL2)
*/

if (!defined('PROJECT_MANAGEMENT_PATH')) {
    define('PROJECT_MANAGEMENT_PATH', plugin_dir_path(__FILE__));
}
if (!defined('PROJECT_MANAGEMENT_URL')) {
    define('PROJECT_MANAGEMENT_URL', plugin_dir_url(__FILE__));
}

require_once(PROJECT_MANAGEMENT_PATH . 'features-tour/class-tour-management-create.php');
new CreateTourManagement();

require_once(PROJECT_MANAGEMENT_PATH . 'features-member/class-member-management-create.php');
new CreateMemberManagement();

require_once(PROJECT_MANAGEMENT_PATH . 'features-order/class-order-management-create.php');
new CreateOrderManagement();

require_once(PROJECT_MANAGEMENT_PATH . 'features-user/class-shortcode-custom.php');
new CustomShortCode();


// ===============  SUB MENU ===============  //
add_action('admin_menu', 'func_submenu');
function func_submenu() {
    add_menu_page(
        'Manage Tour', //Tieu de trang
        'Tour Management',// 'Ten menu',
        'manage_options',
        'dashboard', //Slug menu cha
        'toursubmenu_callback', //Xu ly trang chu
        'dashicons-palmtree',
        30 //Vi tri hien thi
    );
    // Thêm submenu cho menu chính
    add_submenu_page(
        'dashboard', // Slug của menu cha
        'Manage Tour', // Tiêu đề của submenu
        'Tour', // Tên của submenu
        'manage_options', // Quyền truy cập để truy cập submenu
        'tour-management', // Slug của trang tương ứng với submenu
        'tour_dashboard'
    );
    // Thêm submenu cho menu chính
    add_submenu_page(
        'dashboard', // Slug của menu cha
        'Manage Member', // Tiêu đề của submenu
        'Member', // Tên của submenu
        'manage_options', // Quyền truy cập để truy cập submenu
        'member-management', // Slug của trang tương ứng với submenu
        'member_dashboard'
    );
    // Thêm submenu cho menu chính
    add_submenu_page(
        'dashboard', // Slug của menu cha
        'Manage Order', // Tiêu đề của submenu
        'Order management', // Tên của submenu
        'manage_options', // Quyền truy cập để truy cập submenu
        'order-management', // Slug của trang tương ứng với submenu
        'order_dashboard'
    );
}
function toursubmenu_callback() {
    // Hiển thị nội dung của menu chính ở đây
    include_once plugin_dir_path(__FILE__) . 'dashboard/main-dashboard.php';

    // $template = ob_get_contents()
}

function tour_dashboard() {
    include_once plugin_dir_path(__FILE__) . 'dashboard/tour-dashboard.php';
}

function member_dashboard() {
    include_once plugin_dir_path(__FILE__) . 'dashboard/member-dashboard.php';
}

function order_dashboard() {
    include_once plugin_dir_path(__FILE__) . 'dashboard/order-dashboard.php';
}

function abc() {
    wp_register_script(
        'abc-ex',
        'http://localhost/wordpress/wp-content/plugins/project-management/blocks/editor.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor')
    );
    register_block_type('project-management/blocks', array(
          'editor_script' => 'abc-ex',
        )
    );
        // die( 'http://localhost/wordpress/wp-content/plugins/blocks/editor.js'); ==> Test URL
}

function abc2() {
    wp_register_script(
        'list-tours',
        'http://localhost/wordpress/wp-content/plugins/project-management/blocks/list-tours.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor')
    );
    register_block_type('project-management/list-tours', array(
          'editor_script' => 'list-tours',
        )
    );
        // die( 'http://localhost/wordpress/wp-content/plugins/blocks/editor.js'); ==> Test URL
}
        
add_action('init', 'abc');
add_action('init', 'abc2');


// function gutenberg_vinasupport_sample_01_register_block() {
//     wp_register_script(
//         'gutenberg-examples-01',
//         'http://localhost/wordpress/wp-content/plugins/project-management/blocks/editor.js',
//         array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' )
//     );
//     register_block_type( 'gutenberg-examples/example-01', array(
//         'editor_script' => 'gutenberg-examples-01',
//     ) );
// }
// add_action( 'init', 'gutenberg_vinasupport_sample_01_register_block' );