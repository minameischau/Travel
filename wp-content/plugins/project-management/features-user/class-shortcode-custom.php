<?php

class CustomShortCode
{

    public function __construct()
    {
        add_shortcode('sign_up', [$this, 'func_sign_up']);
        add_shortcode('order_member_list', [$this, 'func_order_member_list']);
        add_shortcode('order_information', [$this, 'func_order_information']);
        add_shortcode('sign_in', [$this, 'func_sign_in']);
        add_shortcode('is_login', [$this, 'func_is_login']);
        add_shortcode('orders_list', [$this, 'func_orders_list']);
        add_shortcode('tours_by_search', [$this, 'func_tours_by_search']);
        add_shortcode('tours_by_cate', [$this, 'func_tours_by_cate']);
    }

    function func_tours_by_search() {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/tours-by-search.php';
        return ob_get_clean();
    }

    function func_order_information() {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/order-information.php';
        return ob_get_clean();
    }

    function func_sign_up()
    {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/sign-up.php';
        return ob_get_clean();
    }

    function func_sign_in()
    {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/sign-in.php';
        return ob_get_clean();
    }

    function func_is_login()
    {
        ob_start();
        if (get_current_user_id() == 0) {
            require_once PROJECT_MANAGEMENT_PATH . '/inc/is-login.php';
        } else {
            require_once PROJECT_MANAGEMENT_PATH . '/inc/logined.php';

            // return '<a href="http://localhost/wordpress/orderlist/">Orders</a> <a> Logout </a>';
        }
        return ob_get_clean();
    }
    function func_tours_by_cate()
    {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/tours-by-cate.php';
        return ob_get_clean();
        // $url = $_SERVER['REQUEST_URI'];
        // $segments = explode('/', $url);
        // // $lastSegment = end($segments);
        // $tour_cate = $segments[3];
        // return var_dump($tour_cate);
    }

    function func_orders_list() {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/orders-list.php';
        return ob_get_clean();
    }

    function func_order_member_list() {
        ob_start();
        require_once PROJECT_MANAGEMENT_PATH . '/inc/order-member-list.php';
        return ob_get_clean();
    }
}
