
<head>
    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- font awesom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- pagiantion -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <style>
        input::placeholder {
            color: #ccc;
            font-size: 1rem;
        }

        /* Đổi màu sắc cho thông báo lỗi */
        label.error {
            color: red;
        }

        /* Đổi màu sắc cho khung bao quanh input */
        input.error {
            border-color: red;
        }
    </style>

</head>

<?php
// function add_jquery_cdn() {
// 	// Thêm link CDN Bootstrap CSS
//     wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');

//     // Thêm link CDN Bootstrap JS
//     wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);

// 	// Thêm link CDN jQuery
// 	wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js', array(), '3.7.0', true);

// 	//Ajax
// 	wp_enqueue_script('ajax-script', '');
// }

// add_action('wp_enqueue_scripts', 'add_jquery_cdn');