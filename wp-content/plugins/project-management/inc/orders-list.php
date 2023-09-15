    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> -->

<?php
$current_email = get_userdata(get_current_user_id())->user_email;
// var_dump($current_email);
$all_orders = get_posts(array(
    'post_type' => 'order-management',
    'post_status' => 'publish',
    'numberposts' => -1
));

foreach ($all_orders as $order) {
    if ($order->_order_member_email == $current_email) {
        // var_dump($order->_order_status);
        // var_dump($order->post_title);
        // var_dump($order->_order_member_name);
        // var_dump($order->_order_total);
        // var_dump($order->_order_quantity);

        $tour_id = $order->_order_tourID;
        $tour_name = get_the_title($tour_id);
        // var_dump($tour_id);
        $place_start = get_post_meta($tour_id, '_place_start', true);
        $place_end = get_post_meta($tour_id, '_place_end', true);
        $dep_date = get_post_meta($tour_id, '_dep_date', true);
        $day_total = get_post_meta($tour_id, '_day_total', true);
?>

    <a class="text-decoration-none" href="<?= $order->guid ?>">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
<?php
    if ($order->_order_status == '0') {
?>
                    <i style="font-size: 4rem!important; color: #fcb900;" class="bi bi-exclamation-circle"></i>
<?php
    } elseif ($order->_order_status == '1') {
?>
                    <i style="font-size: 4rem!important;" class="text-success bi bi-check-circle"></i>
<?php
    } elseif ($order->_order_status == '-1') {
?>
                    <i style="font-size: 4rem!important;" class="text-danger bi bi-x-circle"></i>
<?php
    }
?>                    
                </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="card-body">
                            <h5 class="card-title m-0"> <?= $tour_name?> </h5>
                            <p class="card-text m-0 my-3"> <?=$place_start?> -----> <?= $place_end ?> </p>
                            <p class="card-text m-0">Estimate: <?= $day_total ?> days</p>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-center">
                        <div class="card-body">
                            <p class="card-text mb-4"><i class="bi bi-calendar2-minus"></i>  <?= $dep_date ?></p>
                            <span class="card-text px-3 py-2 rounded-4" style="background-color: #f2b129;"><i class="bi bi-coin"></i> <?= $order->_order_total ?></span>
                        </div>
                    </div>
            </div>
        </div>
    </a>

<?php
    }

}

?>