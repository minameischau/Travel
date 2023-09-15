<?php

class CreateMemberManagementMetaBox extends CreateMemberManagement {

    public function __construct(){
        add_action('add_meta_boxes', [$this, 'custom_member_metabox']);
        add_action('save_post', [$this, 'save_custom_member_metabox'], 20);
    }
    /**************************************************
     * Start Customize meta box project information
     **************************************************/
    function custom_member_metabox()
    {
        add_meta_box(
            // ID của metabox, phải là duy nhất
            'custom_member_metabox',
            // Tiêu đề của metabox
            'Member infomation',
            // Callback function để hiển thị nội dung metabox
            [$this, 'custom_member_metabox_callback'],
            // Tên của custom post type mà bạn muốn thêm metabox vào
            $this->post_type,
            // Vị trí của metabox: normal (bên cạnh editor), side (ở bên phải) hoặc advanced (ở dưới editor)
            'normal',
            // Ưu tiên hiển thị của metabox (high, core hoặc default)
            'high'
        );
    }

    function custom_member_metabox_callback($post)
    {
        require_once TOUR_MANAGEMENT_PATH . 'inc/metabox-member-information-ui.php';
    }

    function save_custom_member_metabox ($post_id) {
        if (isset($_POST['member_tour'])) {
            update_post_meta($post_id, '_member_tour', sanitize_text_field($_POST['member_tour']));
        }
        // if (isset($_POST['member_name'])) {
        //     update_post_meta($post_id, '_member_name', sanitize_text_field($_POST['member_name']));
        // }
        if (isset($_POST['member_email'])) {
            update_post_meta($post_id, '_member_email', sanitize_text_field($_POST['member_email']));
        }
        if (isset($_POST['member_phone'])) {
            update_post_meta($post_id, '_member_phone', sanitize_text_field($_POST['member_phone']));
        }
        if (isset($_POST['member_role'])) {
            update_post_meta($post_id, '_member_role', sanitize_text_field($_POST['member_role']));
        }
    }
}
new CreateMemberManagementMetaBox();