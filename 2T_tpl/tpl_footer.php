    <script src="<?php echo $config_site['url'];?>/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/node-waves/waves.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery-countto/jquery.countTo.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/morrisjs/morris.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/chartjs/Chart.bundle.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/flot-charts/jquery.flot.time.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.7/sweetalert2.min.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/ion-rangeslider/js/ion.rangeSlider.js"></script>
    <script src="<?php echo $config_site['url'];?>/plugins/jquery-sparkline/jquery.sparkline.js"></script>
    <script src="<?php echo $config_site['url'];?>/js/admin.js"></script>
    <script src="<?php echo $config_site['url'];?>/js/pages/index.js"></script>
    <script src="<?php echo $config_site['url'];?>/js/demo.js"></script>
    <script type="text/javascript">
        function showNotification(colorName, text) {
            if (colorName === null || colorName === '') { colorName = 'bg-black'; }
            if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
            var allowDismiss = true;
            $.notify({
                message: text
            },
            {
                type: colorName,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                timer: 1000,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated fadeOutUp'
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
        }
        function number_format( number, decimals, dec_point, thousands_sep ) {
            var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
            var d = dec_point == undefined ? "," : dec_point;
            var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
            var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t);
        }
    </script>
</body>

</html>