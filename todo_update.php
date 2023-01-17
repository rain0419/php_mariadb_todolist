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

// success check -> object 로 뜸 (success 의 boolean 값 출력) -> int 로 뜸 boolean 값으로 변경
if (isset($_GET['check'])) {
    $list_id = $_GET['check'];
    $suc = ($dbconn->getDbResult('todo', 'list_id='.$list_id, 'success'));
/*    while($row = mysqli_fetch_array($suc)){
        print_r($row);
    }*/

    $success = mysqli_fetch_row($suc);
    $sucFal = ($success=false);
    $sucTog = ($sucFal ? !$sucFal: $sucFal);
//    var_dump($suc);
    var_dump($success);
//    $done_check = $dbconn->setUpdateSuc($sucTog, $list_id);
//    header('location: index.php');

}

// search
if (isset($_POST['search'])){
    if (empty($_POST['search'])) {
        echo 'Search!!!';
    } else {
        $search_text = $_POST['search'];
        $is_search = $dbconn->setSearchTodo($search_text);
        var_dump($is_search);
//        while ($search_Row = db_fetch_array($is_search)) {
//            echo $search_Row['list_id'], ' | ', ($search_Row['success'] ? '완료' : '미완료' ), ' | ', $search_Row['todo_text'], ' | ', $search_Row['add_time'], ' | ', $search_Row['done_time'], '<br>';
//        }
    }
}

if (isset($_GET['memo'])){
    $list_id = $_GET['memo'];
    $is_memo = $dbconn->getDbResult('todo', '');
}

// 예정 날짜/시간 -> list_id 받아와야 됨
if (isset($_GET['to_date'])){
    $to_date_time = $_GET['to_date'];
    $to_date = $dbconn->setPlanTime($to_date_time);

    header('location: index.php');
}



?>