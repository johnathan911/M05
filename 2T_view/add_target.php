    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card animated bounceIn">
                        <div class="header">
                            <h2>
                                <i class="fa fa-heartbeat" aria-hidden="true"></i> THÊM ĐỐI TƯỢNG<small>Thêm đối tượng cần theo dõi</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <label for="email_address">FB ID (*)</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" onchange="update1()" id="id" class="form-control" placeholder="Vui Lòng Nhập Chính Xác FB ID đối tượng">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email_address">Tên đối tượng</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="user" onchange="update()" class="form-control" placeholder="Nhập Tên đối tượng">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="package-nhom" class="control-label">Chọn nhóm</label>
                                        <select name="" id="package-nhom" onchange="update()" class="form-control" required="required">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul>
                                        <li>
                                            <p class="font-bold font-underline col-pink">Lưu ý:</p>
                                            <ul>
                                                <li><p class="font-bold">Điền đúng ID facebook của đối tượng.</p></li>
                                                <li><p class="font-bold">Kiểm tra các thông tin trước khi thêm vào hệ thống.</p></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card animated bounceInRight">
                        <div class="header">
                            <h2>
                                <i class="fa fa-desktop" aria-hidden="true"></i> Chi Tiết Đối tượng
                            </h2>
                        </div>
                        <div class="body" style="padding: 2px;">
                           <ul class="list-group">
                                <li class="list-group-item">Tên Nhóm:<span class="badge bg-pink" id="name-group">NULL</span></li>
                                <li class="list-group-item">Tên đối tượng:<span class="badge bg-cyan" id="name-target">NULL</span></li>
                                <li class="list-group-item">ID đối tượng:<span class="badge bg-cyan" id="id-target">NULL</span></li>
                            </ul>
                            <div class="text-center" style="margin-bottom: 10px;">
                                <button type="button" class="btn bg-light-green waves-effect" id="add" onclick="add()">
                                    <i class="fa fa-shopping-cart"></i> Thêm
                                </button>
                                <button type="button" class="btn bg-deep-orange waves-effect" onclick="reset()"><i class="fa fa-times" aria-hidden="true"></i> Đặt Lại</button>
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
            var _PACKAGE;
        })
        function add(){
            var id = $("#id").val();
            var user = $("#user").val();
            var nhom = $("#package-nhom").val();
            if(!id || !user){
                showNotification('bg-red', 'Vui Lòng Điền Đầy Đủ Thông Tin');
                return;
            }
            $("#add").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t       : 'add_target',
                    id      : id,
                    user    : user,
                    nhom : nhom
                },
                success: (data) => {
                    $("#add").html('<i class="fa fa-shopping-cart"></i> Thêm');
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                    } else {
                        showNotification('bg-green', data.msg);
                        $("input").val('');
                    }
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
        function reset(){
            $("input").val('');
			$('select').prop('selectedIndex', 0);
            $("#name-group").text('NULL');
            $("#name-target").text('NULL');
            $("#id-target").text('NULL');
            $("#id").text('NULL');
            $("#name").text('NULL');
            $("#package-nhom").text('NULL');
        }
        function update(){
            var id = $("#id").val();
            var user = $("#user").val();
            var nhom = $("#package-nhom").val();
            $("#name-group").text(nhom);
            $("#name-target").text(user);
            $("#id-target").text(id);
        }

        function update1(){
            var fbid = $("#id").val();
            var user = $("#user").val();
            var nhom = $("#package-nhom").val();
            $.ajax({
                url     : prefix+modun+ '/modun_post.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    t           : 'get-name',
                    fbid          : fbid
                },
                success : (data) => {
                    console.log(data);
                    if (data.error) {
                        showNotification('bg-red', data.msg);
                        $("#name-group").text(nhom);
                        $("#name-target").text(user);
                        $("#id-target").text(fbid);
                    } else {
                        $("#name-group").text(nhom);
                        $("#name-target").text(data.msg);
                        $("#user").text(data.msg);
                        $("#id-target").text(fbid);
                    }
                }
            })
        }
    </script>