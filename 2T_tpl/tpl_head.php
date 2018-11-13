<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $config_site['name'];?> Hệ thống M05</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="<?php echo $config_site['url'];?>/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $config_site['url'];?>/plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.7/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/css/style.css" rel="stylesheet">
    <link href="<?php echo $config_site['url'];?>/css/themes/all-themes.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/plugins/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/plugins/ion-rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" />
    <link href="<?php echo $config_site['url'];?>/css/custom.css" rel="stylesheet">
    <style type="text/css">
        .table td {
           text-align: center;
        }
        .table th {
           text-align: center;
        }
    </style>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        const   CURRENT_URL = document.URL;
                prefix      = '2T_',
                modun       = 'modun';
    </script>
</head>

<body class="theme-blue-grey">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="loader-inner">
                <div class="loading one"></div>
            </div>
            <div class="loader-inner">
                <div class="loading two"></div>
            </div>
            <div class="loader-inner">
                <div class="loading three"></div>
            </div>
            <div class="loader-inner">
                <div class="loading four"></div>
            </div>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php"><?php echo $config_site['name'];?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info bg-blue-grey" style="background-image: none;">
                <div class="image">
                    <img src="images/user1.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['fullname'];?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">perm_identity</i><?php echo $_SESSION['username'];?></a></li>
                            <li role="seperator" class="divider"></li>
                            <!--<li><a href="javascript:void(0);"><i class="material-icons">monetization_on</i><?php /*echo number_format($_SESSION['vnd']);*/?> Cash</a></li>
                            <li role="seperator" class="divider"></li>-->
                            <li><a href="?act=change-pass"><i class="material-icons">change_history</i>Đổi Mật Khẩu</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="logout.php"><i class="material-icons">input</i>Đăng Xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">DANH MỤC CHỨC NĂNG</li>
                    <li class="active">
                        <a href="index.php">
                            <i class="material-icons">home</i>
                            <span>TRANG CHỦ</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">thumb_up</i>
                            <span>CHỨC NĂNG CHÍNH</span>
                        </a>
                        <ul class="ml-menu">
							<li>
                                <a href="?act=add-group">TẠO NHÓM</a>
                            </li>
                            <li>
                                <a href="?act=add-target">THÊM ĐỐI TƯỢNG</a>
                            </li>
							<li>
                                <a href="?act=search-post">TÌM BÀI VIẾT THEO TỪ KHÓA</a>
                            </li>
                            <li>
                                <a href="?act=manage-target">QUẢN LÝ ĐỐI TƯỢNG</a>
                            </li>
							<li>
                                <a href="?act=add-feed-site">THÊM TRANG LẤY TỪ KHÓA</a>
                            </li>
                        </ul>
                    </li>
                    <?php if(isset($_SESSION['admin'])){ ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">person_pin</i>
                            <span>QUẢN TRỊ VIÊN</span>
                        </a>
                        <ul class="ml-menu">
									<li>
										<a href="?act=manage-member"><span>QUẢN LÝ THÀNH VIÊN</span></a>
									</li>  
                                    <li>
										<a href="?act=access-token"><span>KT & THÊM TOKEN</span></a>
									</li>
									 <li>
										<a href="?act=del-access-token"><span>XÓA TOKEN DIE</span></a>
									</li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2018 <a href="javascript:void(0);">Developed by Mario</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>