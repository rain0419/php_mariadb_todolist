<?php
include_once 'TodoController.php';
// 변수에 이전페이지 정보를 저장
$prev_page = $_SERVER['HTTP_REFERER'];

// todo_text_insert
if (isset($_POST['add_text']) && !empty($_POST['add_text'])) {
    $add_text = $_POST['add_text'];
    $todo_text_insert = $todo_control->setTodoInsert('todo_text', $add_text);
    header('location:'.$prev_page);
}

// todo_list_delete
if (isset($_GET['del_list'])) {
    $list_id = $_GET['del_list'];
    $todo_list_delete = $todo_control->setTodoDelete('list_id='.$list_id);
    header('location:'.$prev_page);
}

// todo_success_check
if (isset($_GET['check_list_id'])) {
    $list_id = $_GET['check_list_id'];
    $todo_suc_col = ($todo_control->getTodoSelectColumn( 'list_id='.$list_id, 'success'));
    $todo_suc_val = mysqli_fetch_row($todo_suc_col);
    $suc_val = ($todo_suc_val[0]=='0') ? true : false;
    if ($suc_val) {
        $todo_success_check = $todo_control->setTodoUpdate('success=1, done_time=NOW()', 'list_id='.$list_id);
        header('location:'.$prev_page);
    } else {
        $todo_success_uncheck = $todo_control->setTodoUpdate('success=0, done_time=NUll', 'list_id='.$list_id);
        header('location:'.$prev_page);
    }
}

// todo_planned_datetime
if ( isset($_GET['planned_datetime']) ){
    $date_time = $_GET['planned_datetime'];
    if (isset($_GET['list_id'])) {
        $date_list_id = $_GET['list_id'];
        $todo_planned_datetime = $todo_control->setTodoUpdate('planned_time=\''.$date_time.'\'', 'list_id='.$date_list_id);
        header('location:'.$prev_page);
    }
}

// todo_edit
if ( isset($_POST['todo_text'])) {
    $text = $_POST['todo_text'];
    $list_id = $_POST['edit_todolist_id'];
    $memo = $_POST['todo_memo'];
    $todo_edit =  $todo_control->setTodoUpdate('todo_text="'.$text.'", memo="'.$memo.'"', 'list_id='.$list_id );
//    header('location:'.$prev_page);
    header('location: index.php');
}

?>