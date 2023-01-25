<?php
require_once 'MemberController.php';

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];
$password_confirm = $_POST[ 'password_confirm' ];
if ( !is_null( $username ) ) {
    /*$jb_conn = mysqli_connect( 'localhost', 'codingfactory', '1234qwer', 'codingfactory.net_example' );
    $jb_sql = "SELECT username FROM member WHERE username = '$username';";
    $jb_result = mysqli_query( $jb_conn, $jb_sql );*/

    while ( $jb_row = mysqli_fetch_array( $jb_result ) ) {
        $username_e = $jb_row[ 'username' ];
    }
    if ( $username == $username_e ) {
        $wu = 1;
    } elseif ( $password != $password_confirm ) {
        $wp = 1;
    } else {
        $encrypted_password = password_hash( $password, PASSWORD_DEFAULT);
        $jb_sql_add_user = "INSERT INTO member ( username, password ) VALUES ( '$username', '$encrypted_password' );";
        mysqli_query( $jb_conn, $jb_sql_add_user );
        header( 'Location: register-ok.php' );
    }
}
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>회원 가입</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        input, button { font-family: inherit; font-size: inherit; }
    </style>
</head>
<body>
<h1>회원 가입</h1>
<form action="member_update.php" method="POST">
    <p><input type="text" name="name" placeholder="사용자 이름" required></p>
    <p><input type="password" name="password" placeholder="비밀번호" required></p>
    <p><input type="password" name="password_confirm" placeholder="비밀번호 확인" required></p>
    <p><input type="submit" value="회원 가입"></p>
    <?php
    if ( $wu == 1 ) {
        echo "<p>사용자이름이 중복되었습니다.</p>";
    }
    if ( $wp == 1 ) {
        echo "<p>비밀번호가 일치하지 않습니다.</p>";
    }
    ?>
</form>
</body>
</html>