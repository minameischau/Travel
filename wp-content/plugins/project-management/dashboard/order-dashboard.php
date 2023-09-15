<h1>Order</h1>

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
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">




<div style="width: 500px;">
    <canvas id="myChart"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');

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
</script>