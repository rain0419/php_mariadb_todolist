<?php
include_once 'TodoController.php';
// 변수에 이전페이지 정보를 저장
$prev_page = $_SERVER['HTTP_REFERER'];

// todo_text_insert
if (isset($_POST['add_text']) && !empty($_POST['add_text'])) {
    $add_text = $_POST['add_text'];
    $todo_text_insert = $todo_control->create('todo_text', $add_text);
    header('location:'.$prev_page);
}

// todo_list_delete
if (isset($_GET['del_list'])) {
    $todo_idx = $_GET['del_list'];
    $todo_list_delete = $todo_control->delete('todo_idx='.$todo_idx);
    header('location:'.$prev_page);
}

// todo_success_check
if (isset($_GET['check_todo_idx'])) {
    $todo_idx = $_GET['check_todo_idx'];
    $todo_suc_col = ($todo_control->getTodoList( 'todo_idx='.$todo_idx, 'success'));
    $todo_suc_val = mysqli_fetch_row($todo_suc_col);
    $suc_val = ($todo_suc_val[0]=='0') ? true : false;
    if ($suc_val) {
        $todo_success_check = $todo_control->update('success=1, done_time=NOW()', 'todo_idx='.$todo_idx);
        header('location:'.$prev_page);
    } else {
        $todo_success_uncheck = $todo_control->update('success=0, done_time=NULL', 'todo_idx='.$todo_idx);
        header('location:'.$prev_page);
    }
}

// todo_planned_datetime
// todo_idx
if ( isset($_GET['planned_datetime']) ){
    $date_time = $_GET['planned_datetime'];
    if (isset($_GET['todo_idx'])) {
        $date_todo_idx = $_GET['todo_idx'];
        $todo_planned_datetime = $todo_control->update('planned_time=\''.$date_time.'\'', 'todo_idx='.$date_todo_idx);
        header('location:'.$prev_page);
    }
}

// todo_edit
if ( isset($_POST['todo_text'])) {
    $text = $_POST['todo_text'];
    $todo_idx = $_POST['edit_todo_idx'];
    $memo = $_POST['todo_memo'];
    $todo_edit =  $todo_control->update('todo_text="'.$text.'", memo="'.$memo.'"', 'todo_idx='.$todo_idx );
//    header('location:'.$prev_page);
    header('location: main.php');
}

?>