<?php
include_once 'DbController.php';

// select
$allSelect = $dbconn->getDbResult('toDo', '', '*');
$allRow = mysqli_fetch_array($allSelect);

// insert
if (isset($_POST['add_text'])) {
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