<h1>Tour</h1>
<?php
$tour_list_name = [];
$tour_list_book = [];

$all_tours = get_posts([
    'post_type' => 'tour-management',
    'post_status' => 'publish',
    'numberposts' => -1
]);
foreach($all_tours as $key) {
    array_push($tour_list_name, $key->post_title);
    // echo $key->ID;
    $tour_slot = get_post_meta($key->ID, '_tour_slot', true);
    $tour_slot_remain = get_post_meta($key->ID, '_tour_slot_remain', true);
    array_push($tour_list_book, (int)$tour_slot-$tour_slot_remain);
}


// $data = array(1,2,3,4,5,6);
$tour_list_name = json_encode($tour_list_name);
$tour_list_book = json_encode($tour_list_book);
// var_dump($data);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<canvas id="goodCanvas1" width="400" height="100" aria-label="Hello ARIA World" role="img"></canvas>

<div>
    <canvas id="myChart"></canvas>
</div>


<script src = "https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');
    
    var tour_labels = <?= $tour_list_name ?>;
    console.log("🚀 ~ tour_labels:", tour_labels)
    
    var tour_data = <?= $tour_list_book ?>;
    console.log("🚀 ~ tour_data:", tour_data)
    
    new Chart(ctx, {
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
    $project_list_table = new TourTableClass();
    $project_list_table->prepare_items();
    echo "<form method='POST' class='d-flex flex-row-reverse justify-content-center' name='search_box_form' action='" . $_SERVER['PHP_SELF'] . "?page=tour-management'?>";
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
