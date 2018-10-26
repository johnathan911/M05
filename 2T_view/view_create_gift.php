    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                GIFT CODE<small>Nhập mã nhận quà tặng trên hệ thống</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
                                <div class="col-md-6">
                                    <label for="input" class="control-label">Số Lượng Mã Gift</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="number-gift" value="1" class="form-control" placeholder="Nhập Vào Số Lượng Mã Muốn Tạo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="input" class="control-label">Mệnh Giá: Ex(10000)</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="vnd" class="form-control" placeholder="Nhập Vào Mệnh Giá Mã Gift">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success waves-effect" id="btn" onclick="create_gift();"><i class="fa fa-gift" aria-hidden="true"></i> Tạo Mã Gift</button>
                                </div>
                                <br />
                                <div id="result-gift">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LIST GIFT CODE <small>Danh sách các mã gift đã tạo</small>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered" width="100%" id="result-gift-table">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function(){
        load_gift();
    })
    function create_gift(){
        var number = $("#number-gift").val();
        var vnd = $("#vnd").val();
        if (!number || number <= 0) {
            showNotification('bg-red', 'Số Lượng Mã Gift Không Hợp Lệ');
            return;
        }
        if (!vnd) {
            showNotification('bg-red', 'Chưa Chọn Mệnh Giá');
            return;
        }
        var html = '';
        $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Vui Lòng Đợi');
        $.ajax({
            url: prefix+modun+'/modun_post.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                t: 'create-gift',
                number: number,
                vnd: vnd
            },
            success: (data) => {
                $("#btn").html('<i class="fa fa-gift" aria-hidden="true"></i> Tạo Mã Gift');
                $("#result-gift").empty();
                $.each(data, (i, item) => {
                    $("#result-gift").append('<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">\
                            <div class="card">\
                                <div class="body bg-blue-grey">\
                                    Mã Gift: ' + item + ' <br />\
                                    Mệnh Giá: ' + number_format(vnd) + ' VNĐ\
                                </div>\
                            </div>\
                        </div>');
                });
                $("input").val('');
                load_gift();
            }
        })
    }
    function load_gift(){
        $('#result-gift-table').DataTable({
            destroy: true,
            "ajax": '2T_modun/modun_post.php?t=load-gift-code',
            "columns": [{
                    title: "ID"
                },
                {
                    title: "GIFT CODE"
                },
                {
                    title: "MỆNH GIÁ"
                },
                {
                    title: "NGÀY HẾT HẠN"
                }
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