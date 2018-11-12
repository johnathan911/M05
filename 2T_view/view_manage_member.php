    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                THÊM THÀNH VIÊN<small>Thêm mới thành viên</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
								 <div class="col-md-6">
                                    <label for="email_address">Tên đầy đủ</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="user-name" class="form-control" placeholder="Nhập Tên người dùng">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="input" class="control-label">Mật khẩu</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="password" class="form-control" placeholder="Nhập mật khẩu">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn1" onclick="add_member();"><i class="fa fa-plus-square" aria-hidden="true"></i> Thêm</button>
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
                                QUẢN LÝ THÀNH VIÊN <small></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <button type="button" class="btn btn-primary waves-effect" style="display: none;" data-toggle="modal" data-target="#edit-vip" id="btn-edit">Chỉnh Sửa</button>
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
            load_mem();
            $('#result-vip').on( 'click', 'tr', function () {
                if ( $(this).hasClass('active') ) {
                    $(this).removeClass('active');
                   // $("#btn-edit").fadeOut('slow');
                }else {
                    $('#result-vip').DataTable().$('tr.active').removeClass('active');
                    $(this).addClass('active');
                    /*$("#btn-edit").fadeOut('slow', function(){
                        $("#btn-edit").fadeIn('slow');
                    });
                    var data = $("#result-vip").DataTable().rows('.active').data();
                    var vnd = data[0][4].replace(',', '');
                    var tpl = '<div class="modal fade" id="edit-vip" tabindex="-1" role="dialog">\
                        <div class="modal-dialog" role="document">\
                            <div class="modal-content">\
                                <div class="modal-header">\
                                    <h4 class="modal-title">Chỉnh Sửa Thành viên '+data[0][2]+'</h4>\
                                </div>\
                                <div class="modal-body">\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="fbid-up">FULL NAME</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="fullname-up" class="form-control" value="'+data[0][1]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">USER NAME</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="user-up" class="form-control" value="'+data[0][2]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="row clearfix">\
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">\
                                            <label for="name-up">EMAIL</label>\
                                        </div>\
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                    <input type="text" id="email-up" class="form-control" value="'+data[0][3]+'">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                <div class="modal-footer">\
                                    <button type="button" class="btn btn-link waves-effect" id="btn2" onclick="update_vip()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh Sửa</button>\
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Đóng</button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';*/
                    $("#show-modal").html(tpl);
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
                    t       : 'action-member',
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
        function update_vip(){
			var data = $("#result-vip").DataTable().rows('.active').data();
			var id = data[0][5];
            var fullname = $("#fullname-up").val();
            var user = $("#user-up").val();
            var email = $("#email-up").val();
            var vnd = $("#vnd-up").val();
            if (!fullname || !user || !email ) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn2").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'update-member',
                    id          : id,
                    fullname         : fullname,
                    user        : user,
                    email        : email
                },
                success : (data) => {
                    $("#btn2").html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Hoàn Thành');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_mem();
                    }
                    setTimeout(function(){
                        $('#edit-vip').modal('hide');
                    }, 500);
                }
            })
        }
		function add_member(){
            var username = $("#user-name").val();
            var pass  = $("#password").val();
            if (!username || !pass) {
                showNotification('bg-red','Vui Lòng Điền Đầy Đủ Thông Tin!');
                return;
            }
            $("#btn1").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix + modun + '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'add-member',
                    username        : username,
                    pass         : pass
                },
                success : (data) => {
                    $("#btn1").html('<i class="fa fa-plus-square" aria-hidden="true"></i> Tiến Hành');
                    $('.add-package :input').val('');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        load_mem();
                    }
                }
            })
        }
        function load_mem(){
            $('#result-vip').DataTable({
                destroy: true,
                "ajax": '2T_modun/modun_post.php?t=load-member',
                "columns": [{
                        title: "STT"
                    },
                    {
                        title: "TÊN NGƯỜI DÙNG"
                    },
                    {
                        title: "SỐ ĐỐI TƯỢNG"
                    },
                    {
                        title: "SỐ NHÓM"
                    },
                    {
                        title: "BLOCK"
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