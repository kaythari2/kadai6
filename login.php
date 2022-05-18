<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(~0);
require_once("config.php");
require_once("dbcontroller.php");

$dbController = new DBController($connector);

$email_error = $password_error = $email = $password = null;
if (isset($_POST["login_btn"])) {
    $email = $_POST["email"] ?: '';
    $password = $_POST["password"] ?: '';
    if (trim($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error="有効なメールアドレスを入力して下さい。";
        }
    }else {
        $email_error="メールアドレスを入力して下さい。";
    }
    $password_error =(trim($password))?"":"パスワードを入力して下さい。";
    if ($email_error=="" && $password_error=="") {
        $login = $dbController->login($email, $password);
        if ($login) {
            if(array_key_exists("user_mail", $login)) {
                $_SESSION['user_mail'] = $login['user_mail'] ?? '';
                header("Location:index.php");
            } else {
                $password_error = $login['password_error'] ?? '';
                $email_error = $login['mail_error'] ?? '';
            }
        } else {
            $password_error = 'Unknown Error.';
            $email_error = 'Unknown Error.';
        }
    }
}

require_once('header.php');
?>
<div id="container">

    <div id="contents" class="clearfix">
        <form id="submit_form" name="submit_form" action="" method="post">
        <div class="inner">
            <h2>ログイン</h2>

            <div class="column">
                <h3>ログイン情報を入力してください。</h3>
                <table class="tableTypeB">
                    <tbody>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"  class="wM">
                                <span style="color: red"><?php echo $email_error; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>パスワード</th>
                            <td>
                               <input type="text" name="password" value="" class="wM">
                               <span style="color: red"><?php echo $password_error; ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- End of.column -->

            <div class="btnBox">
                <input type="submit" id="login_btn" name="login_btn" class="btnRed wL" value="登録"/>
            </div>
        </div><!-- End of.inner -->
        </form>
    </div><!-- End of#contents -->

    <div id="footer"><p>&#169; COPYLIGHT (C) 2017 GENIO CO.,LTD. ALL RIGHT RESERVED.</p></div>

</div><!-- End of#container -->

<?php 
    require_once('footer.php');
?>