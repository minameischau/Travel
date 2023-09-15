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

<?php $link = plugin_dir_url(__FILE__) . 'img/rose_cool.png' ?>

<form action="" class="m-0 p-0" style="max-width: 100vw ;" id="signup">
    <div class="d-flex align-items-center m-0" style="height: 95vh; max-width: 100vw;">
        <div class="row mx-auto my-auto rounded-4 overflow-hidden" style="width: 75%; ; border: 1px solid #ccc;">
            <div class="col-7 p-0" style="background-color: #3949AB;">
                <img style="width: 55%;" src="<?= $link ?>" alt="">
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center col-5">
                <h4 class="text-center mb-4">Welcome</h4>
                <div class="w-75 ">
                    <i class="text-secondary bi bi-envelope-fill position-absolute pt-3 ps-3"></i>
                    <input name="mail" placeholder="Enter your email" type="email" id="mail" class="ps-5 pe-3 my-1 rounded-5" style="border: 1px solid #ccc; ">
                </div>
                <div class="w-75">
                    <i class="text-secondary bi bi-key-fill position-absolute pt-3 ps-3"></i>
                    <input name="pass" placeholder="Enter your password" type="password" id="pass" class="ps-5 pe-3 my-1 rounded-5" style="border: 1px solid #ccc; ">
                </div>
                <div class="w-75">
                    <i class="text-secondary bi bi-key-fill position-absolute pt-3 ps-3"></i>
                    <input name="cpass" placeholder="Enter your password" type="password" id="pass" class="ps-5 pe-3 my-1 rounded-5" style="border: 1px solid #ccc; ">
                </div>
                <input type="submit" id="signupi" class="w-75 mt-4 rounded-5" value="Sign up">
                <a class="text-decoration-none" style="margin-top:  6rem;" href="http://localhost/wordpress/signin/">Login now <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        
        $('#signup').validate({
            
            rules: {
                mail: {
                    required: true,
                    email: true,
                },
                pass: {
                    required: true,
                },
                cpass: {
                    required: true,
                    equalTo: '#pass'
                }
            },
            messages: {
                mail: {
                    required: "This field is required"
                },
                pass: {
                    required: "This field is required",
                },
                cpass: {
                    required: "This field is required",
                    equalTo: "Please enter a valid password"
                }
            }
        });
        $('#signupi').click(function(e) {
            e.preventDefault()
            const email = $('#mail').val();
            const password = $('#pass').val();
            console.log("🚀 ~ $ ~ password:", password)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "http://localhost/wordpress/wp-admin/admin-ajax.php",
                data: {
                    action: 'signup',
                    email: email,
                    password: password,
                },
                context: this,
                success: function(response) {
                    console.log(response.data)
                    if (response.data == 'true') {
                        window.location.href = 'http://localhost/wordpress/signin/'
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('The following error occured: ' + textStatus, errorThrown);
                }
            })
        });
    })
</script>