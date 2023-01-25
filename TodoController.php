<?php
/**
 * Created by PhpStorm.
 * User: pc1
 * Date: 2023-01-12
 * Time: 오후 4:30
 */
require_once 'DbController.php';
// 상속 a is b 일때
class TodoController extends DbController
{
    // get method
    // 검색조건을 입력시 SQL Injection 필터링 함수를 한번 거쳐서 where 조건문에서 해킹 방지를 해주는 것
    // 방지 로직 넣기
    function getSqlFilter($sql) {
        return $sql;
    }

    function getTodoList($where, $column) {
        $result = mysqli_query($this->db, 'SELECT '.$column.' FROM  todo'.($where?' WHERE '.$this->getSqlFilter($where):''));
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