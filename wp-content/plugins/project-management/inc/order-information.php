<?php

$order_id = get_the_ID();
// var_dump($order_id);
$order_member_name = get_post_meta($order_id, '_order_member_name', true);
$order_member_phone = get_post_meta($order_id, '_order_member_phone', true);
$order_member_email = get_post_meta($order_id, '_order_member_email', true);
$order_status = get_post_meta($order_id, '_order_status', true);
$order_total = get_post_meta($order_id, '_order_total', true);
$order_quantity = get_post_meta($order_id, '_order_quantity', true);
$order_payment_method = get_post_meta($order_id, '_order_payment_method', true);
$tour_id = get_post_meta($order_id, '_order_tourID', true);
$place_start = get_post_meta($tour_id, '_place_start', true);
$place_end = get_post_meta($tour_id, '_place_end', true);
$dep_date = get_post_meta($tour_id, '_dep_date', true);
$tour_link = get_the_post_thumbnail_url($tour_id);
$order_title = get_the_title($order_id);
?>

<div class="card m-auto w-100">
    <div class="card-body text-center">
        <h5 class="card-title">#<?= $order_title ?></h5>
    </div>
    <div class="row d-flex justify-content-center">
        <img src="<?= $tour_link ?>" class="card-img-top w-75 " alt="...">

    </div>

    <div class="row">
        <div class="col-6">
            <div class="card-body" style="padding-left: 113px;">
                <h5 class="card-title d-flex"> Name :
                    <p class="ms-2 card-text fw-normal"> <?= $order_member_name ?></p>
                </h5>
                <h5 class="card-title d-flex"> Email :
                    <p class="ms-2 card-text fw-normal"> <?= $order_member_email ?></p>
                </h5>
                <h5 class="card-title d-flex"> Phone :
                    <p class="ms-2 card-text fw-normal"> <?= $order_member_phone ?></p>
                </h5>
            </div>
        </div>
        <div class="col-6">
            <div class="card-body">
                <h5 class="card-title d-flex"> From :
                    <p class="ms-2 card-text fw-normal"> <?= $place_start ?></p>
                </h5>
                <h5 class="card-title d-flex"> Visit :
                    <p class="ms-2 card-text fw-normal"> <?= $place_end ?></p>
                </h5>
                <h5 class="card-title d-flex"> Date :
                    <p class="ms-2 card-text fw-normal"> <?= $dep_date ?></p>
                </h5>
                <h5 class="card-title d-flex"> Quantity :
                    <p class="ms-2 card-text fw-normal" id="order_quantity"> <?= $order_quantity ?></p>
                </h5>
                <h5 class="card-title d-flex"> Status :
                    <p class="ms-2 card-text fw-normal">
                        <?php
                        if ($order_status == '-1') {
                        ?>
                            Cancel
                        <?php
                        } elseif ($order_status == '0') {
                        ?>
                            Waiting
                        <?php
                        } elseif ($order_status == '1') {
                        ?>
                            Confirm
                        <?php
                        }
                        ?>
                    </p>
                </h5>

                <h5 class="card-title d-flex"> Total :
                    <p class="ms-2 card-text fw-normal"> <?= number_format($order_total) ?> đ</p>
                </h5>
            </div>
        </div>
        <div class="row p-0 m-auto w-25">
            <?php if ($order_status == '1' || $order_status == '-1') {
            ?>
                <button disabled id="cancel-order" class="border-0 px-3 py-2 text-white fw-bold" style="background-color: #f2b129; opacity: 0.5;">Cancel</button>  
            <?php
            } elseif ($order_status == '0') {
            ?>
                <button id="cancel-order" class="border-0 px-3 py-2 text-white fw-bold" style="background-color: #f2b129;">Cancel</button>  
            <?php
            }
            ?>
        </div>
    </div>
</div>