    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ĐỔI MẬT KHẨU<small>Đổi mật khẩu cho hệ thống của bạn.</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
                                <div class="col-md-12">
                                    <label for="email_address">Mật Khẩu Cũ</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" id="pass-old" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="email_address">Mật Khẩu Mới</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" id="pass-new" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="email_address">Nhập Lại Mật Khẩu Mới</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" id="re-pass-new" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn" onclick="change();"><i class="fa fa-exchange" aria-hidden="true"></i> Đổi Mật Khẩu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    function change(){
        var old_pass = $("#pass-old").val();
        var new_pass = $("#pass-new").val();
        var re_pass = $("#re-pass-new").val();
        if (!old_pass || !new_pass || !re_pass) {
            showNotification('bg-red', 'Vui Lòng Nhập Đầy Đủ Thông Tin.');
            return;
        }
        if (new_pass !== re_pass) {
            showNotification('bg-red', 'Nhập Lại Mật Khẩu Không Đúng.');
            return;
        }
        $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
        $.ajax({
            url: prefix+modun+'/modun_post.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                t: 'change-pass',
                old_pass: old_pass,
                new_pass: new_pass
            },
            success: (data) => {
                $("#btn").html('<i class="fa fa-exchange" aria-hidden="true"></i> Đổi Mật Khẩu');
                if (data.error == 1) {
                    showNotification('bg-red', data.msg);
                } else {
                    showNotification('bg-green', data.msg);
                    $("#gift").val('');
                    setTimeout(function(){
                        window.location = '<?php echo $config_site["url"].'/logout.php';?>';
                    },500);
                }
            }
        })
    }
    </script>