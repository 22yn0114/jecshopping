<?php
require_once './helpers/MemberDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $membername = $_POST['membername'];
    $zipcode = $_POST['zipcode'];
    $address = $_POST['address'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $tel3 = $_POST['tel3'];

    $memberDAO = new MemberDAO();


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errs['email'] = 'メールアドレスの形式が正しくありません。';
    } else if ($memberDAO-> email_exists($email)) {
        $errs['email'] = 'このメールアドレスはすでに登録されています。';
    }
    if (!preg_match('/\A.{4,}\z/', $password)) {
        $errs['password'] = 'パスワードは4文字以上で入力して下さい。';
    } else if () {
        $errs['password'] = "パスワードが一致しません。";
    }
    if (empty($membername)) {
        $errs['membername'] = 'お名前を入力して下さい。';
    }
    if (!filter_var($zipcode, FILTER_VALIDATE_EMAIL)) {
        $errs['zipcode'] = '郵便番号は3桁-4桁で入力して下さい。';
    }
    if (empty('zipode')) {
        $errs['zipcode'] = '住所を入力して下さい。';
    }
    if (!preg_match('/\A(\d{2,5})?\z/', $tel1) || !preg_match('/\A(\d{1,4})?\z/', $tel2) || !preg_match('/\A(\d{4})?\z/', $tel3)) {
        $errs['tel'] = '電話番号は半角数字2～5桁、1～4桁、4桁で入力して下さい。';
    }
    if (empty($errs)) {
        $member = new member();
        $member->email = $email;
        $member->password = $password;
        $member->membername = $membername;
        $member->zipcode = $zipcode;
        $member->address = $address;
        if ($tel1 !== '' && $tel2 !== '' && $tel3 !== '') {
            $member->tel = "{$tel1}-{$tel2}-{$tel3}";
        }
        $memberDAO->insert($member);
        header('Location:signupEnd.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>新規会員登録</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <h1>会員登録</h1>
    <p>以下の項目を入力し、登録ボタンをクリックしてください(*は必須)</p>
    <form action="" method="POST">
        <table>
            <tr>
                <td>メールアドレス*</td>
                <td><input type="email" name="email" value="<?= @$email ?>" autofocus></td>
                <span style="color:red"><?= @$errs['email'] ?></span>
            </tr>
            <tr>
                <td>パスワード(4文字以上)*</td>
                <td><input type="password" name="password" minlength="4" maxlength="10"></td>
                <span style="color:red"><?= @$errs['password'] ?></span>
            </tr>
            <tr>
                <td>パスワード(再入力)*</td>
                <td><input type="password" name="password2" minlength="4" maxlength="10"></td>

            </tr>
            <tr>
                <td>お名前*</td>
                <td><input type="text" name="membername" minlength="1" maxlength="10" required></td>
                <span style="color:red"><?= @$errs['name'] ?></span>
            </tr>
            <tr>
                <td>郵便番号*</td>
                <td><input type="text" name="zipcode" pattern="\d{3}-\d{4}" title="郵便番号は3桁-4桁で(-)を入れて記入して下さい。"></td>
                <span style="color:red"><?= @$errs['zipocde'] ?></span>
            </tr>
            <tr>
                <td>住所*</td>
                <td><input type="text" name="address"></td>
                <span style="color:red"><?= @$errs['address'] ?></span>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <input type="tel" name="tel1" size="4"> -
                    <input type="tel" name="tel2" size="4"> -
                    <input type="tel" name="tel3" size="4">
                </td>
            </tr>
        </table>
        <input type="submit" value="登録する">
    </form>

</body>

</html>