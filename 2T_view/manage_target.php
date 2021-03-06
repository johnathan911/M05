    <section class="content">
        <div class="container-fluid">
			<div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CẬP NHẬT SỐ TOKEN LÀ BẠN BÈ VỚI ĐỐI TƯỢNG<small>Cập nhật token là bạn bè</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn1" onclick="update_friend();"><i class="fa fa-plus-square" aria-hidden="true"></i> Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card animated bounceIn">
                        <div class="header">
                            <h2>
                               <i class="fa fa-bars" aria-hidden="true"></i> Quản lý đối tượng<small>Quản lý các đối tượng đã thêm</small>
                            </h2>
                            <ul class="header-dropdown m-r--5" style="display: none;" id="btn-action">
                                <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#edit-vip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh Sửa</button>
                                <button type="button" class="btn btn-danger waves-effect" onclick="del_target()">Xóa</button>

                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered" width="100%" id="result-vip">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Facebook ID</th>
                                    <th>Tên</th>
                                    <th>Nhóm</th>
                                    <th>abc</th>
                                </tr>
                                </thead>

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
                                    <h4 class="modal-title">Chỉnh Sửa Thông tin đối tượng '+data[0][2]+'</h4>\
                                </div>\
                                <div class="modal-body">\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">TÊN</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" disabled id="name-up" class="form-control" value="'+data[0][2]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row clearfix">\
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="id-up">FB ID</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" disabled id="fbid-up" class="form-control" value="'+data[0][1]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
									 <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="package-nhom">CHỌN NHÓM</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <select name="" id="package-nhom" class="form-control" required="required">\
                                            </select>\
                                            </div>\
                                        </div>\
                                    </div>\
									<div class="modal-footer">\
										<button type="button" class="btn btn-link waves-effect" id="btn2" onclick="update_target()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh Sửa</button>\
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
		function update_friend(){
			$("#btn1").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'update-friend',
	
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
                        $('#edit-vip').modal('hide');
                    }, 500);
                }
            })
		}
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
        function update_target(){
            var data = $("#result-vip").DataTable().rows('.active').data();
            var old_name = data[0][3];
            var fbid = $("#fbid-up").val();
            var name = $("#name-up").val();
            var nhom = $("#package-nhom").val();
			var id = data[0][5];
            if (!name||!fbid||!nhom) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn2").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'update-target',
					id          :  id ,
                    nhom         : nhom,
                    old_name       : old_name
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
        function del_target(){
            var data = $("#result-vip").DataTable().rows('.active').data();
            if (data.length == 0) {
                showNotification('bg-red', 'Vui lòng chọn 1 gói VIP để xóa!');
                return;
            }
            swal({
              title: 'Bạn muốn xóa đối tượng ' + data[0][2] + ' thuộc nhóm ' + data[0][3],
              text: "Không thể phục hồi sau khi xóa",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Vâng, Tôi muốn xóa!',
              cancelButtonText: 'Trở về'
            }).then(function () {
              submit_del(data[0][5], data[0][3]);
            })
        }
        function submit_del(id_target, name_group){
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'delete-target',
                    id_target          : id_target,
                    name_group        : name_group
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
                /*"columns": [{
                        title: "STT"
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
                ],*/
                initComplete: function () {
                    this.api().columns(3).every( function () {
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