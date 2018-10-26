    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LỊCH SỬ NẠP TIỀN <small>Các lệnh nạp tiền được thực hiện trên server</small>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered" width="100%" id="result-nap-tien">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LỊCH SỬ MUA VIP
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered" width="100%" id="result-mua-vip">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function(){
        load_history_money();
        load_history_vip();
    })
    function load_history_money(){
        $('#result-nap-tien').DataTable({
            destroy: true,
            "ajax": '2T_modun/modun_post.php?t=load-ls-nap-tien',
            "columns": [{
                    title: "Trạng Thái"
                },
                {
                    title: "Người Nạp"
                },
                {
                    title: "Loại Thẻ"
                },
                {
                    title: "Mệnh Giá"
                },
                {
                    title: "Mã Thẻ"
                },
                {
                    title: "Seri"
                },
                {
                    title: "Ngày Nạp"
                },
                {
                    title: "Ghi Chú"
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
    function load_history_vip(){
        $('#result-mua-vip').DataTable({
            destroy: true,
            "ajax": '2T_modun/modun_post.php?t=load-mua-vip',
            "columns": [{
                    title: "Loại Vip"
                },
                {
                    title: "Người Mua"
                },
                {
                    title: "FBID Thụ Hưởng"
                },
                {
                    title: "Tên"
                },
                {
                    title: "Gói VIP"
                },
                {
                    title: "Thời Gian"
                },
                {
                    title: "Ngày Mua"
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