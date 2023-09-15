jQuery(document).ready(function ($) {
    $('#customer_infor').validate({
        rules: {
            cus_name: { required: true, },
            cus_phone: { required: true, },
            cus_quantity: {
                required: true,
                min: 1,
            }
        },
        messages: {
            cus_name: { required: "This field is required" },
            cus_phone: { required: "This field is required" },
            cus_quantity: {
                required: "This field is required",
                min: "Please enter a valid number",
            }
        }
    });
    $('#member_infor').validate({
        rules: {
            order_mem_cus_name_theme: { required: true, },
            order_mem_cus_phone_theme: { 
                required: true,
                matches: "[0-9]+", 
                minlength: 10,
                maxlength: 10
            },
            
        },
        messages: {
            order_mem_cus_name_theme: { required: "This field is required" },
            order_mem_cus_phone_theme: { 
                required: "This field is required",
                matches: "right",
                minlength: "Just number",
                maxlength: "Just number"
            },
            
        }
    });

    $('.card>p').addClass('d-none');
    $('.g-0>p').addClass('d-none');

    $('#signout').click(function () {
        $.ajax({
            type: 'post',
            url: 'http://localhost/wordpress/wp-admin/admin-ajax.php',
            data: {
                action: 'signout',
            },
            success: function (response) {
                // location.reload();
                window.location.href = 'http://localhost/wordpress/'

            }
        })
    });

    var content = $('#wp-block-search__input-20').val();
    $.ajax({
        type: 'POST',
        url: 'http://localhost/wordpress/wp-admin/admin-ajax.php',
        data: {
            action: 'search_tours',
            content: content
        },
        success: function (response) {
            htmlContainer = $('#all-tours-render');

            // console.log(response.data);
            response.data.forEach(item => {
                // console.log(element.ID);
                var html_test = '<a class="text-decoration-none" href="' + item.post_link + '">' +
                    '<div class="card mb-3">' +
                    '<div class="row g-0">' +
                    '<div class="col-md-4">' +
                    '<img src="' + item.post_image_url + '" class="img-fluid rounded-start" alt="...">' +
                    '</div>' +
                    '<div class="col-md-5 d-flex align-items-center">' +
                    '<div class="card-body">' +
                    '<h5 class="card-title m-0"> ' + item.post_title + ' </h5>' +
                    '<p class="card-text m-0 my-3"> ' + item.place_start + ' - ' + item.place_end + ' </p>' +
                    '<p class="card-text m-0">Estimate: ' + item.day_total + ' days</p>' +
                    '</div>' +
                    '</div>' +

                    '<div class="col-md-3 d-flex align-items-center">' +
                    '<div class="card-body">' +
                    '<p class="card-text mb-4"><i class="bi bi-calendar2-minus"></i> ' + item.dep_date + ' </p>' +
                    '<span class="card-text px-3 py-2 rounded-4" style="background-color: #f2b129;"><i class="bi bi-coin"></i> ' + item.price + ' </span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</a>'
                htmlContainer.append(html_test);
            });
        }
    });

    // -----BOOK NOW -----
    $('button br').addClass('d-none');
    $('#book_now_btn br').addClass('d-none');
    $('#save_customer_infor').click(function (e) {
        const email = $('#cus_mail').val();
        console.log("🚀 ~ $ ~ email:", email)
        const name = $('#cus_name').val();
        console.log("🚀 ~ $ ~ name:", name)
        const phone = $('#cus_phone').val();
        console.log("🚀 ~ $ ~ phone:", phone)
        const payment = $('#cus_payment').val();
        console.log("🚀 ~ $ ~ payment:", payment)
        const quantity = $('#cus_quantity').val();
        console.log("🚀 ~ $ ~ quantity:", quantity)
        const tourID = $('#tourID').val();
        console.log("🚀 ~ $ ~ tourID:", tourID)
        const tour_slot_remain = $('#tour_slot_remain').val();
        console.log("🚀 ~ $ ~ tour_slot_remain:", tour_slot_remain)
        if (quantity != '' && name != '' && phone != '' && payment != ''){
            $.ajax({
                type: 'POST',
                // dataType: 'json',
                url: 'http://localhost/wordpress/wp-admin/admin-ajax.php',
                data: {
                    action: 'save_cusomter_theme',
                    email: email,
                    name: name,
                    phone: phone,
                    payment: payment,
                    quantity: quantity,
                    tourID: tourID,
                    tour_slot_remain: tour_slot_remain
                },
                context: this,
                success: function (response) {
                    e.preventDefault();

                    console.log(response.data);
                    // location.reload();
                    // console.log('http://localhost/wordpress/orderlist/'+response.data);
                    window.location.href = 'http://localhost/wordpress/order/' + response.data

                },
                // error: function(jqXHR, textStatus, errorThrown) {
                //     console.log('The following error occured: ' + textStatus, errorThrown);
                // },
            })
        }
        
    });

    $('#save_member_in4').click(function (e) {
        const name = $('#order_mem_cus_name_theme').val();
        const phone = $('#order_mem_cus_phone_theme').val();
        const cusID = $('#order_ID_edit_theme').val();
        const order_id = $('#order_id').val();
        // alert(cusID);

        if (name != '' && phone != '') {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'http://localhost/wordpress/wp-admin/admin-ajax.php',
                data: {
                    action: 'save_member_in4',
                    name: name,
                    phone: phone,
                    customer_ID: cusID,
                    order_id: order_id
                },
                success: function (response) {
                    location.reload();
                    // alert(response.data)
                }
            })
        }
    });

    $('.btn-del-customer-theme').click(function () {
        const customer_ID = $(this).attr('id');
        const order_id = $('#order_id').val();
        // alert(customer_ID)
        $.ajax({
            type: "post",
            url: 'http://localhost/wordpress/wp-admin/admin-ajax.php', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
            data: {
                action: "del_customer_theme",
                customer_ID: customer_ID,
                order_id: order_id
            },
            success: function (response) {
                location.reload();

                //     //Làm gì đó khi dữ liệu đã được xử lý
                //     if(response.success) {
                //         console.log(response.data);                    }
                //     else {
                // alert('Đã có lỗi xảy ra');
                // }

            },
        })
    });

    $('.btn-edit-customer-theme').click(function () {
        const customer_ID = $(this).attr('id');
        const order_id = $('#order_id').val();

        // alert(customer_ID)
        $.ajax({
            type: "post",
            url: 'http://localhost/wordpress/wp-admin/admin-ajax.php', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
            data: {
                action: "edit_customer_theme",
                customer_ID: customer_ID,
                order_id: order_id
            },
            success: function (response) {
                //Làm gì đó khi dữ liệu đã được xử lý
                if (response.success) {
                    console.log(response.data);
                    $('#order_mem_cus_name_theme').attr('value', response.data['name']);
                    $('#order_mem_cus_phone_theme').attr('value', response.data['phone'])
                    $('#order_ID_edit_theme').attr('value', response.data['id'])
                }
                else {
                    alert('Đã có lỗi xảy ra');
                }

            },
        })
    });

    $('#cancel-order').click(function () {
        const order_id = $('#order_id').val();
        console.log("🚀 ~ order_id:", order_id);
        const order_quantity = $('#order_quantity').html();
        console.log("🚀 ~ order_quantity:", order_quantity);
        
        $.ajax({
            type: 'POST',
            url: 'http://localhost/wordpress/wp-admin/admin-ajax.php',
            data: {
                action: 'cancel_order',
                order_id: order_id,
                order_quantity: order_quantity,
            },
            success: function (response) {
                console.log(response.data)
                location.reload()
            }
        })
    });
});