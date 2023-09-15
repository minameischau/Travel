<?php
wp_nonce_field(basename(__FILE__), 'custom_post_metabox_nonce'); // Thêm nonce để bảo vệ form
// $tour_name = get_post_meta($post->ID, '_tour_name', true);
$member_tour = get_post_meta($post->ID, '_member_tour', true);
$member_email = get_post_meta($post->ID, '_member_email', true);
$member_phone = get_post_meta($post->ID, '_member_phone', true);
$member_role = get_post_meta($post->ID, '_member_role', true);
$tours = get_posts(array(
    'post_type' => 'tour-management',
    'posts_per_page' => -1, // Lấy tất cả các bài viết
));

// $current_date = date('Y-m-d');
// echo $current_date;


?>

<!-- Link CSS và JS của Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<!-- // Hiển thị trường Tour name -->
<div class="form-group">
    <label for="member_email">Email</label>
    <input class="form-control" type="email" id="member_email" name="member_email" value="<?= esc_attr($member_email) ?>" />
</div>
<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="member_phone">Phone</label>
    <input class="form-control" type="tel" id="member_phone" name="member_phone" value="<?= esc_attr($member_phone) ?>" />
</div>
<div class="form-group">
    <label for="member_tour">Tour ID</label>
    <?php
    // echo json_encode($tours)
    ?>
    <!-- <input class="form-control" type="email" id="member_tour" name="member_tour" value="" /> -->
    <select name="member_tour" id="member_tour" class="form-control">
        <?php foreach ($tours as $tour) :
            $tour->dep_date = get_post_meta($tour->ID, '_dep_date', true);
            if ($current_date < $tour->dep_date) {
        ?>
                <option value="<?= esc_attr($tour->ID) ?>">
                    <?= esc_html($tour->post_title) ?>
                </option>
        <?php
            }
        ?>
        <?php endforeach; ?>
        <!-- <option value=""></option> -->
    </select>
</div>
<div class="">
    <span type="" id="moreTour">Thêm</span>
</div>
<div class="add">

</div>
<!-- </form> -->
<script>
    jQuery(document).ready(function($) {
        // Chọn form bạn muốn áp dụng jQuery Validate
        $('#post').validate({
            rules: {
                // Các quy tắc kiểm tra cho từng trường input
                member_tour: {
                    required: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                // Thêm các trường input khác và quy tắc kiểm tra tương ứng
                member_email: {
                    required: true,
                    email: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                member_phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                    // Thêm các quy tắc kiểm tra khác
                },
            },
            messages: {
                // Các thông báo lỗi tương ứng với từng trường input
                member_tour: {
                    required: "This option is required",
                    // Thêm các thông báo lỗi khác
                },
                // Thêm các trường input khác và thông báo lỗi tương ứng
                member_email: {
                    required: "This field is required",
                    email: "Please enter a valid email address"
                    // Thêm các thông báo lỗi khác
                },
                member_phone: {
                    required: "This field is required",
                    digits: "Please enter a valid number phone",
                    minlength: "Please enter a valid number phone",
                    maxlength: "Please enter a valid number phone"
                    // Thêm các thông báo lỗi khác
                },
            },
            // Cấu hình và tùy chọn khác cho jQuery Validate
        });

        // $('#moreTour').click(function() {
        //     var tourInput = `<div class="form-group">
        //                     <label for="member_tour">Tour ID</label>
        //                     <select name="member_tour" id="member_tour" class="form-control">
        //                         <?php foreach ($tours as $tour) :
                                        //                         
                                    ?>
        //                             <option value="<?= esc_attr($tour->ID) ?>"><?= esc_html($tour->post_title) ?></option>

        //                         <?php endforeach; ?>
        //                     </select></div>`;
        //                     // tourInput = "<h1>Hello </h1>";
        //                     console.log(tourInput)
        //     $('.add').html(tourInput);                        
        // })
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