<?php
include_once 'MemberController.php';
$prev_page = $_SERVER['HTTP_REFERER'];

// add_member
if ( isset($_POST['name']) ) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_confirm = $_POST[ 'password_confirm' ];

    $name_result = $member_control->getMemberList("name='".$name."'", 'name');

    if ( !is_null($name) ){
        // 사용자가 있는지 확인
        while ( $name_row = mysqli_fetch_array($name_result)) {
            $name_e = $name_row['name'];
        }
        if ( $name == $name_e ){
            echo '<script> alert("사용자이름이 중복되었습니다."); history.back(); </script>';
        } else if ( $password != $password_confirm ){
            echo '<script> alert("비밀번호가 일치하지 않습니다."); history.back(); </script>';
        } else {
//            password_hash(비밀번호, 암호화 방식)
            $encrypted_password = password_hash( $password, PASSWORD_DEFAULT);
            $add_member = $member_control->create("name='".$name."' ,password='".$password."'");
            echo '<script> alert("회원가입이 완료되었습니다."); location.href="login_form.php"; </script>';
        }
    }
}



