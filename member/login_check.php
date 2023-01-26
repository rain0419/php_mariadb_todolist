<?php
include_once 'MemberController.php';
$prev_page = $_SERVER['HTTP_REFERER'];

$name = $_POST["name"];
$password = $_POST['password'];
//POST로 받아온 아이다와 비밀번호가 비었다면 알림창을 띄우고 전 페이지로 돌아갑니다.
if($name == "" || $password == ""){
    echo '<script> alert("아이디나 패스워드 입력하세요"); history.back(); </script>';
}else{
    $member_check_result = $member_control->getMemberList("name='".$name."' AND password='".$password."'", "*");
//    var_dump($name_result);

    $member_row = $member_check_result->fetch_array(MYSQLI_ASSOC);
    // array(3) { ["member_idx"]=> string(2) "16" ["name"]=> string(5) "lemon" ["password"]=> string(4) "asdf" }
//    $member_row = mysqli_fetch_array($member_check_result);
    // array(6) { [0]=> string(2) "16" ["member_idx"]=> string(2) "16" [1]=> string(5) "lemon" ["name"]=> string(5) "lemon" [2]=> string(4) "asdf" ["password"]=> string(4) "asdf" }
//    var_dump($member_row);


//    $result->free();
//    쿼리의 결과를 이용하고 난 후에는 불필요한 리소스 낭비를 위해서 메모리를 해제 시켜줍니다.

    // 결과가 존재하면 세션 생성
    if ( $member_row != null ){
        session_start();
        $_SESSION['username'] = $member_row['name'];
        $_SESSION['password'] = $member_row['password'];
        $_SESSION['member_idx'] = $member_row['member_idx'];
        echo "<script>alert('로그인되었습니다.'); location.href='../main.php';</script>";
    } else {
        echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";
    }
}


