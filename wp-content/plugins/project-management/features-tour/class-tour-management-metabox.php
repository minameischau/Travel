

<?php

class CreateTourManagementMetaBox extends CreateTourManagement {

    public function __construct(){
        add_action('add_meta_boxes', [$this, 'custom_tour_metabox']);
        // add_action('add_meta_boxes', [$this, 'register_image_gallery_metabox']);
        add_action('save_post', [$this, 'save_custom_tour_metabox'], 20);
        // add_action('save_post', [$this, 'save_image_gallery_metabox']);
    }
    /**************************************************
     * Start Customize meta box project information
     **************************************************/
    function custom_tour_metabox()
    {
        add_meta_box(
            // ID của metabox, phải là duy nhất
            'custom_tour_metabox',
            // Tiêu đề của metabox
            'Tour infomation',
            // Callback function để hiển thị nội dung metabox
            [$this, 'custom_tour_metabox_callback'],
            // Tên của custom post type mà bạn muốn thêm metabox vào
            $this->post_type,
            // Vị trí của metabox: normal (bên cạnh editor), side (ở bên phải) hoặc advanced (ở dưới editor)
            'normal',
            // Ưu tiên hiển thị của metabox (high, core hoặc default)
            'high'
        );
    }
            
    function custom_tour_metabox_callback($post)
    {
        require_once PROJECT_MANAGEMENT_PATH . 'inc/metabox-tour-information-ui.php';
    }

    function save_custom_tour_metabox ($post_id) {
        if (isset($_POST['dep_date'])) {
            update_post_meta($post_id, '_dep_date', sanitize_text_field($_POST['dep_date']));
        }
        if (isset($_POST['place_start'])) {
            update_post_meta($post_id, '_place_start', sanitize_text_field($_POST['place_start']));
        }
        if (isset($_POST['place_end'])) {
            update_post_meta($post_id, '_place_end', sanitize_text_field($_POST['place_end']));
        }
        if (isset($_POST['day_total'])) {
            update_post_meta($post_id, '_day_total', sanitize_text_field($_POST['day_total']));
        }
        if (isset($_POST['tour_price'])) {
            update_post_meta($post_id, '_tour_price', sanitize_text_field($_POST['tour_price']));
        }
        if (isset($_POST['tour_slot'])) {
            update_post_meta($post_id, '_tour_slot', sanitize_text_field($_POST['tour_slot']));
        }
        if (isset($_POST['tour_slot_remain'])) {
            update_post_meta($post_id, '_tour_slot_remain', sanitize_text_field($_POST['tour_slot_remain']));
        }
    }
}

new CreateTourManagementMetaBox();