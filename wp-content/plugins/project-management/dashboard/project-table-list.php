<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
$args = array(
    'post_type' => 'tour-management', // Kiểu post là 'order'
    'posts_per_page' => -1, // Lấy tất cả các bài đăng
    'meta_key' => '_tour_slot',
);
$tours = get_posts($args);
echo '<pre>';
// print_r($tours); 
// var_dump($tours);
echo '</pre>';
// $sum_total = 0;
// foreach ($orders as $ord):
//     // $sum_total += $ord->_order_total;
//     $order_tourID = get_post_meta($ord->ID, '_order_tourID', true);
//     $term_tax_id = get_the_terms($order_tourID, 'tour-cate');
//     $slug_term = $term_tax_id[0]->slug;
//     if ($slug_term === 'khac') {
//         $sum_total = $sum_total + 1;
//     }
// echo '<pre>';
// print_r($term_tax_id[0]->slug); 
// echo '</pre>';

// print_r("===");

// $sum_total = $sum_total + (int)$order_meta_price;
// endforeach;
//     var_dump($sum_total);
?>
<script>
    $(document).ready(function() {
        $('form p').addClass('d-flex ml-1')
    })
</script>
<h1 class="mt-3" style="text-align: center; font-weight: 800;">Dashboard</h1>
<h3 style="font-weight: 700;">Tour booking trend</h3>
<div class="row justify-content-between w-100">
    <div class="card p-1" style="width: 15rem; padding: 0px;">
        <div class="card-body row">
            <span class="col-4 d-flex align-items-center col-4">
                <!-- <img width="50" src="https://img.icons8.com/fluency/48/money-bag.png" alt="money-bag" /> -->
                <i class="bi bi-cloud-haze2-fill" style="font-size: 50px; color: #219ebc;"></i>
                <?php
                $args = array(
                    'post_type' => 'order-management', // Kiểu post là 'order'
                    'posts_per_page' => -1, // Lấy tất cả các bài đăng
                );

                $orders = get_posts($args);
                $sum_total = 0;
                foreach ($orders as $ord) :
                    $order_tourID = get_post_meta($ord->ID, '_order_tourID', true);
                    $term_tax_id = get_the_terms($order_tourID, 'tour-cate');
                    $slug_term = $term_tax_id[0]->slug;
                    if ($slug_term === 'khac') {
                        $sum_total = $sum_total + 1;
                    }
                endforeach;
                // var_dump($sum_total);
                ?>

            </span>
            <span class="d-flex flex-column align-items-center col-8">
                <h3> <?= $sum_total ?></h3>
                <h6>Khác</h6>
            </span>
        </div>
    </div>

    <div class="card" style="width: 15rem; padding: 0px;">
        <div class="card-body row">
            <span class="col-4 d-flex align-items-center col-4">
                <!-- <img width="50" src="https://img.icons8.com/fluency/48/money-bag.png" alt="money-bag" /> -->
                <i class="bi bi-geo-fill" style="font-size: 50px; color: #e76f51;"></i>
                <?php
                $args = array(
                    'post_type' => 'order-management', // Kiểu post là 'order'
                    'posts_per_page' => -1, // Lấy tất cả các bài đăng
                );

                $orders = get_posts($args);
                $sum_total = 0;
                foreach ($orders as $ord) :
                    $order_tourID = get_post_meta($ord->ID, '_order_tourID', true);
                    $term_tax_id = get_the_terms($order_tourID, 'tour-cate');
                    $slug_term = $term_tax_id[0]->slug;
                    if ($slug_term === 'trong-nuoc') {
                        $sum_total = $sum_total + 1;
                    }
                endforeach;
                // var_dump($sum_total);
                ?>

            </span>

            <span class="d-flex flex-column align-items-center col-8">
                <h3> <?= $sum_total ?></h3>
                <h6>Trong nước</h6>
            </span>
        </div>
    </div>


    <div class="card" style="width: 15rem; padding: 0px;">
        <div class="card-body row">
            <span class="col-4 d-flex align-items-center col-4">
                <!-- <img width="50" src="https://img.icons8.com/fluency/48/money-bag.png" alt="money-bag"/> -->
                <i class="bi bi-airplane-engines-fill" style="font-size: 50px; color: #48cae4;"></i>
                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-airplane-engines-fill" viewBox="0 0 16 16">
                    <path d="M8 0c-.787 0-1.292.592-1.572 1.151A4.347 4.347 0 0 0 6 3v3.691l-2 1V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.191l-1.17.585A1.5 1.5 0 0 0 0 10.618V12a.5.5 0 0 0 .582.493l1.631-.272.313.937a.5.5 0 0 0 .948 0l.405-1.214 2.21-.369.375 2.253-1.318 1.318A.5.5 0 0 0 5.5 16h5a.5.5 0 0 0 .354-.854l-1.318-1.318.375-2.253 2.21.369.405 1.214a.5.5 0 0 0 .948 0l.313-.937 1.63.272A.5.5 0 0 0 16 12v-1.382a1.5 1.5 0 0 0-.83-1.342L14 8.691V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v.191l-2-1V3c0-.568-.14-1.271-.428-1.849C9.292.591 8.787 0 8 0Z" />
                </svg> -->

                <?php
                $args = array(
                    'post_type' => 'order-management', // Kiểu post là 'order'
                    'posts_per_page' => -1, // Lấy tất cả các bài đăng
                );

                $orders = get_posts($args);
                $sum_total = 0;
                foreach ($orders as $ord) :
                    $order_tourID = get_post_meta($ord->ID, '_order_tourID', true);
                    $term_tax_id = get_the_terms($order_tourID, 'tour-cate');
                    $slug_term = $term_tax_id[0]->slug;
                    if ($slug_term === 'ngoai-nuoc') {
                        $sum_total = $sum_total + 1;
                    }
                endforeach;
                // var_dump($sum_total);
                ?>

            </span>
            <span class="d-flex flex-column align-items-center col-8">
                <h3> <?= $sum_total ?></h3>
                <h6>Ngoài nước</h6>
            </span>
        </div>
    </div>

    <div class="card" style="width: 15rem; padding: 0px;">
        <div class="card-body row">
            <span class="col-4 d-flex align-items-center col-4">
                <!-- <img width="50" src="https://img.icons8.com/fluency/48/money-bag.png" alt="money-bag" /> -->
                <i class="bi bi-currency-exchange" style="font-size: 50px; color: #fee440;"></i>
                <?php
                $args = array(
                    'post_type' => 'order-management', // Kiểu post là 'order'
                    'posts_per_page' => -1, // Lấy tất cả các bài đăng
                );

                $orders = get_posts($args);
                $sum_total = 0;
                foreach ($orders as $ord) :
                    // $sum_total += $ord->_order_total;
                    $order_cate = get_post_meta($ord->ID, '_order_total', true);
                    // var_dump($order_cate);

                    $sum_total = $sum_total + (int)$order_cate;
                endforeach;
                // var_dump($sum_total);
                ?>

            </span>
            <span class="d-flex flex-column align-items-center col-8">
                <h3> <?= $sum_total ?></h3>
                <h6>Doanh thu</h6>
            </span>
        </div>
    </div>

</div>
<h3 class="mt-5 mb-0" style="font-weight: 700;">Quantity statistics</h3>

<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class ProjectTableClass extends WP_List_Table
{
    //define dataset for WP_list_table => data

    //prepare_items
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
    public function wp_list_table_data($orderby = '', $order = '', $search_content = '', $search_content_date = '', $search_content_date_end='')
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
    $project_list_table = new ProjectTableClass();

    //calling prepare_items
    $project_list_table->prepare_items();
    echo "<form method='POST' class='d-flex flex-row-reverse justify-content-center' name='search_box_form' action='" . $_SERVER['PHP_SELF'] . "?page=toursubmenu'?>";
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