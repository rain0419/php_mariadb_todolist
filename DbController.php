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
    protected function connectDB() {
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
    // 검색조건을 입력시 SQL Injection 필터링 함수를 한번 거쳐서 where 조건문에서 해킹 방지를 해주는 것
    // 방지 로직 넣기
    function getSqlFilter($str) {
        // 해킹 공격을 대비하기 위한 코드
//        $str = preg_replace("/\s{1,}1\=(.*)+/","",$str); // 공백이후 1=1이 있을 경우 제거
//        $str = preg_replace("/\s{1,}(or|and|null|where|limit)/i"," ",$str); // 공백이후 or, and 등이 있을 경우 제거
//        $str = preg_replace("/[\s\t\'\;\=]+/","", $str); // 공백이나 탭 제거, 특수문자 제거
        return $str;
    }

} // end dbClass

// 인스턴트 생성
$dbconn = new DbController();
?>