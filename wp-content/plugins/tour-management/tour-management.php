<?php

/*
Plugin Name: Manage Tour
Description: Plugin tour management for manage tour, ...
Version: 1.0.0
Author: Chau
Author URI: fb.com/ngocchau.ha1801
License: Giấy phép sử dụng của plugin (ví dụ: GPL2)
*/

if (!defined('TOUR_MANAGEMENT_PATH')) {
    define('TOUR_MANAGEMENT_PATH', plugin_dir_path(__FILE__));
}
if (!defined('TOUR_MANAGEMENT_URL')) {
    define('TOUR_MANAGEMENT_URL', plugin_dir_url(__FILE__));
}

require_once(TOUR_MANAGEMENT_PATH . 'features/class-tour-management-create.php');
require_once(TOUR_MANAGEMENT_PATH . 'features/class-member-management-create.php');

// CreateTourManagement
new CreateTourManagement();
new CreateMemberManagement();