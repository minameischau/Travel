<?php
wp_nonce_field(basename(__FILE__), 'custom_post_metabox_nonce'); // Thêm nonce để bảo vệ form
$order_member_name = get_post_meta($post->ID, '_order_member_name', true);
$order_member_email = get_post_meta($post->ID, '_order_member_email', true);
$order_member_phone = get_post_meta($post->ID, '_order_member_phone', true);
$order_quantity = get_post_meta($post->ID, '_order_quantity', true);
$list_customer = (array)get_post_meta($post->ID, '_list_customer', true);
// $args = array(
//     'post_type' => 'order-management', // Kiểu post là 'order'
//     'posts_per_page' => -1, // Lấy tất cả các bài đăng
// );

// $orders = get_posts($args);

// echo '<pre>';
// var_dump($_GET);
// echo '</pre>';
?>

<!-- Link CSS và JS của Select2 -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->
<!-- <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script> -->

<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="order_member_name">Name</label>
    <input class="form-control" type="text" id="order_member_name" name="order_member_name" value="<?= esc_attr($order_member_name) ?>" />
</div>
<!-- // Hiển thị trường End -->
<div class="form-group">
    <label for="order_member_email">Email</label>
    <input class="form-control" type="email" id="order_member_email" name="order_member_email" value="<?= esc_attr($order_member_email) ?>" />
</div>
<!-- // Hiển thị trường Price -->
<div class="form-group">
    <label for="order_member_phone">Phone</label>
    <input class="form-control" type="tel" id="order_member_phone" name="order_member_phone" value="<?= esc_attr($order_member_phone) ?>" />
</div>

<?php
if (isset($_GET['action'])) {
    if ($list_customer == '' || count($list_customer) < $order_quantity+1) {
?>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Thêm thông tin thành viên
    </button>
<?php
} elseif (count($list_customer) >= $order_quantity+1) {
?>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" disabled>
        Thêm thông tin thành viên
    </button>
<?php
}   
}
?>
<?php
if ($list_customer != '' && count($list_customer)>1) {
?>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên</th>
            <th scope="col">Sđt</th>
            <th scope="col">Hiệu chỉnh</th>
        </tr>
        </thead>
        <tbody>
        
        <?php
            foreach ($list_customer as $i => $key):        
                // print_r($key);        
                // echo $key['name'];         
                if ($i==0) {
                    continue;
                }              
            ?> 
        
        <tr>    
            <th scope="row"><?= ($i) ?></th>    
            <td><?= $list_customer[$i]['name'] ?></td>    
            <td><?= $list_customer[$i]['phone'] ?></td>    
            <td>    
            <span class="btn btn-sm btn-warning btn-edit-customer" data-toggle="modal" data-target="#exampleModal" id="<?= $i ?>">    
                Sửa      
            </span>    
            <button class="btn btn-sm btn-danger btn-del-customer" id="<?= $i ?>">    
                Xóa      
            </button> 
        </td>    
        </tr> 
        
        <?php
            endforeach;
            
            ?>
        
        </tbody>
        
    </table>
<?php
}
?>    

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thông tin </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
            <label for="order_mem_cus_name">Tên thành viên</label>
            <input class="form-control" type="text" id="order_mem_cus_name" name="order_mem_cus_name" value="" />
        </div>
        <div class="form-group">
            <label for="order_mem_cus_phone">Số điện thoại</label>
            <input class="form-control" type="tel" id="order_mem_cus_phone" name="order_mem_cus_phone" value="" />
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="save_cus">Save changes</button>
        <input type="hidden" id="order_ID_edit" value="">   

      </div>
    </div>
  </div>
</div>


