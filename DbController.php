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

} // end dbClass

// 인스턴트 생성
$dbconn = new DbController();
?>