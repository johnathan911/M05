    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DELETE ACCESS TOKEN<small>Xóa Access Token Die Trên Hệ Thống</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix add-package">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-danger waves-effect" id="btn" onclick="getTokenToServer();"><i class="fa fa-superpowers" aria-hidden="true"></i> Tiến Hành Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    var TOKENDIE = new Array();
	var TOKENLIVE = new Array();
	var TOKENS = new Array();
    function getTokenToServer(){
        $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Đang Lấy Dữ Liệu Từ Server...');
        $.ajax({
            url: prefix+modun+'/modun_post.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                t: 'get-token',
                typeget: 'access_token'
            },
            success: (data) => {
				TOKENS = data;
                init(data);
            }
        })
    }
    function init(access_token){
        $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Đang Check Live...');
		var long = TOKENS.length;
		var tong = 0,
            live = 0,
            die  = 0;
		for(var i = 0; i < long; i++){
			$("#access-token-list").append(TOKENS[i].trim()+"\n");
			! function(i){
                $.ajax({
                    url: 'https://graph.facebook.com/me',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        access_token: TOKENS[i]
                    }
                }).success((data) => {
                    live++;
                    //$("#live").text(live);
					//$("#access-token-live").append(TOKENS[i].trim()+"\n");
                    TOKENLIVE.push(TOKENS[i]);
                }).error((data) => {
                    die++;
                    TOKENDIE.push(TOKENS[i]);
					//$("#access-token-die").append(TOKENS[i].trim()+"\n");
                }).always((data) => {
                    tong++;
                })
            }(i)
		}
        setTimeout(function(){
            delToken()
        }, 3000)
    }
    function delToken(){
        $("#btn").html('<i class="fa fa-refresh fa-spin"></i> Đang Xóa..');
        $.ajax({
            url: prefix+modun+'/modun_post.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                t: 'del-token',
                token_die: TOKENDIE
            },
            success: (data) => {
                $("#btn").prop( "disabled", true);
                $("#btn").html('<i class="fa fa-pie-chart" aria-hidden="true"></i> Hoàn Tất');
                if (data.error == 1) {
                    showNotification('bg-red', data.msg);
                } else {
                    showNotification('bg-green', data.msg);
                }
            }
        })
    }
    </script>