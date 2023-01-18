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
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <title>To Do List</title>
</head>
<body>
<div>
    <div class="wrap">
        <div class="title">To Do List</div>
        <div class="desc">
            <ul>
                <li><?= $rowTotal, "개의 할 일 작성<br>"; ?></li>
                <li><?= $rowTodo, "개 해야함<br>"; ?></li>
                <li><?= $rowDone, "개 완료함<br>"; ?></li>
            </ul>
        </div>
    </div>

    <div>
        <div>
            <form action="todo_update.php" method="post">
                <div class="add_text">
                    <input type="text" name="add_text" placeholder="할 일을 입력하세요.">
                    <button type="submit" name="submit">+</button>
                </div>

            </form>
            <form action="search_list.php" method="get">
                <div class="search">
                    <input type="text" name="search" placeholder="검색하세요" required>
                    <button type="submit" name="submit">검색</button>
                </div>
            </form>
        </div>
    </div>
    <div>
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
                            <?php if($allRow['success']==false) { ?>
                                todo_update.php?check_true=<?php echo $allRow['list_id'] ?>
                          <?php  } else if ($allRow['success']==true) { ?>
                                todo_update.php?check_false=<?php echo $allRow['list_id'] ?>
                          <?php  } else  { ?>
                          <?php  }  ?>
                                ">
                                        <?php echo ($allRow['success'] ? '완료' : '미완료' )?>
                                    </a>
                                </td>
                                <td> <a href="todo_update.php?memo=<?php echo $allRow['list_id'] ?>"><?php echo $allRow['todo_text']; ?> </a></td>
                                <td> <?php echo $allRow['success']; ?> </td>
                                <td> <?php echo $allRow['add_time']; ?> </td>
                                <td> <?php echo $allRow['done_time']; ?> </td>
                                <td> <?php echo $allRow['planned_time']; ?><br>
                                    <form action="todo_update.php">
<!--                                        시작일시 : <input type='text' class='datetimepicker' name='start_dt'  style='width:140px;'>,-->
                                        종료일시 : <input type='text' class='datetimepicker end_dt' name='end_dt'>
                                        <button type="submit" name="submit">
                                        <a href="todo_update.php?planned_time=<?php echo $allRow['list_id'] ?>">
                                                설정
                                        </a>
                                        </button>
                                    </form>
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
</div>
</body>
</html>


<script type="text/javascript">
    $(function() {
        $(".datetimepicker").datetimepicker({
            format: "Y-m-d H:i",
        });
    });

</script>