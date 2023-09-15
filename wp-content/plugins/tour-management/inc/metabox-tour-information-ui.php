<?php
wp_nonce_field(basename(__FILE__), 'custom_post_metabox_nonce'); // Thêm nonce để bảo vệ form

$dep_date = get_post_meta($post->ID, '_dep_date', true);
$place_start = get_post_meta($post->ID, '_place_start', true);
$place_end = get_post_meta($post->ID, '_place_end', true);
$day_total = get_post_meta($post->ID, '_day_total', true);
$tour_price = get_post_meta($post->ID, '_tour_price', true);

?>

<!-- Link CSS và JS của Select2 -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
<div class="form-group">
    <label for="dep_date">Departure day</label>
    <input class="form-control" type="date" id="dep_date" name="dep_date" value="<?= $dep_date ?>" />
</div>
<!-- // Hiển thị trường Start -->
<div class="form-group">
    <label for="place_start">Starting location</label>
    <input class="form-control" type="text" id="place_start" name="place_start" value="<?= esc_attr($place_start) ?>" />
</div>

<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="place_end">Ending location</label>
    <input class="form-control" type="text" id="place_end" name="place_end" value="<?= esc_attr($place_end) ?>" />
</div>
<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="day_total">Day total</label>
    <input class="form-control" type="text" id="day_total" name="day_total" value="<?= esc_attr($day_total) ?>" />
</div>
<!-- // Hiển thị trường Price -->
<div class="form-group">
    <label for="tour_price">Price</label>
    <input class="form-control" type="text" id="tour_price" name="tour_price" value="<?= esc_attr($tour_price) ?>" />
</div>