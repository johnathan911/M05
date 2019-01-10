    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                THÊM MỚI BỘ TỪ KHÓA<small>Thêm danh sách từ khóa</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
                                <div class="col-md-6">
                                    <label for="email_address">Bộ từ khóa</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="name" class="form-control" placeholder="Nhập Tên Bộ Từ khóa">
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <label for="input" class="control-label">Mô tả</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="mota" class="form-control" placeholder="Nhập mô tả bộ từ khóa">
                                        </div>
                                    </div>
                                </div>
								 <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="control-label">Danh sách từ khóa</label>
                                        <textarea name="" id="list_keyword" class="form-control" rows="6" placeholder="Mỗi từ khóa cách nhau một dòng." required="required"></textarea>
								   </div>
                                </div>
                                
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn1" onclick="add_package();"><i class="fa fa-plus-square" aria-hidden="true"></i> Tiến Hành</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CHỈNH SỬA CÁC NHÓM ĐANG THEO DÕI <small>Chỉnh sửa các nhóm trên hệ thống</small>
                            </h2>
                            <ul class="header-dropdown m-r--5" id="btn-action" style="display: none;">
                                <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#edit-package">Chỉnh Sửa</button>
                                <button type="button" class="btn btn-danger waves-effect" onclick="del_package()">Xóa</button>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered" width="100%" id="result-package">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên bộ từ khóa</th>
                                        <th>Mô tả</th>
                                        <th>Danh sách từ khóa</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="show-modal">
                <div class="modal fade" id="edit-package" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Không Thể Thực Hiện Hành Động</h4>
                            </div>
                            <div class="modal-body">
                                Vui Lòng Chọn nhóm Cần Chỉnh Sửa
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
            $('#result-package').on( 'click', 'tr', function () {
                if ( $(this).hasClass('active') ) {
                    $(this).removeClass('active');
                    $("#btn-action").fadeOut('slow');
                }else {
                    $('#result-package').DataTable().$('tr.active').removeClass('active');
                    $(this).addClass('active');
                    $("#btn-action").fadeOut('slow', function(){
                        $("#btn-action").fadeIn('slow');
                    });
                    var data = $("#result-package").DataTable().rows('.active').data();
					var keyword = data[0][3].replace('<textarea disabled class="form-control" rows="3">', '');
                    keyword = keyword.replace('</textarea>', '')
                    var tpl = '<div class="modal fade" id="edit-package" tabindex="-1" role="dialog">\
                        <div class="modal-dialog" role="document">\
                            <div class="modal-content">\
                                <div class="modal-header">\
                                    <h4 class="modal-title">Chỉnh Sửa Chi Tiết bộ từ khóa ' + data[0][1] + '</h4>\
                                </div>\
                                <div class="modal-body">\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">Tên</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="name-up" class="form-control" value="'+data[0][1]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="mota-up">Mô tả</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="mota-up" class="form-control" value="'+data[0][2]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
									<div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="fbid-up">DANH SÁCH TỪ KHÓA</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <textarea name=keyword" id="keyword-up" class="form-control" rows="5" required="required">'+keyword+'</textarea>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="modal-footer">\
                                    <button type="button" class="btn btn-link waves-effect" id="btn2" onclick="update_package()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh Sửa</button>\
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Đóng</button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';
                    $("#show-modal").html(tpl);
                }
            });
            load_package();
        });
        function del_package(){
            var data = $("#result-package").DataTable().rows('.active').data();
            if (data.length == 0) {
                showNotification('bg-red', 'Vui lòng chọn 1 nhóm để xóa!');
                return;
            }
            swal({
              title: 'Bạn muốn xóa gói nhóm ' + data[0][1],
              text: "Không thể phục hồi sau khi xóa",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Vâng, Tôi muốn xóa!',
              cancelButtonText: 'Trở về'
            }).then(function () {
              submit_del(data[0][5]);
            })
        }
        function submit_del(id){
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'delete_package_nhom',
                    id          : id
                },
                success : (data) => {
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_package();
                    }
                }
            })
        }
        function load_package(){
            $('#result-package').DataTable({
                destroy: true,
                "ajax": '2T_modun/modun_post.php?t=get_list_keyword',
                "columns": [{
                        title: "STT"
                    },
                    {
                        title: "TÊN BỘ TỪ KHÓA"
                    },
                    {
                        title: "MÔ TẢ"
                    },
					{
                        title: "DANH SÁCH TỪ KHÓA"
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
        function update_package(){
			var data = $("#result-package").DataTable().rows('.active').data();
            var name = $("#name-up").val();
            var mota  = $("#mota-up").val();
			var list_keyword = $("#keyword-up").val();
			var id  = data[0][4];
            if (!name || !mota || !list_keyword) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn2").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'update_list_keyword',
                    id          : id,
                    name        : name,
                    mota         : mota,
					list_keyword	: list_keyword
                },
                success : (data) => {
                    $("#btn2").html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Hoàn Thành');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_package();
                    }
                    setTimeout(function(){
                        $('#edit-package').modal('hide');
                    }, 1000);
                }
            })
        }
        function add_package(){
            var name = $("#name").val();
            var mota  = $("#mota").val();
			var list_keyword = $("#list_keyword").val();
            if (!name || !mota || !list_keyword) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn1").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix + modun + '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'new_list_keyword',
                    name        : name,
                    mota         : mota,
					list_keyword	: list_keyword
                },
                success : (data) => {
                    $("#btn1").html('<i class="fa fa-plus-square" aria-hidden="true"></i> Tiến Hành');
                    $('.add-package :input').val('');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_package();
                    }
                }
            })
        }
    </script>