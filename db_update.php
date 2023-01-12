<?php
include_once 'DbController.php';

// table별로 클래스 생성
// ex.TodoController.php

// select
$allSelect = $dbconn->getDbResult('toDo', '', '*');
//$allRow = mysqli_fetch_array($allSelect);

// insert -> 클래스로 분리해서 사용 (비즈니스로직과 분리해서 초기부터 기존 것 안 건드리면서 새로운 기능 추가하기)
if (isset($_POST['add_text'])) { // 라우터 기능과 클래스코드 분리하기
    if (empty($_POST['add_text'])) {
        echo "Write To Do";
    }else{
        $add_text = $_POST['add_text'];
        $insertDb = $dbconn->setDbInsert('toDo', 'todo_text', $add_text);
        header('location: index.php');
    }
}

// delete
if (isset($_GET['del_list'])) {
    $list_id = $_GET['del_list'];

    $delDb = $dbconn->setDbDelete('toDo', 'list_id='.$list_id);
    header('location: index.php');
}

// update check true
if (isset($_GET['check_true'])) {
    $list_id = $_GET['check_true'];

    // 쿼리 한 줄로 수정(효율성)
    // 토글로 반전값 써줘서 하나로 합치기 (index.php의 If 절도 포함해서 총 4개 줄 -> 한 줄로 수정하기)
    $done_check = $dbconn->setDbUpdate('toDo','success=1', 'list_id='.$list_id);
    $done_time = $dbconn->setDbUpdate('toDo','done_time=NOW()', 'list_id='.$list_id);
    header('location: index.php');

}

// update check false
if (isset($_GET['check_false'])) {
    $list_id = $_GET['check_false'];

    $do_check = $dbconn->setDbUpdate('toDo','success=0', 'list_id='.$list_id);
    $add_time = $dbconn->setDbUpdate('toDo','add_time=NOW()', 'list_id='.$list_id);
    header('location: index.php');
}
?>