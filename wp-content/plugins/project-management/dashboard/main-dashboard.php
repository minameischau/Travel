<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<h1 class="fw-bold text-center mb-5">Main dashboard</h1>

<!-- Chart -->
<?php
$tour_cate_khac = 0;
$tour_cate_trong = 0;
$tour_cate_ngoai = 0;
$args = array(
    'post_type' => 'order-management', // Kiểu post là 'order'
    'posts_per_page' => -1, // Lấy tất cả các bài đăng
);
$orders = get_posts($args);

foreach ($orders as $ord) :
    $order_tourID = get_post_meta($ord->ID, '_order_tourID', true);
    $term_tax_id = get_the_terms($order_tourID, 'tour-cate');
    $slug_term = $term_tax_id[0]->slug;
    if ($slug_term === 'khac') {
        $tour_cate_khac = $tour_cate_khac + 1;
    }
    if ($slug_term === 'trong-nuoc') {
        $tour_cate_trong = $tour_cate_trong + 1;
    }
    if ($slug_term === 'ngoai-nuoc') {
        $tour_cate_ngoai = $tour_cate_ngoai + 1;
    }
endforeach;
$order_data = [];
array_push($order_data, $tour_cate_khac);
array_push($order_data, $tour_cate_trong);
array_push($order_data, $tour_cate_ngoai);
$order_data = json_encode($order_data);

$tour_list_name = [];
$tour_list_book = [];

$all_tours = get_posts([
    'post_type' => 'tour-management',
    'post_status' => 'publish',
    'numberposts' => -1
]);
foreach ($all_tours as $tour) {

    $current_stamp = strtotime(date('Y-m-d'));
    $tour_stamp = strtotime($tour->_dep_date);

    if ($tour_stamp >= $current_stamp) {

        array_push($tour_list_name, $tour->post_title);
        // echo $tour->ID;
        $tour_slot = get_post_meta($tour->ID, '_tour_slot', true);
        $tour_slot_remain = get_post_meta($tour->ID, '_tour_slot_remain', true);
        array_push($tour_list_book, (int)$tour_slot - $tour_slot_remain);
    }
}


// $data = array(1,2,3,4,5,6);
$tour_list_name = json_encode($tour_list_name);
$tour_list_book = json_encode($tour_list_book);
// var_dump($data);
?>
<div class="">
    <div class="m-auto" style="width: 363px;">
        <canvas id="donut"></canvas>
    </div>
    <div class="m-auto" style="width: 686px;">
        <canvas id="chart"></canvas>
    </div>

</div>


<h3 class="fw-bold">New order</h3>
<?php
$curent_stamp = strtotime(date('Y-m-d h:m:s'));
$curent_week = date('W', $curent_stamp);
$curent_month = date('m', $curent_stamp);
$cr_month_date = date('Y-m');
?>

<input id="curent_time" type="hidden" name="" data-current-month-date="<?= $cr_month_date ?>" data-current-week="<?= $curent_week ?>" data-current-month="<?= $curent_month ?>">

<?php
$orders = get_posts(array(
    'post_type' => 'order-management',
    'posts_per_page' => -1,
));
?>
<div class="row">
    <?php
    foreach ($orders as $order) {
        $order_status = (int)get_post_meta($order->ID, '_order_status', true);
        $order_total = get_post_meta($order->ID, '_order_total', true);

        $current_date_stamp = strtotime(date('Y-m-d'));
        $date_time_stamp = strtotime($order->post_date);
        $date_stamp = strtotime(date('Y-m-d', $date_time_stamp));
        $day_diff = ($current_date_stamp - $date_stamp) / (60 * 60 * 24);

        $tour_id = $order->_order_tourID;
        $tour_name = get_the_title($tour_id);
        $place_start = get_post_meta($tour_id, '_place_start', true);
        $place_end = get_post_meta($tour_id, '_place_end', true);

        if ($day_diff <= 3) {
    ?>
            <!-- <div class="col-4 mx-2 "> -->
            <a href="./post.php?post=<?= $order->ID ?>&action=edit" class="text-decoration-none">
                <div class="card mb-3" style="max-width: 98%;">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <?php
                            if ($order_status == 0) {
                            ?>
                                <i class=" bi bi-exclamation-circle text-warning" style="font-size: 50px; color: #219ebc;"></i>
                            <?php
                            } elseif ($order_status == 1) {
                            ?>
                                <i class=" bi bi-check2-circle text-success" style="font-size: 50px; color: #219ebc;"></i>
                            <?php
                            } elseif ($order_status == -1) {
                            ?>
                                <i class=" bi bi-x-circle text-danger" style="font-size: 50px; color: #219ebc;"></i>
                            <?php
                            }
                            ?>

                        </div>
                        <div class="col-md-5 d-flex align-items-center">
                            <div class="card-body">
                                <h5 class="card-title"><?= $order->post_title ?></h5>
                                <p class="card-text fs-5"><?= $place_start ?> -----> <?= $place_end ?></p>
                                <!-- <p class="card-text fs-5"><small class="text-body-secondary"></small></p> -->
                            </div>
                        </div>


                        <div class="col-md-3 d-flex align-items-center">
                            <div class="card-body">
                                <p class="card-text fs-6 mb-4"><i class="bi bi-calendar2-minus"></i> <?= $order->post_date ?></p>
                                <span class="card-text px-3 py-2 rounded-4" style="background-color: #f2b129;"><i class="bi bi-coin"></i> <?= $order_total ?> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- </div> -->
    <?php
        }

        // echo $day_diff;
        // echo '<br>';
    }

    ?>
