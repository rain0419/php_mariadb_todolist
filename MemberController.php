<?php
/**
 * Created by PhpStorm.
 * User: pc1
 * Date: 2023-01-25
 * Time: 오후 6:15
 */
require_once 'DbController.php';

class MemberController extends DbController
{
    // get method
    function getMemberList($where, $column) {
        $result = mysqli_query($this->db, 'SELECT '.$column.' FROM name'.($where?' WHERE '.$this->getSqlFilter($where):'').' ORDER BY success DESC, todo_id DESC');
        return $result;
    }





    // set method
    function create($set) {
        return mysqli_query($this->db, "INSERT INTO member SET {$set}");
    }

    function update($set, $where) {
        return mysqli_query($this->db, "UPDATE member SET {$set}".($where?' WHERE '.$this->getSqlFilter($where):''));
    }

    function delete($where)    {
        return mysqli_query($this->db,"DELETE FROM member ".($where?' WHERE '.$this->getSqlFilter($where):''));
    }
} // end MemberController class

// 인스턴트 생성
$member_control = new MemberController();
?>