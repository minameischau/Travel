<head>
    <!-- bootstrap 5 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- font awesom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- pagiantion -->
    <script src="https://pagination.js.org/dist/2.6.0/pagination.min.js"></script>
    <link rel="stylesheet" href="https://pagination.js.org/dist/2.6.0/pagination.css">
</head>

<?php

$all_tours = get_posts([
    'post_type' => 'tour-management',
    'post_status' => 'publish',
    'numberposts' => -1
]);

foreach ($all_tours as $tour) {
    $current_date_stamp = strtotime(date('Y-m-d'));
    $dep_date_stamp = strtotime(get_post_meta($tour->ID, '_dep_date', true));
    // var_dump($current_date_stamp);
    // var_dump($dep_date_stamp);
    if ($dep_date_stamp > $current_date_stamp) {
        $tour->post_image_url =  get_the_post_thumbnail_url($tour->ID);
        $tour->post_link = get_permalink($tour->ID);
        $tour->dep_date = date('d/m/Y', strtotime(get_post_meta($tour->ID, '_dep_date', true)));
        $tour->post_name = $tour->post_name;
        // var_dump($tour->post_name);
        $tour->slot_remain = get_post_meta($tour->ID, '_tour_slot_remain', true);
        $tour->price = get_post_meta($tour->ID, '_tour_price', true);
        $tour->day_total = get_post_meta($tour->ID, '_day_total', true);
        $tour->place_end = get_post_meta($tour->ID, '_place_end', true);
        $tour->place_start = get_post_meta($tour->ID, '_place_start', true);
    } else {
        continue;
    }
}
// var_dump($all_tours);

// Vòng lặp để kiểm tra và xóa các phần tử
$cnt = 0;
foreach ($all_tours as $tour) {
    // var_dump($tour->slot_remain);
    if ($tour->dep_date != '') {
?>
        <a class="text-decoration-none" href="<?= $tour->post_link ?>">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $tour->post_image_url ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="card-body">
                            <h5 class="card-title m-0 <?php if ($tour->slot_remain <= 0) { ?> text-decoration-line-through <?php } ?> "> <?= $tour->post_title ?> </h5>
                            <p class="card-text m-0 my-3"> <?= $tour->place_start ?> - <?= $tour->place_end ?> </p>
                            <p class="card-text m-0">Estimate: <?= $tour->day_total ?> days</p>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-center">
                        <div class="card-body">
                            <p class="card-text mb-4"><i class="bi bi-people-fill me-1"></i> <?= $tour->slot_remain ?> </p>
                            <p class="card-text mb-4"><i class="bi bi-calendar2-minus me-1"></i> <?= $tour->dep_date ?> </p>
                            <span class="card-text px-3 py-2 rounded-4" style="background-color: #f2b129;"><i class="bi bi-coin"></i> <?= $tour->price ?> </span>
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


<!-- <div class="container">
    <div class="d-flex flex-wrap justify-content-center mb-3" id="all-tours-render"></div>
    <div class="d-flex flex-wrap justify-content-center my-3" id="all-tours-pagination"></div>
</div> -->

<script type="text/javascript">
    // console.log('Test jquery');
    jQuery(document).ready(function($) {

        $('#all-tours-pagination').pagination({
            dataSource: <?= json_encode($all_tours) ?>, //string json
            pageSize: 6,
            className: 'paginationjs-theme-green justify-content-center paginationjs-big',
            callback: function(items, pagination) {

                console.log(items) // item on per page
                htmlContainer = $('#all-tours-render');
                htmlContainer.empty();

                items.forEach(item => {
                    // var html = '<div class="mb-3 d-flex justify-content-center">' +
                    //                 '<div class="card" style="width: 18rem; scale:0.8">' +
                    //                     '<img src="' + item.post_image_url + '" class="card-img-top" alt="..." height="200px">' +
                    //                     '<div class="card-body">' +
                    //                         '<a class="text-decoration-none" href="' + item.post_link + '"><h5 class="card-title">' + item.post_title + '</h5></a>' +
                    //                         '<p class="card-text"><i class="fa-solid fa-clock"></i> ' + item.dep_date + '</p>' +
                    //                         '<p class="card-text"><i class="bi bi-person-hearts"></i> ' + item.slot_remain + '</p>' +
                    //                         '<a href="/wordpress/tour/' + item.post_name + '" class="btn btn-warning btn-book-now">See more</a>' +
                    //                     '</div>' +
                    //                 '</div>' +
                    //             '</div>';
                    var html_test = '<a class="text-decoration-none" href="' + item.post_link + '">' +
                        '<div class="card mb-3">' +
                        '<div class="row g-0">' +
                        '<div class="col-md-4">' +
                        '<img src="' + item.post_image_url + '" class="img-fluid rounded-start" alt="...">' +
                        '</div>' +
                        '<div class="col-md-5">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + item.post_title + '</h5>' +
                        '<p class="card-text"><i class="fa-solid fa-clock"></i> ' + item.day_total + '</p>' +
                        '<p class="card-text">' + item.place_end + '</p>' +
                        '</div>' +
                        '</div>' +

                        '<div class="col-md-3">' +
                        '<p class="card-text"><i class="fa-solid fa-clock"></i> ' + item.dep_date + '</p>' +
                        '<p class="card-text"><i class="fa-solid fa-clock"></i> ' + item.price + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div> </a>';
                    htmlContainer.append(html_test);

                });

                var html_test = template(data);
                dataContainer.html(html_test);
            },
            afterRender: function() {
                // Sau khi render, co the theem event click,..
            }
        })
    })
</script>