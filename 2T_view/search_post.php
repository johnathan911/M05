    <section class="content">
        <div class="container-fluid">
			<div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row clearfix add-package">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="package-nhom" class="control-label">Chọn nhóm</label>
                                        <select name="" id="package-nhom" onchange="update()" class="form-control" required="required">
                                        </select>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <label for="input" class="control-label">Từ khóa</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="keyword" class="form-control" placeholder="Nhập từ khóa cần tìm">
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <label for="input" class="control-label">Từ ngày</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" id="datefrom" class="form-control" placeholder="Nhập từ khóa cần tìm">
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <label for="input" class="control-label">Đến ngày</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" id="dateto" class="form-control" placeholder="Nhập từ khóa cần tìm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn1" onclick="search()"><i class="fa fa-plus-square" aria-hidden="true"></i> Tìm kiếm</button>
                                </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card animated bounceIn">
                        <div class="header">
                            <h2>
                               <i class="fa fa-bars" aria-hidden="true"></i> Danh sách bài viết liên quan từ khóa<small></small>
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
            </div>
            <div id="show-modal">
                <div class="modal fade" id="edit-vip" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Không Thể Thực Hiện Hành Động</h4>
                            </div>
                            <div class="modal-body">
                                Vui Lòng Chọn 1 Mục Cần Chỉnh Sửa
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
			get_package();
            $('#result-vip').on( 'click', 'tr', function () {
                if ( $(this).hasClass('active') ) {
                    $(this).removeClass('active');
                    $("#btn-action").fadeOut('slow');
                }else {
                    $('#result-vip').DataTable().$('tr.active').removeClass('active');
                    $(this).addClass('active');
                    $("#btn-action").fadeOut('slow', function(){
                        $("#btn-action").fadeIn('slow');
                    });
                    var data = $("#result-vip").DataTable().rows('.active').data();
                    var tpl = '<div class="modal fade" id="edit-vip" tabindex="-1" role="dialog">\
                        <div class="modal-dialog" role="document">\
                            <div class="modal-content">\
                                <div class="modal-header">\
                                    <h4 class="modal-title">Chỉnh Sửa VIPLike cho ID '+data[0][1]+'</h4>\
                                </div>\
                                <div class="modal-body">\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">TÊN</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="name-up" class="form-control" value="'+data[0][2]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">TỐC ĐỘ (/phút)</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="speed-up" class="form-control" value="'+data[0][6]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
									<div class="row clearfix">\
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
										<label for="sex-up">GIỚi TÍNH</label>\
										</div>\
										<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
											<div class="form-group">\
												<div class="form-line">\
													<select id="sex-up" class="form-control" required="required">\
														<option value="male">Nam</option>\
														<option value="female">Nữ</option>\
														<option value="all">Cả Hai</option>\
													</select>\
												</div>\
											</div>\
										</div>\
									</div>\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">Tùy Chỉnh Cảm Xúc</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <input name="camxuc[]" checked type="checkbox" class="filled-in" id="like" value="LIKE" />\
                                                <label for="like" style="margin-right: 20px;"><img src="images/png/like.png" style="width:24px" data-toggle="tooltip" title="" data-original-title="Thích"></label>\
                                                <input name="camxuc[]" type="checkbox" class="filled-in" id="love" value="LOVE" />\
                                                <label for="love" style="margin-right: 20px;"><img src="images/png/love.png" style="width:24px" data-toggle="tooltip" title="" data-original-title="Yêu Thích"></label>\
                                                <input name="camxuc[]" type="checkbox" class="filled-in" id="haha" value="HAHA" />\
                                                <label for="haha" style="margin-right: 20px;"><img src="images/png/haha.png" style="width:24px" data-toggle="tooltip" title="" data-original-title="Cười Lớn"></label>\
                                                <input name="camxuc[]" type="checkbox" class="filled-in" id="wow" value="WOW" />\
                                                <label for="wow" style="margin-right: 20px;"><img src="images/png/wow.png" style="width:24px" data-toggle="tooltip" title="" data-original-title="Ngạc Nhiên"></label>\
                                                <input name="camxuc[]" type="checkbox" class="filled-in" id="sad" value="SAD" />\
                                                <label for="sad" style="margin-right: 20px;"><img src="images/png/sad.png" style="width:24px" data-toggle="tooltip" title="" data-original-title="Buồn"></label>\
                                                <input name="camxuc[]" type="checkbox" class="filled-in" id="angry" value="ANGRY" />\
                                                <label for="angry" style="margin-right: 20px;"><img src="images/png/angry.png" style="width:24px" data-toggle="tooltip" title="" data-original-title="Phẫn Nộ"></label>\
                                            </div>\
                                        </div>\
                                    </div>\
									<div class="modal-footer">\
										<button type="button" class="btn btn-link waves-effect" id="btn2" onclick="update_vip()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh Sửa</button>\
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Đóng</button>\
									</div>\
								</div>\
							</div>\
						</div>';
                    $("#show-modal").html(tpl);
                    get_package();
                    $('[data-toggle="tooltip"]').tooltip();
                }
            })

        });
        function get_package(){
            var option = '';
            var table  = '';
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'get_name_package_nhom',
                },
                success : (data) => {
                    _PACKAGE = data;
					option += '<option value="all">Tất cả</option>';
                    $.each(data, (i, item) => {
                        option += '<option value="'+item.name+'">'+item.name+'</option>';
                    })

                    setTimeout(function(){
                        $("#package-nhom").html(option);
                        $("#table-nhom").html(table);
                    }, 500);
                }
            })
        }
		function search(){
            var nhom = $("#package-nhom").val();
            var keyword = $("#keyword").val();
			var datefrom = $("#datefrom").val();
			var dateto = $("#dateto").val();
			if (!keyword||!nhom||!datefrom||!dateto) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            console.log('send');
            $("#btn1").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
					t           : 'search_keyword',
                    nhom          : nhom,
                    keyword        : keyword,
                    datefrom         : datefrom,
                    dateto       : dateto
                },
                success : (data) => {
                    $("#btn1").html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Hoàn Thành');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_vip();
                    }
                    setTimeout(function(){
                        $('#edit-package').modal('hide');
                    }, 1000);
                }
            })
        }


        function search1(){
			
            var nhom = $("#package-nhom").val();
            var keyword = $("#keyword").val();
			var datefrom = $("#datefrom").val();
			var dateto = $("#dateto").val();
            if (!keyword||!nhom||!datefrom||!dateto) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn1").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'search_keyword',
                    nhom          : nhom,
                    keyword        : keyword,
                    datefrom         : datefrom,
                    dateto       : dateto
                },
                success : (data) => {
                    $("#btn1").html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Hoàn Thành');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                    }
                }
            })
        }
        function load_vip(){
            $('#result-vip').DataTable({
                destroy: true,
                //"ajax": '2T_modun/modun_post.php?t=load-post',
                "columns": [{
                        title: "STT"
                    },
                    {
                        title: "Đối tượng"
                    },
                    {
                        title: "POST ID"
                    },
                    {
                        title: "LIKE,COMMENT,SHARE"
                    },
                ],
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
