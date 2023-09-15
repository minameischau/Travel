<?php

/*
Plugin Name: Manage Member Plugin
Description: Plugin tour management for manage member in tour, ...
Version: 1.0.0
Author: Chau
License: Giấy phép sử dụng của plugin (ví dụ: GPL2)
*/

if (!defined('MEMBER_MANAGEMENT_PATH')) {
    define('MEMBER_MANAGEMENT_PATH', plugin_dir_path(__FILE__));
}
if (!defined('MEMBER_MANAGEMENT_URL')) {
    define('MEMBER_MANAGEMENT_URL', plugin_dir_url(__FILE__));
}

require_once(MEMBER_MANAGEMENT_PATH . 'features/class-member-management-create.php');

// CreateMemberManagement
new CreateMemberManagement();