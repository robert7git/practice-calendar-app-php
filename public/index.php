<?php
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
?>

<?php
$page_title = "日历首页";
$css_files = array(
	'assets/com/css/base.css',
	'assets/com/css/layout.css',
	'assets/lib/bootstrap/css/bootstrap.min.css',
	'assets/com/css/header.css',
	'assets/com/css/style.css'
);
?>


<?php
$js_files = array(
	'assets/com/js/jquery-1.11.1.min.js',
	'assets/lib/bootstrap/js/bootstrap.js',
	// 'assets/lib/pickadate/scripts/pickadate.js',
	'assets/com/js/init.js'
);
?>
<?php
include_once 'inc/common/header.inc.php';
?>
<link href="assets/widget/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="assets/widget/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="assets/widget/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<!-- <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css"> -->
<!-- <script src="assets/lib/bootstrap/js/bootstrap.js"></script> -->
<!-- <link rel="stylesheet" href="assets/widget/pickadate/themes/default.css" id="theme_base">
<link rel="stylesheet" href="assets/widget/pickadate/themes/default.date.css" id="theme_date">
<link rel="stylesheet" href="assets/widget/pickadate/themes/default.time.css" id="theme_time">

<script src="assets/widget/pickadate/picker.js"></script>
<script src="assets/widget/pickadate/picker.date.js"></script>
<script src="assets/widget/pickadate/picker.time.js"></script>
<script src="assets/widget/pickadate/translations/zh_CN.js"></script>
 -->
<div id="container">
	<div class="content">
		<div class="mod calendar">
			<!-- <div class="mod-hd">
				<h4 class="mod-tit"></h4>
			</div> -->
			<div class="mod-bd">
			<?php
			echo $cal->buildCalendar();
			?>
			</div>
		</div>
	</div>
</div>

<!-- <form action="" class="form-horizontal"  role="form">
        <fieldset>
            <legend>Test</legend>
            <div class="form-group">
                <label for="dtp_input1" class="col-md-2 control-label">DateTime Picking</label>
                <div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
				<input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
			<div class="form-group">
                <label for="dtp_input2" class="col-md-2 control-label">Date Picking</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" /><br/>
            </div>
			<div class="form-group">
                <label for="dtp_input3" class="col-md-2 control-label">Time Picking</label>
                <div class="input-group date form_time col-md-5" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
				<input type="hidden" id="dtp_input3" value="" /><br/>
            </div>
        </fieldset>
    </form>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>
 -->


<?php
include_once 'inc/common/footer.inc.php';
?>







