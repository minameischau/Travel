<?php

class TourSubMenu {
    public function __construct(){
        add_action('admin_menu', [$this, 'func_submenu']);
        
    }    
    function func_submenu() {
        add_menu_page(
            'Tieu de trang',
            'Ten menu',
            'manage_options',
            'toursubmenu',
            'toursubmenu_callback',
            '',
            25
        );
        // Thêm submenu cho menu chính
        add_submenu_page(
            'review_food', // Slug của menu cha
            'Location', // Tiêu đề của submenu
            'Location', // Tên của submenu
            'manage_options', // Quyền truy cập để truy cập submenu
            'edit.php?post_type=location' // Slug của trang tương ứng với submenu
        );
        // Thêm submenu cho menu chính
        add_submenu_page(
            'review_food', // Slug của menu cha
            'Review', // Tiêu đề của submenu
            'Review', // Tên của submenu
            'manage_options', // Quyền truy cập để truy cập submenu
            'edit.php?post_type=review' // Slug của trang tương ứng với submenu
        );
    }
}