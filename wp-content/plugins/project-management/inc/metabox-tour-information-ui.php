<?php
wp_nonce_field(basename(__FILE__), 'custom_post_metabox_nonce'); // Thêm nonce để bảo vệ form

$dep_date = get_post_meta($post->ID, '_dep_date', true);
$place_start = get_post_meta($post->ID, '_place_start', true);
$place_end = get_post_meta($post->ID, '_place_end', true);
$day_total = get_post_meta($post->ID, '_day_total', true);
$tour_price = get_post_meta($post->ID, '_tour_price', true);
$tour_slot = get_post_meta($post->ID, '_tour_slot', true);
$attachment_url = get_post_meta($post->ID, '_attachment_url', true);
$tour_slot_remain = get_post_meta($post->ID, '_tour_slot_remain', true);

$args = array(
    'post_type' => 'order-management', // Kiểu post là 'order'
    'posts_per_page' => -1, // Lấy tất cả các bài đăng
);

$orders = get_posts($args);
$slot_remain = 0;
$cnt = 0;

foreach ($orders as $ord) :
    $ord->tourId = get_post_meta($ord->ID, '_order_tourID', true);
    $ord->tourSlot = get_post_meta($ord->ID, '_order_quantity', true);
    if ($ord->tourId == $post->ID) {
        $cnt = $cnt + (int)$ord->tourSlot;
        // $tour_name = $tour->post_title;
    }
endforeach;
$slot_remain = (int)$tour_slot - $cnt;




?>

<!-- Link CSS và JS của Select2 -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        var addImageBtn = $("#upload-button");
        var mediaUploader;

        addImageBtn.on("click", function(event) {
            event.preventDefault();
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media({
                title: "Choose Images",
                button: {
                    text: "Select"
                },
                multiple: true
            });
            mediaUploader.on("select", function() {
                var attachments = mediaUploader.state().get("selection").toJSON();
                var imageList = "";
                var arr_url = [];
                attachments.forEach(function(attachment) {
                    imageList += '<img width="22%" style="border-radius: 10px" class="mx-2 my-2" src="' + attachment.url + '" alt="' + attachment.title + '">';
                    // saveAttachment(attachment.url);
                    // console.log(attachment.url);   //http://localhost/wordpress/wp-content/uploads/2023/05/flower-13.jpg
                    arr_url.push(attachment.url);
                });
                // console.log(arr_url);
                $.ajax({
                    type: "post",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data: {
                        action: "save_attachment",
                        attachment_url: arr_url,
                        tour_ID: '<?= $post->ID ?>'
                    },
                    // success: function(response) {
                    //     //Làm gì đó khi dữ liệu đã được xử lý
                    //     if(response.success) {
                    //         console.log(response.data);
                    //     }
                    //     else {
                    //         alert('Đã có lỗi xảy ra');
                    //     }

                    // },
                })
                document.getElementById("image-gallery").innerHTML = imageList;
            });
            mediaUploader.open();
        });

        $('#demo').click(function() {
            $.ajax({
                type: "post",
                url: '<?php echo admin_url('admin-ajax.php'); ?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                data: {
                    action: "thongbao", //Tên action
                    movie_name: 'movie_name',
                },
                success: function(response) {
                    //Làm gì đó khi dữ liệu đã được xử lý
                    if (response.success) {
                        alert(response.data);
                    } else {
                        alert('Đã có lỗi xảy ra');
                    }

                },
            })
        })
    });
</script>
<!-- 
<script>
    $(document).ready(function(){
        
    })
</script> -->


<!-- // Hiển thị trường Tour name -->
<!-- <div class="form-group">
    <label for="tour_name">Tour name</label>
    <input type="text" id="tour_name" name="tour_name" value="" />
