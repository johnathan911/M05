
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
                           <i class="fa fa-bars" aria-hidden="true"></i> DANH MỤC CHỨC NĂNG<small>Chức năng của hệ thống</small>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="content">
                                        <div class="number">TẠO NHÓM</div>
                                        <a href="?act=add-group" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">add</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="content">
                                        <div class="number">THÊM ĐỐI TƯỢNG</div>
                                        <a href="?act=add-target" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">add</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box-3 bg-blue-grey hover-zoom-effect">
                                    <div class="content">
                                        <div class="number">QUẢN LÝ ĐỐI TƯỢNG</div>
                                        <a href="?act=manage-target" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float">
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
                            <!--<select id="select" class="form-control input-sm">
                                <option value=*> Tất cả </option>
                            </select>-->
                            <p id="date_filter">
                                <span id="date-label-from" class="date-label">Từ: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
                                <span style="margin-left: 1%" id="date-label-to" class="date-label">Đến:<input class="date_range_filter date" type="text" id="datepicker_to" />
                            </p>
                            <table class="table table-bordered" width="100%" id="result-vip">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Facebook</th>
                                    <th>Nội dung</th>
                                    <th>Ngày đăng</th>
                                    <th>L.C.S</th>
                                    <th>Nhóm</th>
                                </tr>
                                </thead>
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
                                            <td><span class="label bg-green"><?php echo count_sys('target');?></span></td>
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

<script data-require="jqueryui@*" data-semver="1.10.0" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>
<link data-require="jqueryui@*" data-semver="1.10.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.js" data-semver="1.9.4" data-require="datatables@*"></script>

<script type="text/javascript" src="js/moreless.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(i, 2e3);
        /*$.ajax({
            url : '2T_modun/modun_post.php?t=get_package_nhom',
            type:'POST',
            dataType: 'json',
            success: function(data) {
                $("#select").attr('disabled', false);
                console.log(data);
                if (data['data'].length > 0){
                    for(var i = 0; i< data['data'].length; i++){
                        $("#select").append('<option value=' + data['data'][i][0] + '>' + data['data'][i][1] + '</option>');
                    }
                }
            }
        });*/
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
            var table = $('#result-vip').DataTable({
                destroy: true,
                dom: "<'row'<'col-sm-5'l><'col-sm-7'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                'fnDrawCallback': function AddReadMore() {

                    $(".m-more-less-content .m-show-more").click(function(){
                        $(this).parent().addClass("m-display-more");
                    });
                    $(".m-more-less-content .m-show-less").click(function(){
                        $(this).parent().removeClass("m-display-more");
                    });

                    $(".m-more-less-content").each(function (i, e){
                        var html = $(e).html();
                        var contentArray = html.split("<!--more-->");
                        //console.log(contentArray);
                        if (contentArray.length == 2) {
                            html = contentArray[0] + '<span class="m-show-more"></span><span class="m-more-text">' + contentArray[1] + '</span><span class="m-show-less"></span>';
                            $(e).html(html);
                            $(e).find(".m-show-more").click(function(){
                                $(this).parent().addClass("m-display-more");
                            });
                            $(e).find(".m-show-less").click(function(){
                                $(this).parent().removeClass("m-display-more");
                            });
                        }
                    });
                },

                'ajax'       : {
                    "type"   : "POST",
                    "url"    : '2T_modun/modun_post.php?t=load-post',
                    "dataSrc": function (json) {
                        console.log(json);
                        //console.log(json['data'][0][3]);
                        var return_data = new Array();
                        //console.log(json['data'].length);
                        var count = 1;
                        var content;
                        for(var i=0;i< json['data'].length; i++){
                                link = '<a href="https://www.facebook.com/' + json['data'][i][5] + '" target="_blank" title="Click để vào bài viết">https://www.facebook.com/' + json['data'][i][5] + '</a></br>';
                                content = link + json['data'][i][1];
                                if (content.length > 350){
                                    content = '<div class="m-more-less-content">' + content.slice(0, 350) + '<!--more-->' + content.slice(350 + Math.abs(0)); + '</div>';
                                }
                                return_data.push({

                                    'stt': count,
                                    'name': json['data'][i][0],
                                    'content': '<div style="text-align:justify">' + content + '</div>',
                                    'time': json['data'][i][2],
                                    'like': json['data'][i][3],
                                    'group': json['data'][i][4]
                                });
                                count++;

                        }
                        //console.log(return_data);
                        return return_data;
                    }
                },

                "columns"    : [
                    {
                        'data': 'stt'
                    },
                    {
                        'data': 'name'
                    },
                    {
                        'data': 'content'
                    },
                    {
                        'data': 'time'
                    },
                    {
                        'data': 'like'
                    },
                    {
                        'data': 'group'
                    }

                ],

                initComplete: function () {
                    this.api().columns(5).every( function () {
                        var column = this;
                        var select = $('<select><option value="">Tất cả</option></select>')
                            .appendTo( $(column.header()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        } );
                    } );
                },
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


            $("#datepicker_from").datepicker({
                dateFormat: "dd/mm/yy",
                //showOn: "button",
                //buttonImage: "images/calendar.jpg",
                buttonImageOnly: false,
                "onSelect": function(date) {
                    minDateFilter = new dateString2Date(date).getTime();
                    table.draw();
                }
            }).keyup(function() {
                minDateFilter = new dateString2Date(this.value).getTime();
                table.draw();
            });

            $("#datepicker_to").datepicker({
                dateFormat: "dd/mm/yy",
                //showOn: "button",
                //buttonImage: "images/calendar.jpg",
                buttonImageOnly: false,
                "onSelect": function(date) {
                    maxDateFilter = new dateString2Date(date).getTime();
                    table.draw();
                }
            }).keyup(function() {
                maxDateFilter = new dateString2Date(this.value).getTime();
                table.draw();
            });



        minDateFilter = "";
        maxDateFilter = "";

        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData._date == 'undefined') {
                    aData._date = new dateString2Date(aData[3]).getTime();
                    console.log(aData._date + "dkslfjakdfkfldkj");
                }

                if (minDateFilter && !isNaN(minDateFilter)) {
                    if (aData._date < minDateFilter) {
                        return false;
                    }
                }

                if (maxDateFilter && !isNaN(maxDateFilter)) {
                    if (aData._date > maxDateFilter) {
                        return false;
                    }
                }

                return true;
            }
        );


        // Date range filter

        /*$(".dataTables_filter").append(select);

        /!*$('.dataTables_filter input').unbind().bind('keyup', function() {
            var colIndex = document.querySelector('#select').selectedIndex;
            table.column( colIndex).search( this.value ).draw();
        });*!/

        $('#select').change(function() {
            if($('#select').val() == '*')
                table.search('').draw();
            else{
                table.search($("#select option:selected").text()).draw();
            }
        });*/
    }



    function dateString2Date(dateString) {
        var dt  = dateString.split(/\/|\s/);
        return new Date(dt[1] + "/" + dt[0] + "/" + dt[2]);
    }

</script>