</div>

<h3 class="fw-bold">Almost full</h3>
<?php
$tours = get_posts(array(
    'post_type' => 'tour-management',
    'posts_per_page' => -1,
));
?>
<div class="row">
    <?php
    foreach ($tours as $tour) {
        $tour_slot_remain = (int)get_post_meta($tour->ID, '_tour_slot_remain', true);
        $tour_slot_remain = get_post_meta($tour->ID, '_tour_slot_remain', true);
        $tour_dep_date = get_post_meta($tour->ID, '_dep_date', true);
        $tour_dep_date_stamp = strtotime($tour_dep_date);
        $curent_stamp = strtotime(date('Y-m-d h:m:s'));
        $tour_date_week = date('W', $tour_dep_date_stamp);
        $tour_image_url = get_the_post_thumbnail_url($tour->ID);
        $tour_price = get_post_meta($tour->ID, '_tour_price', true);
        $place_start = get_post_meta($tour->ID, '_place_start', true);
        $place_end = get_post_meta($tour->ID, '_place_end', true);

        if ($tour_slot_remain <= 10) {
    ?>
            <!-- <div class="col-3"> -->
            <a href="./post.php?post=<?= $tour->ID ?>&action=edit" class="text-decoration-none">
                <div class="card mb-3 p-0" style="max-width: 80%;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $tour_image_url ?>" class="img-fluid rounded-start" alt="">
                        </div>
                        <div class="col-md-5 d-flex align-items-center">
                            <div class="card-body">
                                <h5 class="card-title m-0"> <?= $tour->post_title ?> </h5>
                                <p class="card-text fs-5 m-0 my-3"> <?= $place_start ?> - <?= $place_end ?> </p>
                                <p class="card-text fs-5 m-0">Remain: <?= $tour_slot_remain ?> slots</p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center">
                            <div class="card-body">
                                <p class="card-text fs-5 mb-4"><i class="bi bi-calendar2-minus me-1"></i> <?= $tour_dep_date ?> </p>
                                <span class="card-text px-3 py-2 rounded-4" style="background-color: #f2b129;"><i class="bi bi-coin"></i> <?= $tour_price ?> </span>
                            </div>
                        </div>




                        <!-- <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $tour->post_title ?></h5>
                                <p class="card-text"><?= $tour_slot_remain ?></p>
                                <p class="card-text"><small class="text-body-secondary"><?= $tour->post_date ?></small></p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </a>
            <!-- </div> -->
    <?php
        }
    }
    ?>
</div>

<h3 class="fw-bold">Upcoming tour</h3>
<select name="" id="list_option">
    <option value="0" selected>All</option>
    <option value="1">Week</option>
    <option value="2">Month</option>
</select>

<?php
$tours = get_posts(array(
    'post_type' => 'tour-management',
    'posts_per_page' => -1,
));
?>


<div class="row mb-5" id="list_tour">
    <?php
    foreach ($tours as $tour) {
        $tour_slot_remain = (int)get_post_meta($tour->ID, '_tour_slot_remain', true);
        $tour_slot_remain = get_post_meta($tour->ID, '_tour_slot_remain', true);

        $tour_dep_date_time = get_post_meta($tour->ID, '_dep_date', true);
        $tour_dep_date_stamp = strtotime($tour_dep_date_time);

        $tour_date_week = date('W', $tour_dep_date_stamp);
        $tour_date_moth = date('m', $tour_dep_date_stamp);
    ?>
        <div class="col-3 card-tour" id="card-tour" data-tour-week="<?= $tour_date_week ?>" data-tour-month="<?= $tour_date_moth ?>">
            <a href="./post.php?post=<?= $tour->ID ?>&action=edit" class="m-0 p-0" style="text-decoration: none;">
                <div class="card mb-3 mt-3 p-0 w-75">
                    <!-- <div class="row g-0">
                            <div class="d-flex align-items-center col-md-4 "> -->
                    <!-- <img src="" alt=""> -->
                    <div class="d-flex justify-content-center mt-1">
                        <?= get_the_post_thumbnail($tour->ID, array(200, 100)); ?>

                    </div>
                    <!-- </div> -->
                    <!-- <div class="col-md-8"> -->
                    <div class="card-body">
                        <h5 class="card-title"><?= $tour->post_title ?></h5>
                        <p class="card-text"><?= $tour_slot_remain ?></p>
                        <p class="card-text"><small class="text-body-secondary"><?= $tour_dep_date_time ?></small></p>
                    </div>
                    <!-- </div> -->
                    <!-- </div> -->
                </div>
            </a>
        </div>
    <?php
    }
    ?>
