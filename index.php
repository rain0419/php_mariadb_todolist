<?php
include_once 'DbController.php';

// select
$todoList = $dbconn->getDbResult('toDo', '', '*');

// filter, map, reduce -> 세 개념은 배열 가공하는데 굉장히 중요한 개념!! 공부하기

// row 갯수 출력
$totalCount = count($todoList);
$doneTodoList = array_filter($todoList, function($todo){
    return $todo.success;
});
$doneTodoCount = count($doneTodoList);
$notTodoCount = $totalCount-$doneTodoCount;

//$rowTotal = $dbconn->getDbRows('toDo', '');
//$rowTodo = $dbconn->getDbRows('toDo', 'success=false');
//$rowDone = $dbconn->getDbRows('toDo', 'success=true');
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css">
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
                <li><?= $totalCount, "개의 할 일 작성<br>"; ?></li>
                <li><?= $notTodoCount, "개 해야함<br>"; ?></li>
                <li><?= $doneTodoCount, "개 완료함<br>"; ?></li>
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
            <form action="db_update.php" method="post">
                <input type="text" name="add_text" placeholder="할 일을 입력하세요.">
                <button type="submit" name="submit">+</button>
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
                    <th>delete</th>
                </tr>
                </thead>

                <tbody>
                <?php while ($allRow = mysqli_fetch_array($allSelect)) { ?>
                    <tr>
                        <td> <?php echo $allRow['list_id']; ?> </td>
                        <td> <a id="cheBtn" href="
                            <?php if($allRow['success']==false) { ?>
                                db_update.php?check_true=<?php echo $allRow['list_id'] ?>
                          <?php  } else if ($allRow['success']==true) { ?>
                                db_update.php?check_false=<?php echo $allRow['list_id'] ?>
                          <?php  } else  { ?>
                          <?php  }  ?> ">
                                <?php if ($allRow['success']==false) {
                                    echo '미완료';
                                } else if($allRow['success']==true) {
                                    echo '완료';
                                } else {
                                    echo '--';
                                } ?>
                            </a>
                        </td>
                        <td> <?php echo $allRow['todo_text']; ?> </td>
                        <td> <?php echo $allRow['success']; ?> </td>
                        <td> <?php echo $allRow['add_time']; ?> </td>
                        <td> <?php echo $allRow['done_time']; ?> </td>
                        <td class="delete">
                            <a href="db_update.php?del_list=<?php echo $allRow['list_id'] ?>">x</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>