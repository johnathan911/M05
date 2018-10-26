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
    <title><?php echo $config_site['name'];?> Hệ Thống M05</title>
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

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php echo $config_site['name'];?></a>
            <small>Hệ Thống M05</small>
        </div>
        <div class="card" style="background: rgba(255, 255, 255, 0.88);">
            <div class="body">
                <form id="sign_in" method="POST">
                    <div class="msg">Đăng Nhập Để Bắt Đầu Phiên Của Bạn</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Tên Tài Khoản" required autofocus>
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
                    <div class="row">
                        <div class="col-xs-7 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-green">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-5">
                            <button class="btn btn-block bg-green waves-effect" type="button" id="btn" onclick="signin()"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng Nhập</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-12">
                            <a href="sign-up.php">Đăng Ký Tài Khoản</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script type="text/javascript">
        $("input").keyup(function(e){
            if(e.keyCode == 13){
                signin();
            }
        });
        function signin(){
            var username = $("#username").val();
            var password= $("#password").val();
            if (!username || !password) {
                showNotification('bg-red', 'Vui Lòng Điền Đầy Đủ Thông Tin');
                return;
            }
            $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t       : 'sign-in',
                    username      : username,
                    password : password,
                },
                success: (data) => {
                    $("#btn").html('<i class="fa fa-sign-in" aria-hidden="true"></i> Đăng Nhập');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        setTimeout(function(){
                             window.location = CURRENT_URL;
                        },1000);
                    }
                }
            })
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