<script>
    jQuery(document).ready(function($) {
        $('#save_cus').click(function(){
            // alert("MY khum")
            const name = $('#order_mem_cus_name').val();
            const phone = $('#order_mem_cus_phone').val();
            const cusID = $('#order_ID_edit').val();
            // alert(cusID);
            $.ajax({
                
                type: "post",
                url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                data: {
                    action: "save_customer",
                    name : name,
                    phone : phone,
                    customer_ID: cusID,
                    order_ID: '<?= $post->ID ?>'
                }, 
                success: function(response) {
                //     //Làm gì đó khi dữ liệu đã được xử lý
                    if(response.success) {
                        console.log(response.data);
                        // var_dump(response.data);
                    }
                //     else {
                //         alert('Đã có lỗi xảy ra');
                //     }

                },
            })
        });

        $('.btn-edit-customer').click(function() {
            const customer_ID = $(this).attr('id');
            // alert(customer_ID)
            $.ajax({
                type: "post",
                url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                data: {
                    action: "edit_customer",
                    customer_ID: customer_ID,
                    order_ID: '<?= $post->ID ?>'
                }, 
                success: function(response) {
                    //Làm gì đó khi dữ liệu đã được xử lý
                    if(response.success) {
                        console.log(response.data);
                        $('#order_mem_cus_name').attr('value', response.data['name']);
                        $('#order_mem_cus_phone').attr('value', response.data['phone'])
                        $('#order_ID_edit').attr('value', response.data['id'])
                    }
                    else {
                        alert('Đã có lỗi xảy ra');
                    }

                },
            })
        });

        $('.btn-del-customer').click(function() {
            const customer_ID = $(this).attr('id');
            alert(customer_ID)
            $.ajax({
                type: "post",
                url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                data: {
                    action: "del_customer",
                    customer_ID: customer_ID,
                    order_ID: '<?= $post->ID ?>'
                }, 
                // success: function(response) {
                //     //Làm gì đó khi dữ liệu đã được xử lý
                //     if(response.success) {
                //         console.log(response.data);                    }
                //     else {
                //         alert('Đã có lỗi xảy ra');
                //     }

                // },
            })
        });

        // $('#publish').click(function() {
        //     $.ajax({
        //         type: "post",
        //         url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
        //         data: {
        //             action: "publish_ord",
        //             state: '<?= $_GET['action']?>',
        //             order_ID: <?= $post->ID ?>
        //         }, 
        //         success: function(response) {
        //             //Làm gì đó khi dữ liệu đã được xử lý
        //             if(response.success) {
        //                 console.log(response.data);
                       
        //             }
        //             else {
        //                 alert('Đã có lỗi xảy ra');
        //             }

        //         },
        //     })
        // });
        
        // Chọn form bạn muốn áp dụng jQuery Validate
        $('#post').validate({
            rules: {
                // Các quy tắc kiểm tra cho từng trường input
                order_member_name: {
                    required: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                // Thêm các trường input khác và quy tắc kiểm tra tương ứng
                order_member_email: {
                    required: true,
                    email: true,
                    // Thêm các quy tắc kiểm tra khác
                },
                order_member_phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                    // Thêm các quy tắc kiểm tra khác
                },
            },
            messages: {
                // Các thông báo lỗi tương ứng với từng trường input
                order_member_name: {
                    required: "This option is required",
                    // Thêm các thông báo lỗi khác
                },
                // Thêm các trường input khác và thông báo lỗi tương ứng
                order_member_email: {
                    required: "This field is required",
                    email: "Please enter a valid email address"
                    // Thêm các thông báo lỗi khác
                },
                order_member_phone: {
                    required: "This field is required",
                    digits: "Please enter a valid number phone",
                    minlength: "Please enter a valid number phone",
                    maxlength: "Please enter a valid number phone"
                    // pattern: "Please enter a valid phone number"
                    // Thêm các thông báo lỗi khác
                },
            },
            // Cấu hình và tùy chọn khác cho jQuery Validate
        });
});

</script>

<style>
    /* Đổi màu sắc cho thông báo lỗi */
    label.error {
        color: red;
    }

    /* Đổi màu sắc cho khung bao quanh input */
    input.error {
        border-color: red;
    }
</style>