<?php
wp_nonce_field(basename(__FILE__), 'custom_post_metabox_nonce'); // Thêm nonce để bảo vệ form
$order_tourID = get_post_meta($post->ID, '_order_tourID', true);
$order_quantity = get_post_meta($post->ID, '_order_quantity', true);
$order_status = get_post_meta($post->ID, '_order_status', true);
$order_payment_method = get_post_meta($post->ID, '_order_payment_method', true);
$order_total = get_post_meta($post->ID, '_order_total', true);
$tour_price = get_post_meta($order_tourID, '_tour_price', true);
$tour_slot_remain = get_post_meta($order_tourID, '_tour_slot_remain', true);
$tours = get_posts(array(
    'post_type' => 'tour-management',
    'posts_per_page' => -1, // Lấy tất cả các bài viết
));

$args = array(
    'post_type' => 'order-management', // Kiểu post là 'order'
    'posts_per_page' => -1, // Lấy tất cả các bài đăng
);

$orders = get_posts($args);
$slot = 0;
// echo '<pre>';
// var_dump($order_tourID);
// echo '</pre>';

// echo '<pre>';
// print_r($tours);
// echo '</pre>';


// if (isset($_POST['publish']) && $_POST['publish'] != '') {
//     $order_id = $post->ID; // Lấy ID của bài viết order
//     echo '<pre>';
//     print_r($order_id);
//     // die;
//     echo '</pre>';    
//     // Thay đổi trạng thái thành "publish"
//     wp_update_post(array(
//         'ID' => $order_id,
//         'post_status' => 'publish'
//     ));
// }

?>

<!-- Link CSS và JS của Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script>
    jQuery(document).ready(function($) {
        $('#order_tourID').change(function() {
            const tourPrice = $(this).find(':selected').data('tour-price');
            // console.log(tourPrice)
            $('#tour_price').val(tourPrice);
            const tourSlot = $(this).find(':selected').data('tour-slot-remain');
            // console.log(tourSlot)
            $('#tour_slot_remain').val(tourSlot);
            const tourID = $(this).find(':selected').data('tour-id');
            // console.log(tourID)
            
        });
    })
</script>
<form action="" id="order-form">
    <div class="row">
        <div class="col-6">
            <label for="order_tourID">Tour name</label>
            <select name="order_tourID" id="order_tourID" class="form-control">
                <option value="-1">Select tour</option>
                <?php
                foreach ($tours as $tour) :
                    $tour->price = get_post_meta($tour->ID, '_tour_price', true);
                ?>
                    <option value="<?= esc_attr($tour->ID) ?>" 
                        <?php
                            $slot = get_post_meta($tour->ID, '_tour_slot_remain', true);
                            if ($tour->ID == $order_tourID){
                        ?> 
                        selected
                        <?php
                            }
                        ?>
                            data-tour-price="<?= esc_attr($tour->price) ?>"
                            data-tour-slot-remain="<?= esc_attr($slot) ?>"
                            >
                        <?php 
                            // echo $tour_name;
                        ?> 
                        <?= esc_html($tour->post_title) ?>
                    </option>
                <?php endforeach; ?> 
            </select>
            
            <!-- // Hiển thị trường End -->
            <!-- <div class="form-group"> -->
            <label for="order_quantity" class="mt-2">Quantity</label>
            <input class="form-control" type="number" id="order_quantity" name="order_quantity" value="<?= esc_attr($order_quantity) ?>" />
            <!-- </div> -->
            
            <label for="order_payment_method" class="mt-2">Payment method</label>
            <select name="order_payment_method" id="order_payment_method" class="form-control">
                <?php
                    $status = get_post_meta($post->ID, '_order_status', true);
                ?> 
                <option value="0" 
                    <?php
                        if ($status == 0){
                    ?> 
                        selected
                    <?php
                        }
                    ?>
                >COD</option>
                <option value="1" 
                    <?php
                        if ($status == 1){
                    ?> 
                        selected
                    <?php
                        }
                        // echo $status;
                    ?>
                >Transfer</option>
            </select>

<?php
    if ($order_tourID != "") {
?>

            <label for="order_status" class="mt-2">Order status</label>
            <select name="order_status" id="order_status" class="form-control">
                <?php
                    $status = get_post_meta($post->ID, '_order_status', true);
                ?> 
                <option value="0" 
                    <?php
                        if ($status == 0){
                    ?> 
                        selected
                    <?php
                        }
                    ?>
                >Waiting</option>
                <option value="1" 
                    <?php
                        if ($status == 1){
                    ?> 
                        selected
                    <?php
                        }
                        // echo $status;
                    ?>
                >Confirmed</option>
            </select>


<?php
    }
?>

        </div>
        <div class="col-6">
            <!-- // Hiển thị trường End -->
            <!-- <div class="form-group"> -->
                <label for="tour_price">Price</label>
                <input class="form-control" type="text" name="tour_price" id="tour_price" value="<?= $tour_price ?>" disabled>
            <!-- </div> -->
            <!-- // Hiển thị trường End -->
            <!-- <div class="form-group"> -->
                <label for="tour_slot_remain" style="margin-top: 11px;">Slot remain</label>
                <input class="form-control" type="text" name="tour_slot_remain" id="tour_slot_remain" value="<?= $tour_slot_remain ?>" readonly>
            <!-- </div> -->

<?php
    if ($order_tourID != "") {
?>
                <label for="" style="margin-top: 11px;">Price total</label>
                <input class="form-control" type="text" name="" id="" value="<?= $order_total ?>" readonly>

<?php
    }
?>
            
        </div>
    </div>
</form>
<script>
    jQuery(document).ready(function($) {
    // Chọn form bạn muốn áp dụng jQuery Validate
    $('#post').validate({
        rules: {
            // Các quy tắc kiểm tra cho từng trường input
            order_tourID: {
                required: true,
                // Thêm các quy tắc kiểm tra khác
            },
            order_quantity: {
                required: true,
                // Thêm các quy tắc kiểm tra khác
            },
            // Các quy tắc kiểm tra cho từng trường input
            order_member_name: {
                required: true,
                // Thêm các quy tắc kiểm tra khác
            },
            // Thêm các trường input khác và quy tắc kiểm tra tương ứng
            order_member_email: {
                required: true,
                email: true,
                // Thêm các quy tắc kiểm tra khác
            },
            order_member_phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
                // Thêm các quy tắc kiểm tra khác
            },
        },
        messages: {
            // Các thông báo lỗi tương ứng với từng trường input
            order_tourID: {
                required: "This option is required",
                // Thêm các thông báo lỗi khác
            },
            order_quantity: {
                required: "This field is required",
                // pattern: "Please enter a valid phone number"
                // Thêm các thông báo lỗi khác
            },
            // Các thông báo lỗi tương ứng với từng trường input
            order_member_name: {
                required: "This option is required",
                // Thêm các thông báo lỗi khác
            },
            // Thêm các trường input khác và thông báo lỗi tương ứng
            order_member_email: {
                required: "This field is required",
                email: "Please enter a valid email address"
                // Thêm các thông báo lỗi khác
            },
            order_member_phone: {
                required: "This field is required",
                digits: "Please enter a valid number phone",
                minlength: "Please enter a valid number phone",
                maxlength: "Please enter a valid number phone"
                // pattern: "Please enter a valid phone number"
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
