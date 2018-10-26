    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card animated bounceIn">
                        <div class="header">
                            <h2>
                               <i class="fa fa-bars" aria-hidden="true"></i> Quản lý đối tượng<small>Quản lý các đối tượng đã thêm</small>
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
            load_vip();
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
        $(document).on('click', '.btnActionModuleItem', function(){
            var _that = $(this);
            if (_that.is(":checked")) {
                var checked = 'checked';
                var value = _that.val();
            } else {
                var checked = '';
                var value = _that.val();
            }
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t       : 'action-vip-like',
                    checked      : checked,
                    value : value
                },
                success: (data) => {
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                    }
                }
            })
        })
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
                    $.each(data, (i, item) => {
                        option += '<option value="'+item.name+'">'+item.name+'</option>';
                        table  += '<tr>\
                                        <td>'+item.name+'</td>\
                                        <td>'+number_format(item.price)+'</td>\
                                    </tr>';
                    })

                    setTimeout(function(){
                        $("#package-nhom").html(option);
                        $("#table-nhom").html(table);
                    }, 500);
                }
            })
        }
        function trim(s){
            while (s.substring(0,1) == "|"){
                s = s.substring(1, s.length);
            }
            while (s.substring(s.length-1, s.length) == "|") {
                s = s.substring(0,s.length-1);
            }
            return s;
        }
        function update_vip(){
			var data = $("#result-vip").DataTable().rows('.active').data();
			var id = data[0][0];
            var fbid = data[0][1];
            var name = $("#name-up").val();
            var speed = $("#speed-up").val();
			var sex = $("#sex-up").val();
            var cx = '';
            $('.filled-in:checked').each(function(){
                var values = $(this).val();
                cx += values+'|';
            })
            if (!name) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn2").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'update-vip-like',
                    id          : id,
                    name        : name,
                    fbid         : fbid,
                    speed       : speed,
                    camxuc  : trim(cx),
					sex  : sex
                },
                success : (data) => {
                    $("#btn2").html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Hoàn Thành');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_vip();
                    }
                    setTimeout(function(){
                        $('#edit-vip').modal('hide');
                    }, 500);
                }
            })
        }
        function del_package(){
            var data = $("#result-vip").DataTable().rows('.active').data();
            if (data.length == 0) {
                showNotification('bg-red', 'Vui lòng chọn 1 gói VIP để xóa!');
                return;
            }
            swal({
              title: 'Bạn muốn xóa gói VIP ' + data[0][1],
              text: "Không thể phục hồi sau khi xóa",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Vâng, Tôi muốn xóa!',
              cancelButtonText: 'Trở về'
            }).then(function () {
              submit_del(data[0][0]);
            })
        }
        function submit_del(id){
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'delete-vip',
                    id          : id,
                    type        : 'vip_like'
                },
                success : (data) => {
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_vip();
                    }
                }
            })
        }

        function load_vip(){
            $('#result-vip').DataTable({
                destroy: true,
                "ajax": '2T_modun/modun_post.php?t=load-target',
                "columns": [{
                        title: "ID"
                    },
                    {
                        title: "FB ID"
                    },
                    {
                        title: "TÊN"
                    },
                    {
                        title: "NHÓM"
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