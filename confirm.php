<?php
ini_set('display_errors', 1);
error_reporting(~0);
require_once('constants.php');
require_once("config.php");
require_once("dbcontroller.php");

$dbController = new DBController($connector);

if (isset($_POST['confirmed'])) {
	if ($_POST['from'] == "edit") {
		$dbController->updateTCar($_POST['id'], $_POST['st_cd'], $_POST['maker_name'], $_POST['car_name'], strip_tags($_POST['car_type']), strip_tags($_POST['frame_number']), $_POST['first_entry_date'], strip_tags($_POST['out_color_name']), $_POST['shift_cd'], $_POST['shift_cnt'], $_POST['shift_posi_cd'], $_POST['sale_price']);
		header("Location: index.php");
	} else if ($_POST['from'] == "register") {
		$insert = $dbController->insertTCar ($_POST['st_cd'], strip_tags($_POST['maker_name']), strip_tags($_POST['car_name']), strip_tags($_POST['car_type']), strip_tags($_POST['frame_number']), $_POST['first_entry_date'], strip_tags($_POST['out_color_name']), $_POST['shift_cd'], $_POST['shift_cnt'], $_POST['shift_posi_cd'], $_POST['sale_price']);
		header("Location: index.php");
	}
}
$mCommons = $dbController->getMCommonList();
$mCommons = $dbController->getMCommonList();
$mMaker = $dbController->getMMakerById($_POST['maker_cd']);
$mCarName = $dbController->getMCarNameById($_POST['car_name_cd']);

require_once('header.php');
?>
<div id="container">
	<div class="globalNav clearfix">
		<ul>
			<li class="slide">
				<a href="#">トップページ</a>
			</li>
			<li class="slide">
				<a href="./list.html">車輌管理</a>
			</li>
		</ul>
	</div><!-- End of.globalNav -->

	<div id="contents" class="clearfix">
		<form id="submit_form" name="submit_form" action="confirm.php" method="post">
			<div class="inner">
				<h2>車輌管理</h2>

				<div class="column">
					<h3>確認画面</h3>
					<table class="tableTypeB">
						<tbody>
							<tr>
								<th>ステータス</th>
								<td>
									<?php echo $mCommons[1][$_POST['st_cd']]; ?>
									<input type="hidden" name="st_cd" value="<?php echo $_POST['st_cd']; ?>">
								</td>
							</tr>
							<tr>
								<th>メーカー名</th>
								<td>
									<?php echo $mMaker; ?>
									<input type="hidden" name="maker_name" value="<?php echo $mMaker; ?>">
								</td>
							</tr>
							<tr>
								<th>車名</th>
								<td>
									<?php echo $mCarName; ?>
									<input type="hidden" name="car_name" value="<?php echo $mCarName; ?>">
								</td>
							</tr>
							<tr>
								<th>型式</th>
								<td>
									<?php echo htmlspecialchars($_POST['car_type'], ENT_QUOTES, 'UTF-8'); ?>
									<input type="hidden" name="car_type" value="<?php echo htmlspecialchars($_POST['car_type']); ?>">
								</td>
							</tr>
							<tr>
								<th>車台番号</th>
								<td>
									<?php echo htmlspecialchars($_POST['frame_number'], ENT_QUOTES, 'UTF-8'); ?>
									<input type="hidden" name="frame_number" value="<?php echo htmlspecialchars($_POST['frame_number']); ?>">
								</td>
							</tr>
							<tr>
								<th>初年度登録</th>
								<td>
									<?php $month = ($_POST['first_entry_date_m']) ? $_POST['first_entry_date_m'] : '00'; ?>
									<?php echo $_POST['first_entry_date_y']; ?> 年 <?php echo $month; ?> 月
									<input type="hidden" name="first_entry_date" value="<?php echo $_POST['first_entry_date_y'] . $month . '00'; ?>">
								</td>
							</tr>
							<tr>
								<th>外装色</th>
								<td>
									<?php echo htmlspecialchars($_POST['out_color_name'], ENT_QUOTES, 'UTF-8'); ?>
									<input type="hidden" name="out_color_name" value="<?php echo htmlspecialchars($_POST['out_color_name']); ?>">
								</td>
							</tr>
							<tr>
								<th>シフト</th>
								<td>
									<?php echo $mCommons[SHIFT_POSITION][$_POST['shift_posi_cd']] . " " . htmlspecialchars($_POST['shift_cnt']) . " " . $mCommons[SHIFT_CODE][$_POST['shift_cd']]; ?>
									<input type="hidden" name="shift_cd" value="<?php echo $_POST['shift_cd']; ?>">
									<input type="hidden" name="shift_posi_cd" value="<?php echo $_POST['shift_posi_cd']; ?>">
									<input type="hidden" name="shift_cnt" value="<?php echo htmlspecialchars($_POST['shift_cnt']); ?>">
								</td>
							</tr>
							<tr>
								<th>小売価格</th>
								<td>
									<?php echo htmlspecialchars($_POST['sale_price'], ENT_QUOTES, 'UTF-8'); ?> 円
									<input type="hidden" name="sale_price" value="<?php echo htmlspecialchars($_POST['sale_price']); ?>">
								</td>
							</tr>
						</tbody>
					</table>
				</div><!-- End of.column -->

				<div class="btnBox">
					<!-- <input type="button" value="戻る" id="car_submit_btn" class="btnRed wL back_btn""> -->
					<a href=" javascript:history.back();"><input type="button" value="戻る" id="car_submit_btn" class="btnRed wL"></a>
					<input type="hidden" name="from" value="<?php echo $_POST['from']; ?>">
					<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
					<input type="submit" name="confirmed" id="car_submit_btn" class="btnRed wL" value="<?php echo ($_POST['from'] == 'register') ? '登録する' : '編集する'; ?>" />
				</div>
			</div><!-- End of.inner -->
		</form>
	</div><!-- End of#contents -->

	<div id="footer">
		<p>&#169; COPYLIGHT (C) 2017 GENIO CO.,LTD. ALL RIGHT RESERVED.</p>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.back_btn').click(function() {
			console.log('Back Clicked');
			var url = 'register.php';

			$.ajax({
				type: "POST",
				url: url,
				data: {
					'st_cd': '1'
				},
				dataType: 'json',
				success: function(result) {
					// $('.modal-box').text(result).fadeIn(700, function() {
					// 	setTimeout(function() {
					// 		$('.modal-box').fadeOut();
					// 	}, 2000);
					// });
				}
			});
		})
	});
</script>

<?php
require_once('footer.php');
?>