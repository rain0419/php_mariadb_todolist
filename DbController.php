<?php
/**
 * Created by PhpStorm.
 * User: pc1
 * Date: 2023-01-10
 * Time: 오전 10:17
 */

class DbController
{
    // 변수
    private $db_host = 'localhost:3307';
    private $db_user = 'root';
    private $db_password = 'tmakdlf';
    private $db_name = 'study';
    protected $db;
    // protected - 같은 패키지 또는 자식 클래스에서 사용

    // 생성자
    public function __construct()
    {
        $this->db = $this->connectDB();
    }

    // 소멸자
    function __destruct()
    {
        mysqli_close($this->db);
    }

    // DB connect method(외부에서 접근불가)
    private function connectDB() {
        $dbconn = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        mysqli_set_charset($dbconn, "utf8");
        if (mysqli_connect_errno()) {
            printf("Connect failed : %s\n", mysqli_connect_error());
            exit();
        } else {
            return $dbconn;
        }
    }

    // get method
    function getDbResult($table, $where, $column) {
        $result = mysqli_query($this->db, 'SELECT '.$column.' FROM '.$table.($where?' WHERE '.$this->getSqlFilter($where):''));
        return $result;
    }

    function getDbRows($table, $where){
        $sql = 'SELECT COUNT(*) FROM '.$table.($where?' WHERE '.$this->getSqlFilter($where):'');
        if($result = mysqli_query($this->db, $sql)){
            $rows = mysqli_fetch_row($result);
            return $rows[0]?$rows[0]:0;
        }
    } // 필용 없

    function db_fetch_array($que)
    {
        // @는 PHP에서 수행에 지장이 없는 경고 메시지가 나타나지 않도록 하는 기호
        // 결과 레코드 집합에서 한 레코드를 가져와 배열을 생성한다.
        // mysql_fetch_array() 함수가 호출되면 결과 레코드 집합 식별자는 자동으로 다음 레코드로 이동된다
        return mysqli_fetch_array($que);
    }

    function getSqlFilter($sql) {
        return $sql;
    } // 의미 없음

    function getDbError(){
        return mysqli_error($this->db);
    } // 로그로 남기기 ui로 확인하는 건 안 좋음  , 쿼리 뒤에 True 넣으면 결과... , 버전 넣어서 파라미터로 사용하기(질문하기)

    // set method
    // 함수이름 모든 정보 넣기  (유지보수 -> 변수,함수 이름 중요)
    // ex.f_insert_object (blackcircle 방식)
    function setDbInsert($table, $key, $val) {
        return mysqli_query($this->db, "INSERT INTO {$table} set {$key} = '{$val}' ");
    }

    function setDbUpdate($table, $set, $where) {
        return mysqli_query($this->db, "UPDATE {$table} SET {$set}".($where?' WHERE '.$this->getSqlFilter($where):''));
    }

    function setDbDelete($table,$where)    {
        return mysqli_query($this->db,"DELETE FROM ".$table.($where?' where '.$this->getSqlFilter($where):''));
    }

    function setUpdateSuc($success, $list_id ) {
        return mysqli_query($this->db, "UPDATE todo SET success={$success} WHERE list_id={$list_id}");
    }

    // 검색조건에 일치하는 데이터 가져오기
    function setSearchTodo($search) {
        return mysqli_query($this->db, "SELECT * FROM todo WHERE todo_text LIKE {$search}");
    }

    // 예정날짜 받기
    function setPlanTime($planned_time){
        return mysqli_query($this->db, "INSERT INTO todo(planned_time) values ({$planned_time});");
    }

} // end dbClass

// 인스턴트 생성
$dbconn = new DbController();
?>