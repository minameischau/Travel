

<style>
    .btn-book-now {
        width: auto;
    }

    @media only screen and (max-width: 768px) {
        .btn-book-now {
            width: 100%;
        }
    }
</style>
<?php
$url = $_SERVER['REQUEST_URI'];
$segments = explode('/', $url);
// $lastSegment = end($segments);
$tour_cate = $segments[3];

$all_tours = get_posts([
    'post_type' => 'tour-management',
    'post_status' => 'publish',
    'numberposts' => -1
]);
// var_dump($tour_cate);
// print_r('jfisodhf');

foreach ($all_tours as $v) {
    $term_tax_id = get_the_terms($v->ID, 'tour-cate');
    $slug_term = $term_tax_id[0]->slug;
    // var_dump($slug_term);
    $current_date_stamp = strtotime(date('Y-m-d'));
    $dep_date_stamp = strtotime(get_post_meta($v->ID, '_dep_date', true));
    if ($dep_date_stamp > $current_date_stamp) {
        if ($slug_term == $tour_cate) {
            $v->post_image_url =  get_the_post_thumbnail_url($v->ID);
            $v->post_link = get_permalink($v->ID);
            $v->dep_date = date('d/m/Y', strtotime(get_post_meta($v->ID, '_dep_date', true)));
            $v->post_name = $v->post_name;
            $v->slot_remain = get_post_meta($v->ID, '_tour_slot_remain', true);
            $v->price = get_post_meta($v->ID, '_tour_price', true);
            $v->day_total = get_post_meta($v->ID, '_day_total', true);
            $v->place_end = get_post_meta($v->ID, '_place_end', true);
            $v->place_start = get_post_meta($v->ID, '_place_start', true);
        }
    } else {
        continue;
    }
}    
$cnt = 0;
foreach ($all_tours as $key) {
    // var_dump($key->slot_remain);
    if ($key->slot_remain != '') {
        // var_dump($v->slot_remain);
?>
        <a class="text-decoration-none" href="<?= $key->post_link ?>">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $key->post_image_url ?>" class="img-fluid rounded-start h-100" alt="...">
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="card-body">
                            <h5 class="card-title m-0"> <?= $key->post_title ?> </h5>
                            <p class="card-text m-0 my-3"> <?= $key->place_start ?> - <?= $key->place_end ?> </p>
                            <p class="card-text m-0">Estimate: <?= $key->day_total ?> days</p>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-center">
                        <div class="card-body">
                            <p class="card-text mb-4"><i class="bi bi-calendar2-minus"></i> <?= $key->dep_date ?> </p>
                            <span class="card-text px-3 py-2 rounded-4" style="background-color: #f2b129;"><i class="bi bi-coin"></i> <?= $key->price ?> </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
<?php
    }
    $cnt += 1;
}
// var_dump($all_tours);
?>

