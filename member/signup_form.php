<?php
require_once 'MemberController.php';

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
<form action="signup_check.php" method="POST">
    <p><input type="text" name="name" placeholder="사용자 이름" required></p>
    <p><input type="password" name="password" placeholder="비밀번호" required></p>
    <p><input type="password" name="password_confirm" placeholder="비밀번호 확인" required></p>
    <p><input type="submit" value="회원 가입"></p>
</form>
</body>
</html>