    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                NOTIFICATION<small>Gửi thông báo đền khách hàng</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
                                <div class="col-md-12">
                                    <label for="email_address">Nội Dung Thông Báo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="" id="notify" class="form-control" rows="6" required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn" onclick="notify();"><i class="fa fa-bullhorn" aria-hidden="true"></i> Tiến Hành</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    function notify(){
        var notify = $("#notify").val();
        if (!notify) {
            showNotification('bg-red', 'Vui Lòng Nhập Vào Nội Dung Thông Báo');
            return;
        }
        $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
        $.ajax({
            url: prefix+modun+'/modun_post.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                t: 'notify',
                notify: notify
            },
            success: (data) => {
                $('#btn').html('<i class="fa fa-bullhorn" aria-hidden="true"></i> Tiến Hành');
                if (data.error == 1) {
                    showNotification('bg-red', data.msg);
                } else {
                    showNotification('bg-green', data.msg);
                    $("#notify").val('');
                }
            }
        })
    }
    </script>