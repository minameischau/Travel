<?php
wp_nonce_field(basename(__FILE__), 'custom_post_metabox_nonce'); // Thêm nonce để bảo vệ form
$order_member_name = get_post_meta(get_the_ID(), '_order_member_name', true);
$order_member_email = get_post_meta(get_the_ID(), '_order_member_email', true);
$order_member_phone = get_post_meta(get_the_ID(), '_order_member_phone', true);
$order_status = get_post_meta(get_the_ID(), '_order_status', true);
$order_quantity = get_post_meta(get_the_ID(), '_order_quantity', true);
$list_customer = (array)get_post_meta(get_the_ID(), '_list_customer', true);
// $args = array(
//     'post_type' => 'order-management', // Kiểu post là 'order'
//     'posts_per_page' => -1, // Lấy tất cả các bài đăng
// );

// $orders = get_posts($args);

// echo '<pre>';
// var_dump(count($list_customer)-1);
// var_dump((int)$order_quantity);
// var_dump($order_status == '-1');
// var_dump((count($list_customer)-1) < (int)$order_quantity);
// echo '</pre>';
?>
<?php
if ($list_customer != '' && count($list_customer) > 1) {
?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($list_customer as $i => $key) :
                // print_r($key);        
                // echo $key['name'];         
                if ($i == 0) {
                    continue;
                }
            ?>

                <tr>
                    <th scope="row"><?= ($i) ?></th>
                    <td><?= $list_customer[$i]['name'] ?></td>
                    <td><?= $list_customer[$i]['phone'] ?></td>
                    <td class="d-flex">
                        <p class="btn btn-sm btn-warning btn-edit-customer-theme" data-bs-toggle="modal" data-bs-target="#exampleModal" id="<?= $i ?>">
                            Edit
                        </p>
                        <button class="btn btn-sm btn-danger btn-del-customer-theme ms-3" id="<?= $i ?>">
                            Delete
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
if ($order_status == '-1' || (count($list_customer) - 1) >= (int)$order_quantity) {
?>
    <button disabled data-bs-toggle="modal" data-bs-target="#exampleModal" class="border-0 px-3 py-2 text-white fw-bold" style="background-color: #f2b129; opacity: 0.5;">Add member</button>
<?php
} elseif ($order_status == '1' || $order_status == '0') {
?>
    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="border-0 px-3 py-2 text-white fw-bold" style="background-color: #f2b129;">Add member</button>
<?php
}
?>
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add member
</button> -->

<!-- Modal -->
<form action="" id="member_infor">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Member information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="order_mem_cus_name_theme">Member name</label>
                        <input class="form-control" type="text" id="order_mem_cus_name_theme" name="order_mem_cus_name_theme" value="" />
                    </div>
                    <div class="form-group">
                        <label for="order_mem_cus_phone_theme">Member phone</label>
                        <input class="form-control" type="tel" id="order_mem_cus_phone_theme" name="order_mem_cus_phone_theme" value="" />
                    </div>

                    <input id="order_id" type="hidden" value="<?= get_the_ID() ?>">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="save_member_in4" type="submit" class="btn btn-primary">Save changes</button>
                    <input type="hidden" id="order_ID_edit_theme" value="">

                </div>
            </div>
        </div>
    </div>
</form>