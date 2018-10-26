<?php
session_start();
error_reporting(0);
require_once '2T_config/config_server.php';

if($_SESSION['login']){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $config_site['name'];?> Đăng Ký Tài Khoản</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta property="og:url" content="http://fbvips.thien-it.tech" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $config_site['name'];?> M05" />
    <meta property="og:description" content="<?php echo $config_site['name'];?> Hệ thống M05." />
    <meta property="og:image" content="https://i.imgur.com/5udfl5q.png" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <style type="text/css">
        body {
            background: url('https://i.imgur.com/h26OJMi.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
        }
    </style>
    <script type="text/javascript">
        const   CURRENT_URL = document.URL,
                prefix      = '2T_',
                modun       = 'modun';
    </script>
</head>

<body class="signup-page">
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php echo $config_site['name'];?><b> VIP</b></a>
            <small>Hệ thống M05</small>
        </div>
        <div class="card" style="background: rgba(255, 255, 255, 0.88);">
            <div class="body">
                <form id="sign_up" method="POST">
                    <div class="msg">Đăng Ký Thành Viên Mới</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Tên Đầy Đủ" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Tài Khoản" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Địa Chỉ Email" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" id="password" minlength="6" placeholder="Mật Khẩu" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirm" id="confirm" minlength="6" placeholder="Nhập Lại Mật Khẩu" required>
                        </div>
                    </div>


                    <button class="btn btn-block btn-lg bg-green waves-effect" type="button" id="btn" onclick="signup()"><i class="fa fa-user-circle" aria-hidden="true"></i> ĐĂNG KÝ</button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="sign-in.php">Bạn đã có tài khoản. Bạn muốn đăng nhập?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script type="text/javascript">
        $("input").keyup(function(e){
            if(e.keyCode == 13){
                signup();
            }
        });
        function signup(){
            var fullname = $("#fullname").val();
            var username = $("#username").val();
            var email   = $("#email").val();
            var password= $("#password").val();
            var confirm = $("#confirm").val();
            if (!fullname || !username || !email || !password) {
                showNotification('bg-red', 'Vui Lòng Điền Đầy Đủ Thông Tin');
                return;
            } else {
                console.log(password);
                console.log(confirm);
                if(password !== confirm){
                    showNotification('bg-red', 'Nhập Lại Mật Khẩu Không Đúng. Vui Lòng Kiểm Tra Lại');
                    return;
                }
            }
            if(true){
               if (true) {
                    $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
                    $.ajax({
                        url     : prefix+modun+ '/modun_post.php',
                        type    : 'POST',
                        dataType: 'JSON',
                        data    : {
                            t        : 'sign-up',
                            fullname : fullname,
                            username : username,
                            email    : email,
                            password : password,

                        },
                        success: (data) => {
                            $("#btn").html('<i class="fa fa-user-circle" aria-hidden="true"></i> ĐĂNG KÝ');
                            if (data.error) {
                                showNotification('bg-red', data.msg);
                            } else {
                                showNotification('bg-green', data.msg);
                                $("input").val('');
                            }
                            grecaptcha.reset();
                        }
                    })
                } else {
                    showNotification('bg-red', 'Vui Lòng Xác Nhận reCaptcha!');
                }
            } else {
                showNotification('bg-red', 'Vui Lòng Đồng Ý Điều Khoản Và Chính Sách Sử Dụng!');
            }
        }
        function showNotification(colorName, text) {
            if (colorName === null || colorName === '') { colorName = 'bg-black'; }
            if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
            var allowDismiss = true;
            $.notify({
                message: text
            },
            {
                type: colorName,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                timer: 1000,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated fadeOutUp'
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
        }
    </script>
</body>

</html>