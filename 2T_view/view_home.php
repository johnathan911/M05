<?php
$src = file_get_contents('2T_modun/notify.txt');
$arr_src = explode("\n", $src);
$htmlNotify = '';
for ($i=count($arr_src)-2; $i >= 0; $i--) {
    $notify = explode("||", $arr_src[$i]);
    $img = '<i class="fa fa-bullhorn" aria-hidden="true"></i>';
    if ($i == count($arr_src)-2) {
        $img = '<img src="images/hotqua.gif" /> ';
    }
    if ($i == count($arr_src)-3) {
        $img = '<img src="images/hot.gif" /> ';
    }
    if ($i == count($arr_src)-4) {
        $img = '<img src="images/new.png" /> ';
    }
    $htmlNotify .= '<div class="listbox-content-item">
                    <p>'.$img.' '.$notify[0].'</p>
                    <i class="fa fa-calendar"></i> '.$notify[1].'</span>
                </div>';
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card animated bounceIn">
                    <div class="header">
                        <h2>
                           <i class="fa fa-bars" aria-hidden="true"></i> Menu Chức Năng<small>Chức năng của hệ thống</small>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="content">
                                        <div class="number">ADD GROUP</div>
                                        <a href="?act=add-group" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">add</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="content">
                                        <div class="number">ADD TARGET</div>
                                        <a href="?act=add-target" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">add</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="content">
                                        <div class="number">Manage Target</div>
                                        <a href="?act=manage_target" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">add</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="icon">
                                        <i class="material-icons">share</i>
                                    </div>
                                    <div class="content">
                                        <div class="number">VIP SHARE</div>
                                        <button type="button" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </button>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($_SESSION['admin'] == 1 ): ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card animated bounceIn">
                    <div class="header">
                        <h2>
                           <i class="fa fa-bars" aria-hidden="true"></i> Thống Kê Hệ Thống<small>Thống kê chi tiết hệ thống cho admin</small>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Danh Mục</th>
                                            <th>Chi Tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Token Hệ Thống</td>
                                            <td><span class="label bg-green"><?php echo count_sys('access_token');?></span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Tổng số Thành viên</td>
                                            <td><span class="label bg-green"><?php echo count_sys('member');?></span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Tổng số Nhóm</td>
                                            <td><span class="label bg-green"><?php echo count_sys('package_nhom');?></span></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Tổng đối tượng</td>
                                            <td><span class="label bg-green"><?php echo count_target('target');?></span></td>
                                        </tr>                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(i, 2e3);
        function i() {
            $(".notify-box .listbox-content-item:first").each(function() {
                $(this).animate({
                    marginTop: -$(this).outerHeight(true),
                    opacity: "hide"
                }, 2e3, function() {
                    $(this).insertAfter(".notify-box .listbox-content-item:last"), $(this).fadeIn(), $(this).css({
                        marginTop: 0
                    }), setTimeout(function() {
                        i()
                    }, 2e3)
                })
            })
        }
    });
</script>