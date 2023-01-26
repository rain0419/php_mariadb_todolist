<?php
/**
 * Created by PhpStorm.
 * User: pc1
 * Date: 2023-01-12
 * Time: 오후 4:30
 */
require_once 'DbController.php';
// 상속은 a is b 일때!
// 상속말고 그냥 사용으로 바꾸기
//class TodoController

class TodoController extends DbController
{
    // get method
    function getTodoList($where, $column) {
        $result = mysqli_query($this->db, 'SELECT '.$column.' FROM  todo'.($where?' WHERE '.$this->getSqlFilter($where):'').' ORDER BY success DESC, todo_idx DESC');
        return $result;
    }

    // 페이징이 없으므로 의미없음
    function getTodoRowsCount($where){
        $sql = 'SELECT COUNT(*) FROM todo '.($where?' WHERE '.$this->getSqlFilter($where):'');
        if($result = mysqli_query($this->db, $sql)){
            $rows = mysqli_fetch_row($result);
            return $rows[0]?$rows[0]:0;
        }
    }

    // set method      create update delete
    function create($set_key, $set_val) {
        return mysqli_query($this->db, "INSERT INTO todo SET {$set_key} = '{$set_val}' ");
    }

    function update($set, $where) {
        return mysqli_query($this->db, "UPDATE todo SET {$set}".($where?' WHERE '.$this->getSqlFilter($where):''));
    }

    function delete($where)    {
        return mysqli_query($this->db,"DELETE FROM todo ".($where?' WHERE '.$this->getSqlFilter($where):''));
    }

} // end TodoController class

// 인스턴트 생성
$todo_control = new TodoController();
?>