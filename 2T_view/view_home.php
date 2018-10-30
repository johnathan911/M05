
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
                        </div>
                    </div>
					</div>
				      <div class="card animated bounceIn">
                        <div class="header">
                            <h2>
                               <i class="fa fa-bars" aria-hidden="true"></i> DANH SÁCH CÁC BÀI VIẾT MỚI<small>Danh sách các bài viết của các đối tượng</small>
                            </h2>
                            <ul class="header-dropdown m-r--5" style="display: none;" id="btn-action">
                                <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#edit-vip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh Sửa</button>
                                <!--<button type="button" class="btn btn-danger waves-effect" onclick="del_package()">Xóa</button>-->

                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered" width="100%" id="result-vip">
                            </table>
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
<script type="text/javascript" src="js/moreless.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(i, 2e3);
		load_post();
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
	function load_post(){
            $('#result-vip').DataTable({
                destroy: true,
                'fnDrawCallback': function AddReadMore() {
                    //This limit you can set after how much characters you want to show Read More.
                    var carLmt = 280;
                    // Text to show when text is collapsed
                    var readMoreTxt = " ... more";
                    // Text to show when text is expanded
                    var readLessTxt = " less";


                    //Traverse all selectors with this class and manupulate HTML part to show Read More
                    $(".addReadMore").each(function() {
                        if ($(this).find(".firstSec").length)
                            return;

                        var allstr = $(this).text();
                        if (allstr.length > carLmt) {
                            var firstSet = allstr.substring(0, carLmt);
                            var secdHalf = allstr.substring(carLmt, allstr.length);
                            var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                            $(this).html(strtoadd);
                        }

                    });
                    //Read More and Read Less Click Event binding
                    $(document).on("click", ".readMore,.readLess", function() {
                        $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
                    });
                },
                'ajax'       : {
                    "type"   : "POST",
                    "url"    : '2T_modun/modun_post.php?t=load-post',
                    "dataSrc": function (json) {
                        console.log(json);
                        console.log(json['data'][0][3]);
                        var return_data = new Array();
                        console.log(json['data'].length);
                        var count = 1;
                        var content;
                        for(var i=0;i< json['data'].length; i++){
                                content = json['data'][i][1];
                                return_data.push({

                                    'stt': count,
                                    'name': json['data'][i][0],
                                    'content': '<p class="addReadMore showlesscontent">' + content + '</p>',
                                    'time': json['data'][i][2],
                                    'like': json['data'][i][3]
                                });
                                count++;

                        }
                        console.log(return_data);
                        return return_data;
                    }
                },
                "columns"    : [
                    {
                        title : "STT",
                        'data': 'stt'
                    },
                    {
                        title : "Tên Facebook",
                        'data': 'name'
                    },
                    {
                        title : "Nội dung",
                        'data': 'content'
                    },
                    {
                        title : "Time",
                        'data': 'time'
                    },
                    {
                        title : "Lượt like",
                        'data': 'like'
                    }

                ],
                //"ajax": '2T_modun/modun_post.php?t=load-post',
                /*"columns": [{
                        title: "STT"
                    },
                    {
                        title: "ĐỐI TƯỢNG ĐĂNG"
                    },
                    {
                        title: "NỘI DUNG"
                    },
                    {
                        title: "NGÀY ĐĂNG"
                    },
					 {
                        title: "Like,Comment,Share"
                    },
                ],*/
                "language": {
                    "search": "Tìm Kiếm",
                    "paginate": {
                        "first": "Về Đầu",
                        "last": "Về Cuối",
                        "next": "Tiến",
                        "previous": "Lùi"
                    },
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "lengthMenu": "Hiển thị _MENU_ mục",
                    "loadingRecords": "Đang tải...",
                    "emptyTable": "Không có gì để hiển thị",
                }
            });
    }
</script>