<?php
ini_set('display_errors', 1);
error_reporting(~0);
require_once("constants.php");
require_once("config.php");
require_once("dbcontroller.php");

$dbController = new DBController($connector);
$mCommons = $dbController->getMCommonList();
$mMakers = $dbController->getMMakerList();
$mCarNames = $dbController->getMCarNameList();
$status = "登録";
$from = "register";

if (isset($_GET['id'])) {
    $status = "編集";
    $from = "edit";
    $editData = $dbController->getTCarBaseById($_GET['id']);
}

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
                    <h3>車輌登録画面</h3>
                    <table class="tableTypeB">
                        <tbody>
                            <tr>
                                <th>ステータス</th>
                                <td>
                                    <select name="st_cd">
                                        <?php foreach ($mCommons[CAR_STATUS] as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" <?php if (isset($_GET['id']) && $editData["st_cd"] == $key) {echo "selected";} ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>メーカー名</th>
                                <td>
                                    <select name="maker_cd">
                                        <?php foreach ($mMakers as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if (isset($_GET['id']) && $editData['maker_name'] == $value['name']) { echo "selected"; } ?>> <?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>車名</th>
                                <td>
                                    <select name="car_name_cd">
                                        <?php foreach ($mCarNames as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if (isset($_GET['id']) && $editData['car_name'] == $value['name']) { echo "selected"; } ?>> <?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>型式</th>
                                <td><input type="text" name="car_type" value="<?php echo (isset($editData['car_type'])) ? $editData['car_type'] : ''; ?>" class="wM"></td>
                            </tr>
                            <tr>
                                <th>車台番号</th>
                                <td><input type="text" name="frame_number" value="<?php echo (isset($editData['frame_number'])) ? $editData['frame_number'] : ''; ?>" class="wM"></td>
                            </tr>
                            <tr>
                                <th>初年度登録</th>
                                <td>
                                    <select name="first_entry_date_y">
                                        <?php
                                        $year = date_parse($editData["first_entry_date"])["year"];
                                        for ($y = date("Y"); $y >= 1900; $y--) {
                                        ?>
                                            <option value="<?php echo $y; ?>" <?php if (isset($_GET['id']) && $year == $y) { echo "selected"; } ?>><?php echo $y; ?></option>
                                        <?php } ?>
                                    </select>&nbsp;年&nbsp;
                                    <select name="first_entry_date_m">
                                        <?php
                                        $month = date_parse($editData["first_entry_date"])["month"];
                                        if ($month == 0) {
                                        ?>
                                            <option value="">--</option>
                                        <?php
                                        }
                                        for ($m = 1; $m <= 12; $m++) {
                                        ?>
                                            <option value="<?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>" <?php if (isset($_GET['id']) && $month == $m) { echo "selected"; } ?>><?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?></option>
                                        <?php } ?>
                                    </select>&nbsp;月
                                </td>
                            </tr>
                            <tr>
                                <th>外装色</th>
                                <td><input type="text" name="out_color_name" value="<?php echo (isset($editData['out_color_name'])) ? $editData['out_color_name'] : ''; ?>" class="wM"></td>
                            </tr>
                            <tr>
                                <th>シフト</th>
                                <td>
                                    <select name="shift_posi_cd">
                                        <?php foreach ($mCommons[SHIFT_POSITION] as $key => $value) {?>
                                            <option value="<?php echo $key; ?>" <?php if (isset($_GET['id']) && $editData['shift_posi_cd'] == $key) { echo "selected"; } ?>> <?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>&nbsp;
                                    <input type="text" name="shift_cnt" value="<?php echo (isset($editData['shift_cnt']) && $editData['shift_cnt']) ? $editData['shift_cnt'] : 0; ?>" class="wS">&nbsp;
                                    <select name="shift_cd">
                                        <?php
                                        foreach ($mCommons[SHIFT_CODE] as $key => $value) {
                                        ?>
                                            <option value="<?php echo $key; ?>" <?php if (isset($_GET['id']) && $editData['shift_cd'] == $key) { echo "selected"; } ?>> <?php echo $value; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>小売価格</th>
                                <td><input type="text" name="sale_price" value="<?php echo (isset($editData['sale_price'])) ? $editData['sale_price'] : ''; ?>" class="wM"> 円</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- End of.column -->

                <div class="btnBox">
                    <input type="hidden" name="from" value="<?php echo $from; ?>">
                    <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : ''; ?>">
                    <input type="submit" id="car_submit_btn" class="btnRed wL" value="<?php echo $status; ?>">
                </div>
            </div><!-- End of.inner -->
        </form>
    </div><!-- End of#contents -->

    <div id="footer">
        <p>&#169; COPYLIGHT (C) 2017 GENIO CO.,LTD. ALL RIGHT RESERVED.</p>
    </div>

</div><!-- End of#container -->

<?php
require_once('footer.php');
?>