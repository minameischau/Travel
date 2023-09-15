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

?>

<!-- Link CSS và JS của Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

</script>


<!-- // Hiển thị trường Tour name -->
<!-- <div class="form-group">
    <label for="tour_name">Tour name</label>
    <input type="text" id="tour_name" name="tour_name" value="" />
</div> -->
<!-- // Hiển thị trường Start -->
<!-- <div class="form-group">
    <label for="member_name">Name</label>
    <input type="text" id="member_name" name="member_name" value="" />
</div> -->
<div class="form-group">
    <label for="member_tour">Tour ID</label>
    <?php
    
    
    // echo json_encode($tours)
    ?>
    <!-- <input class="form-control" type="email" id="member_tour" name="member_tour" value="" /> -->
    <select name="member_tour" id="member_tour" class="form-control">
        <?php foreach ($tours as $tour):
        ?>
            <option value="<?= esc_attr($tour->ID) ?>">
                <?= esc_html($tour->post_title) ?>
            </option>
        
        <?php endforeach; ?>
        <!-- <option value=""></option> -->
    </select>
</div>
<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="member_email">Email</label>
    <input class="form-control" type="email" id="member_email" name="member_email" value="<?= esc_attr($member_email) ?>" />
</div>
<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="member_phone">Phone</label>
    <input class="form-control" type="text" id="member_phone" name="member_phone" value="<?= esc_attr($member_phone) ?>" />
</div>
<!-- // Hiển thị trường Price -->
<div class="form-group">
    <!-- <label for="member_role">Price</label>
    <input type="text" id="member_role" name="member_role" value="" /> -->
   
    <label for="member_role">Members</label>
    <select class="form-control" id="member_role" name="member_role">
        
        
            <option value="customer">
                Customer
            </option>
        
            <option value="tourguide">
                Tour guide
            </option>

            <option value="driver">
                Driver
            </option>
            
    </select>
</div>