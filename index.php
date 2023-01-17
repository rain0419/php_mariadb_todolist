<?php
include_once 'DbController.php';

// select
//$todoList = $dbconn->getDbResult('toDo', '', '*');
// select
$allSelect = $dbconn->getDbResult('toDo', '', '*');

// filter, map, reduce -> 세 개념은 배열 가공하는데 굉장히 중요한 개념!! 공부하기

// row 갯수 출력
//$totalCount = count($todoList);
//$doneTodoList = array_filter($todoList, function($todo){
//    return $todo.success;
//});
//$doneTodoCount = count($doneTodoList);
//$notTodoCount = $totalCount-$doneTodoCount;

$rowTotal = $dbconn->getDbRows('toDo', '');
$rowTodo = $dbconn->getDbRows('toDo', 'success=false');
$rowDone = $dbconn->getDbRows('toDo', 'success=true');
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/reset-css@5.0.1/reset.min.css">
    <link rel="stylesheet" href="./index.css">
    <title>To Do List</title>
</head>
<body>
<div>
    <div>
        <h1>To Do List</h1>
        <!--        --><?php //if($insertTodo || $sucTrue || $sucFalse ) { ?>
        <!--        --><?php //if($insertTodo) { ?>
        <!--        --><?php //if($allSelect) { ?>
        <div class="desc">
            <ul>
                <li><?= $rowTotal, "개의 할 일 작성<br>"; ?></li>
                <li><?= $rowTodo, "개 해야함<br>"; ?></li>
                <li><?= $rowDone, "개 완료함<br>"; ?></li>
            </ul>
        </div>
        <!--        --><?php /*} else {
            echo "실패"."<br>";
            exit();
            로그로 남기기 ui로 확인하는 건 안 좋음
        } */?>
    </div>

    <div>
        <div>
            <form action="todo_update.php" method="post">
                <div class="add_text">
                    <input type="text" name="add_text" placeholder="할 일을 입력하세요.">
                    <button type="submit" name="submit">+</button>
                </div>

            </form>
            <form action="todo_update.php">
                <div class="search">
                    <input type="text" name="search" placeholder="검색하세요" required>
                    <button type="submit" name="submit">검색</button>
                </div>
            </form>
        </div>
    </div>
    <div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>id</th>
                    <th>check</th>
                    <th>text</th>
                    <th>success value</th>
                    <th>add time</th>
                    <th>done time</th>
                    <th>완료예정 날짜/시간</th>
                    <th>memo</th>
                    <th>delete</th>
                </tr>
                </thead>

                <tbody>
                <?php while ($allRow = mysqli_fetch_array($allSelect)) { ?>
                    <tr>
                        <td> <?php echo $allRow['list_id']; ?> </td>
                        <td> <a id="cheBtn" href="
                                todo_update.php?check=<?php echo $allRow['list_id'] ?>">
                                <?php echo ($allRow['success'] ? '완료' : '미완료' )?>
                            </a>
                        </td>
                        <td> <a href="todo_update.php?memo=<?php echo $allRow['list_id'] ?>"><?php echo $allRow['todo_text']; ?> </a></td>
                        <td> <?php echo $allRow['success']; ?> </td>
                        <td> <?php echo $allRow['add_time']; ?> </td>
                        <td> <?php echo $allRow['done_time']; ?> </td>
                        <td> <?php echo $allRow['planned_time']; ?><br>
                            <form action="todo_update.php">
                                <input type="text" name="to_date" id="to_date" placeholder="YYYY-MM-DD hh:mm:ss 형식으로 입력해주세요.">
                            </form>
                                <a href="todo_update.php?to_date=<?php echo $allRow['list_id'] ?>">설정</button>
                        </td>
                        <td> <?php echo $allRow['memo']; ?> </td>
                        <td class="delete">
                            <a href="todo_update.php?del_list=<?php echo $allRow['list_id'] ?>">x</a>
                        </td>

                        <!--<td>
                            <div class="">
                                <input type="text" name="to_date" id="to_date" value="2023-01-20 11:00:00" readonly="readonly">
                            </div>
                        </td>-->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>