</div> -->
<!-- // Hiển thị trường Start -->
<div class="row">
    <div class="col-6">
        <!-- // Hiển thị trường End -->
        <div class="form-group">
            <label for="place_start">Starting location</label>
            <input class="form-control" type="text" id="place_start" name="place_start" value="<?= esc_attr($place_start) ?>" />
        </div>
        <!-- // Hiển thị trường End -->
        <div class="form-group">
            <label for="dep_date">Departure day</label>
            <input class="form-control" type="date" id="dep_date" name="dep_date" value="<?= $dep_date ?>" />
        </div>
        <div class="form-group">
            <label for="day_total">Day total</label>
            <input class="form-control" type="number" id="day_total" name="day_total" value="<?= esc_attr($day_total) ?>" />
        </div>
    </div>
    <div class="col-6">
        <!-- // Hiển thị trường Price -->
        <div class="form-group">
            <label for="place_end">Visting location</label>
            <input class="form-control" type="text" id="place_end" name="place_end" value="<?= esc_attr($place_end) ?>" />
        </div>
        <div class="form-group">
            <label for="tour_price">Price</label>
            <input class="form-control" type="number" id="tour_price" name="tour_price" value="<?= esc_attr($tour_price) ?>" />
        </div>
        <!-- // Hiển thị trường Price -->
        <div class="form-group">
            <label for="tour_slot">Slot</label>
            <input class="form-control" type="text" id="tour_slot" name="tour_slot" value="<?= esc_attr($tour_slot) ?>" />
        </div><!-- // Hiển thị trường Price -->

        <?php if (!empty($slot_remain)) { ?>

            <div class="form-group">
                <label for="tour_slot_remain">Slot Remain</label>
                <input class="form-control" type="text" id="tour_slot_remain" name="tour_slot_remain" value="<?= esc_attr($slot_remain) ?>" readonly />
            </div>

        <?php } ?>
    </div>

</div>
<?php if (is_array($attachment_url) && !empty($attachment_url)) { ?>
    <div class="">
        <h1>Images about this tour </h1>
        <?php
        foreach ($attachment_url as $value) {
        ?>
            <!-- <div class="">  -->
            <img src="<?= $value ?>" width="22%" style="border-radius: 10px" class="mx-2 my-2">

            <!-- </div> -->

        <?php
        }
        ?>
    </div>

<?php } ?>

<button id="upload-button" class="btn mb-2 btn-primary">Upload images</button>
<div id="image-gallery"></div>

<script>
    jQuery(document).ready(function($) {
        // Chọn form bạn muốn áp dụng jQuery Validate
        $('#post').validate({
            rules: {
                // Các quy tắc kiểm tra cho từng trường input
                dep_date: {
                    required: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                place_start: {
                    required: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                place_end: {
                    required: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                // Thêm các trường input khác và quy tắc kiểm tra tương ứng
                day_total: {
                    required: true,
                    min: 0,
                    // Thêm các quy tắc kiểm tra khác
                },
                tour_price: {
                    required: true,
                    min: 0,
                    // Thêm các quy tắc kiểm tra khác
                },
                tour_slot: {
                    required: true,
                    min: 0,
                    // Thêm các quy tắc kiểm tra khác
                },
            },
            messages: {
                // Các thông báo lỗi tương ứng với từng trường input
                dep_date: {
                    required: "This option is required",
                    // Thêm các thông báo lỗi khác
                },
                place_start: {
                    required: "This field is required",
                    // Thêm các thông báo lỗi khác
                },
                place_end: {
                    required: "This field is required",
                    // Thêm các thông báo lỗi khác
                },
                // Thêm các trường input khác và thông báo lỗi tương ứng
                day_total: {
                    required: "This field is required",
                    min: "Please enter a valid day"
                    // Thêm các thông báo lỗi khác
                },
                tour_price: {
                    required: "This field is required",
                    min: "Please enter a valid price"
                    // Thêm các thông báo lỗi khác
                },
                tour_slot: {
                    required: "This field is required",
                    min: "Please enter a valid slot"
                    // Thêm các thông báo lỗi khác
                },
            },
            // Cấu hình và tùy chọn khác cho jQuery Validate
        });

    });
</script>

<style>
    /* Đổi màu sắc cho thông báo lỗi */
    label.error {
        color: red;
    }

    /* Đổi màu sắc cho khung bao quanh input */
    input.error {
        border-color: red;
    }
</style>