</div>

<!-- <h1>Choose month</h1>
<form action="" id="month_choose">
    <input type="month" name="">
    <input type="submit" value="">
</form> -->



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
        $tour->slot_remain = get_post_meta($tour->ID, '_tour_slot_remain', true);
        $tour->price = get_post_meta($tour->ID, '_tour_price', true);
        $tour->day_total = get_post_meta($tour->ID, '_day_total', true);
        $tour->place_end = get_post_meta($tour->ID, '_place_end', true);
        $tour->place_start = get_post_meta($tour->ID, '_place_start', true);

        $tour->month_date = date('Y-m', strtotime(get_post_meta($tour->ID, '_dep_date', true)));
        $cr_month_date = date('Y-m');

        // var_dump($tour->month_date);
        // var_dump($cr_month_date);
    } else {
        continue;
    }
}
// var_dump($all_tours);

// Vòng lặp để kiểm tra và xóa các phần tử
$cnt = 0;
foreach ($all_tours as $key) {
    // var_dump($key->slot_remain);
    if ($key->dep_date != '') {
?>
        <a class="text-decoration-none card-month-tour d-none" data-tour-month="<?=$key->month_date?>" href="<?= $key->post_link ?>">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $key->post_image_url ?>" class="img-fluid rounded-start" alt="...">
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
                            <p class="card-text mb-4"><i class="bi bi-people-fill me-1"></i> <?= $key->slot_remain ?> </p>
                            <p class="card-text mb-4"><i class="bi bi-calendar2-minus me-1"></i> <?= $key->dep_date ?> </p>
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


<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-links-list-table.php');

class TourTableClass extends WP_List_Table
{
    public function prepare_items()
    {
        $orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
        $order = isset($_GET['order']) ? trim($_GET['order']) : "";
        $search_content = isset($_POST['s']) ? trim($_POST['s']) : "";
        $search_content_date = isset($_POST['date_start']) ? trim($_POST['date_start']) : "";
        $search_content_date_end = isset($_POST['date_start']) ? trim($_POST['date_end']) : "";
        // echo $search_content_date;       
        // die($search_content_date);
        $this->items = $this->wp_list_table_data($orderby, $order, $search_content, $search_content_date, $search_content_date_end);
        $colums = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($colums, $hidden, $sortable);
    }

    public function wp_list_table_data($orderby = '', $order = '', $search_content = '', $search_content_date = '', $search_content_date_end = '')
    {
        global $wpdb;

        if (!empty($search_content)) {
            $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                AND p.post_title LIKE '%$search_content%'
    
                        ");
        } else {

            if ($orderby == 'title' && $order == 'desc') {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                ORDER BY post_title DESC
                            ");
            } elseif ($orderby == 'title' && $order == 'asc') {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                ORDER BY post_title ASC
                            ");
            } elseif ($orderby == 'slot_book' && $order == 'desc') {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                ORDER BY slot_book DESC
                            ");
            } elseif ($orderby == 'slot_book' && $order == 'asc') {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                ORDER BY slot_book ASC
                            ");
            } elseif ($orderby == 'date' && $order == 'desc') {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                ORDER BY date DESC
                        ");
            } elseif ($orderby == 'date' && $order == 'asc') {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                ORDER BY date ASC
                        ");
            } else {
                $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain' 
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                -- ORDER BY date ASC
    
                        ");
            }
        }
        if (!empty($search_content_date)) {
            // die($search_content_date);
            $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                                FROM wp_posts AS p
                                                JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                                JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                                JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                                WHERE p.post_type = 'tour-management'
                                                AND pm3.meta_value > '$search_content_date'

            ");
        }
        if (!empty($search_content_date) && !empty($search_content_date_end)) {
            // die($search_content_date);
            $all_posts = $wpdb->get_results("SELECT p.ID AS tour_ID, p.post_title AS tour_name, (pm1.meta_value - pm2.meta_value) AS slot_book, pm3.meta_value AS date
                                            FROM wp_posts AS p
                                            JOIN wp_postmeta AS pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_tour_slot' AND p.post_status = 'publish'
                                            JOIN wp_postmeta AS pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_tour_slot_remain'
                                            JOIN wp_postmeta AS pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_dep_date'
                                            WHERE p.post_type = 'tour-management'
                                            AND pm3.meta_value >= '$search_content_date'
                                            AND pm3.meta_value <= '$search_content_date_end'

            ");
        }


        $posts_array = array();

        if (count($all_posts) > 0) {
            foreach ($all_posts as $index => $post) {
                $posts_array[] = array(
                    "id" => $post->tour_ID,
                    "title" => $post->tour_name,
                    "slot_book" => $post->slot_book,
                    "date" => $post->date

                );
            }
        }

        return $posts_array;
    }
    public function get_hidden_columns()
    {
        # code...
        return array();
    }
    public function get_sortable_columns()
    {
        # code...
        return array(
            "title" => array("title", true),
            "slot_book" => array("slot_book", false),
            "date" => array("date", false),
        );
    }
    //get_columns
    public function get_columns()
    {
        $colums = array(
            "id" => "ID",
            "title" => "Name",
            "slot_book" => "Slot booking",
            "date" => "Slot booking"
        );
        return $colums;
    }

    public function column_default($item, $colum_name)
    {
        switch ($colum_name) {
            case 'id':
            case 'title':
            case 'slot_book':
            case 'date':
                return $item[$colum_name];
            default:
                return "No value";
        }
    }
}
function project_list_table()
{
    echo '<h3 class="fw-bold"> Statistical </h3>';
    $project_list_table = new TourTableClass();
    $project_list_table->prepare_items();
    echo "<form method='POST' class='d-flex flex-row-reverse justify-content-center' name='search_box_form' action='" . $_SERVER['PHP_SELF'] . "?page=dashboard'?>";
    $project_list_table->search_box("Search box", "search_box_id"); //===> <p> </p>

    // echo "</form>";

    // echo "<form method='POST'>";
    echo '
        <div>
            <input type="date" class="m-0" name="date_start" >
            <input type="date" class="m-0 mx-3" name="date_end" >
        </div>
    ';
    // echo '<input type="submit" name="submit" >';
    echo "</form>";

    $project_list_table->display();
}
project_list_table();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#wpcontent').addClass('overflow-x-hidden');

        jQuery('#list_option').change(function() {
            var week_cr = 0;
            week_cr = $('#curent_time').data('current-week');
            console.log("🚀 ~ jQuery ~ week_cr:", week_cr)

            var month_cr = 0;
            month_cr = $('#curent_time').data('current-month');
            console.log("🚀 ~ jQuery ~ month_cr:", month_cr);
            $('.card-tour').each(function() {
                $(this).removeClass('d-none');
            })

            // alert($(this).val());
            if ($(this).val() == 1) {
                $('.card-tour').each(function() {
                    var tour_week = $(this).data('tour-week');
                    if (tour_week != week_cr) {
                        // console.log("🚀 ~ jQuery ~ test:", typeof test)
                        $(this).addClass('d-none')
                    }
                });
            } else if ($(this).val() == 2) {
                $('.card-tour').each(function() {
                    var tour_month = $(this).data('tour-month');
                    if (tour_month != month_cr) {
                        // console.log("🚀 ~ jQuery ~ test:", typeof test)
                        $(this).addClass('d-none')
                    }
                });
            }
        })

        jQuery('#month_choose').change(function() {
            // console.log($(this).data())
            var month_date_cr = 0;
            month_date_cr = $('#month_choose').val();
            console.log(month_date_cr)

            $('.card-month-tour').each(function() {
                var tour_month = $(this).data('tour-month');
                if (tour_month == month_date_cr) {
                    $(this).removeClass('d-none');
                }
            })
        })
    })

    const ctx = document.getElementById('donut');

    var tour_labels = ['Khac', 'Trong nuoc', 'Ngoai nuoc'];
    console.log("🚀 ~ tour_labels:", tour_labels)

    var tour_data = <?= $order_data ?>;
    console.log("🚀 ~ tour_data:", tour_data)

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: tour_labels,
            datasets: [{
                label: '# of booking',
                data: tour_data,
            }]
        }
    });

    const context = document.getElementById('chart');

    var tour_labels = <?= $tour_list_name ?>;
    console.log("🚀 ~ tour_labels:", tour_labels)

    var tour_data = <?= $tour_list_book ?>;
    console.log("🚀 ~ tour_data:", tour_data)

    new Chart(context, {
        type: 'bar',
        data: {
            labels: tour_labels,
            datasets: [{
                label: '# of booking',
                data: tour_data,
                borderWidth: 0
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>