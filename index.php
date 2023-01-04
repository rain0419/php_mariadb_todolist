<?php
$db_host = 'localhost:3307';
$db_user = 'root';
$db_password = 'tmakdlf';
$db_name = 'study';
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("MariaDB 접속 실패!!");
/*if ( mysqli_connect_error($link)) {
    echo "MariaDB 접속 실패!!", "<br>";
    echo "오류 원인 : ", mysqli_connect_error();
    exit();
}
echo "MariaDB 접속 성공!!";
mysqli_close($link);*/

$sql_add_todo = "
               INSERT INTO todo(todo_text) VALUES ($add_text);
    ";
$sql_delete_todo = "
               DELETE FROM toDo WHERE todo_text = '간식먹기';
    ";
$sql_done = "
               UPDATE todo 
                SET
                 success = TRUE, done_time = NOW() WHERE todo_text = '세차하기';
    ";
$sql_do_not = "
               UPDATE todo 
                SET
                 success = FALSE , add_time = NOW() WHERE todo_text = '물 마시기';
    ";

$sql_select = "
                SELECT * FROM toDo;
    ";
$sql_do_not_select = "
                SELECT success FROM todo WHERE success=false;
    ";
$sql_done_select = "
                SELECT success FROM todo WHERE success=true;
    ";



$ret = mysqli_query($link, $sql_add_todo);
$ret_tbl = mysqli_query($link, $sql_select);
$ret_do_not = mysqli_query($link, $sql_do_not_select);
$ret_done = mysqli_query($link, $sql_done_select);

mysqli_close($link);
?>

<html>
<body>
<div>
    <h1>TO DO LIST</h1>
    <div>
        <?php if($ret) { ?>
            <ul>
                <li><?= mysqli_num_rows($ret_tbl), "개의 할 일 작성<br>"; ?></li>
                <li><?= mysqli_num_rows($ret_do_not), "개의 할 일이 있음<br>"; ?></li>
                <li><?= mysqli_num_rows($ret_done), "개의 할 일 완료함<br><br>"; ?></li>
            </ul>
        <?php } else {
            echo "실패"."<br>";
            echo "실패 원인 : ".mysqli_error($link);
            exit();
        } ?>
    </div>

    <div>
        <div>
            <form>
                <input type="text" name="add_text" placeholder="할 일을 입력하세요.">
                <button>추가</button>
            </form>
        </div>
        <div>
            <?php
            while ($row = mysqli_fetch_array($ret_tbl)) {
                echo " - ", $row['todo_text'], " | ",$row['success'], " | ", $row['add_time'], " | ", $row['done_time'], " | ","<br>";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>