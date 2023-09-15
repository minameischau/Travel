<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy tham chiếu đến nút "Add Image"
        var addImageBtn = document.getElementById("addImageBtn");

        // Xử lý sự kiện click vào nút "Add Image"
        addImageBtn.addEventListener("click", function(event) {
            event.preventDefault();
            // console.log('attachment')

            // Hiển thị media uploader
            var mediaUploader = wp.media({
                title: "Choose Image",
                button: {
                    text: "Select"
                },
                multiple: true // Chỉ cho phép chọn một hình ảnh
            });
            console.log('xong choose')

            // Xử lý khi chọn hình ảnh từ media uploader
            mediaUploader.on("select", function() {
                console.log('vào on')

                var attachment = mediaUploader.state().get("selection").first().toJSON();
                console.log(attachment)
                // Tạo phần tử <img> mới và gắn hình ảnh vào metabox
                var imageElement = document.createElement("img");
                imageElement.src = attachment.url;
                imageElement.alt = attachment.alt;

                var imageGallery = document.getElementById("imageGallery");
                    imageGallery.appendChild(imageElement);

                // Lưu ID của hình ảnh vào trường ẩn để lưu trữ
                var imageGalleryIds = document.getElementById("imageGalleryIds");
                    imageGalleryIds.value += attachment.id + ",";
            });

            // Mở media uploader
            mediaUploader.open();
        });
});

</script>

<?php
class CreateTourManagementMetaBox extends CreateTourManagement {

    public function __construct(){
        add_action('add_meta_boxes', [$this, 'custom_tour_metabox']);
        add_action('add_meta_boxes', [$this, 'custom_tour_metabox_img']);
        add_action('save_post', [$this, 'save_custom_tour_metabox'], 20);
        add_action('save_post', [$this, 'save_custom_tour_metabox_img'], 20);
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
        require_once TOUR_MANAGEMENT_PATH . 'inc/metabox-tour-information-ui.php';
    }

    function custom_tour_metabox_img() {
        add_meta_box(
            'image_gallery', // ID của metabox
            'Image Gallery', // Tiêu đề của metabox
            [$this, 'render_image_gallery_metabox'], // Callback function để hiển thị nội dung của metabox
            $this->post_type, // Slug của custom post type mà bạn muốn áp dụng metabox
            'normal', // Vị trí của metabox (normal, side, advanced)
            'high' // Ưu tiên hiển thị của metabox (high, default, low)
        );
    }

    function render_image_gallery_metabox($post) {
        // Lấy danh sách hình ảnh đã lưu cho post
        $image_gallery = get_post_meta($post->ID, '_wp_attached_file', true);
        echo json_encode($image_gallery);
        // Hiển thị trường input để tải lên và lưu trữ hình ảnh
        // echo '<input type="hidden" name="image_gallery_nonce" value="' . wp_create_nonce('image_gallery_nonce') . '">';
        // echo '<ul class="image-gallery-list">';
    
        // if ($image_gallery) {
        //     foreach ($image_gallery as $image_id) {
        //         $image_src = wp_get_attachment_image_src($image_id, 'thumbnail');
        //         echo '<li><img src="' . $image_src[0] . '"></li>';
        //     }
        // }
    
        // echo '</ul>';
        // echo '<input type="button" class="button button-primary" id="addImageBtn" value="Add Images">';
    }
    
    function save_custom_tour_metabox_img($post_id) {
        if (!isset($_POST['image_gallery_nonce']) || !wp_verify_nonce($_POST['image_gallery_nonce'], 'image_gallery_nonce')) {
            return;
        }
    
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
    
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    
        if (isset($_POST['image_gallery']) && is_array($_POST['image_gallery'])) {
            $image_gallery = array_filter($_POST['image_gallery'], 'attachment_exists');
            update_post_meta($post_id, 'image_gallery', $image_gallery);
        } else {
            delete_post_meta($post_id, 'image_gallery');
        }
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
    }
}

new CreateTourManagementMetaBox();