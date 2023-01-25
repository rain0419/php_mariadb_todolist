<?php
include_once 'MemberController.php';

// add_member
if ( isset($_POST['name']) ) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_confirm = $_POST[ 'password_confirm' ];

    $name_result = $member_control->getMemberList('name='.$name, 'name');

    if ( !is_null($name) ){
        // 사용자가 있는지 확인
        while ( $name_row = mysqli_fetch_array($name_result)) {
            $name_e = $name_row['name'];
        }



        $add_member = $member_control->create("name=".$name.", password=".$password);
    }

}












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