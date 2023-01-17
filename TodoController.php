<?php
/**
 * Created by PhpStorm.
 * User: pc1
 * Date: 2023-01-12
 * Time: 오후 4:30
 */
include_once 'DbController.php';

class TodoController
{
    public $add_text = '';

    function __construct($text)
    {
        $this->add_text = $text;
    }


    function todoInsertText()
    {

        $add_text = $_POST['add_text'];
        // insert -> 클래스로 분리해서 사용 (비즈니스로직과 분리해서 초기부터 기존 것 안 건드리면서 새로운 기능 추가하기)
        if (isset($_POST['add_text']) && $_POST['add_text']) { // 라우터 기능과 클래스코드 분리하기
            $add_text = $_POST['add_text'];
            $insertDb = $db_conn->setDbInsert('toDo', 'todo_text', $add_text);
            header('location: index.php');
        }
        return mysqli_query($this->db, "INSERT INTO todo set todo_text = '{$add_text}' ");
    }

    function todoUpdateSuccess()
    {
// update check true
        if (isset($_GET['check']) && ) {
            $list_id = $_GET['check'];



            $done_check = $db_conn->setDbUpdate('toDo', 'success=1', 'list_id=' . $list_id);
            $done_time = $db_conn->setDbUpdate('toDo', 'done_time=NOW()', 'list_id=' . $list_id);

            $do_check = $db_conn->setDbUpdate('toDo', 'success=0', 'list_id=' . $list_id);
            $add_time = $db_conn->setDbUpdate('toDo', 'add_time=NOW()', 'list_id=' . $list_id);
            header('location: index.php');

        }


    function todoDeleteList()
    {
        if (isset($_GET['del_list'])) {
            $list_id = $_GET['del_list'];

            $delDb = $db_conn->setDbDelete('toDo', 'list_id=' . $list_id);
            header('location: index.php');
        }
    }

} // TodoController end

// 인스턴트 생성
$todo_control = new TodoController();
?>