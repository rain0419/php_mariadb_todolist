<?php
include_once 'DbController.php';
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/reset-css@5.0.1/reset.min.css">
    <link rel="stylesheet" href="./index.css">
    <title>검색 페이지</title>
</head>
<body>
<div>
<?php
//search 변수
    $search_text = $_GET['search'];
    $is_search = $dbconn->setSearchTodo($search_text);
?>

    <div>
        <a class="title" href="index.php">홈으로</a>
        <div class="desc">
            <ul>
                <li><?= $search_text, " 로 검색한 결과<br>"; ?></li>
            </ul>
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
                    <?php while ($searchRow = mysqli_fetch_array($is_search)) { ?>
                        <tr>
                            <td> <?php echo $searchRow['list_id']; ?> </td>
                            <td> <a id="cheBtn" href="
                            <?php if($searchRow['success']==false) { ?>
                                todo_update.php?check_true=<?php echo $searchRow['list_id'] ?>
                          <?php  } else if ($searchRow['success']==true) { ?>
                                todo_update.php?check_false=<?php echo $searchRow['list_id'] ?>
                          <?php  } else  { ?>
                          <?php  }  ?>
                                ">
                                    <?php echo ($searchRow['success'] ? '완료' : '미완료' )?>
                                </a>
                            </td>
                            <td> <a href="todo_update.php?memo=<?php echo $searchRow['list_id'] ?>"><?php echo $searchRow['todo_text']; ?> </a></td>
                            <td> <?php echo $searchRow['success']; ?> </td>
                            <td> <?php echo $searchRow['add_time']; ?> </td>
                            <td> <?php echo $searchRow['done_time']; ?> </td>
                            <td> <?php echo $searchRow['planned_time']; ?><br>
                                <form action="todo_update.php">
                                    <input type="text" name="to_date" id="to_date" placeholder="YYYY-MM-DD hh:mm:ss 형식으로 입력해주세요.">
                                </form>
                                <a href="todo_update.php?to_date=<?php echo $searchRow['list_id'] ?>">설정</button>
                            </td>
                            <td> <?php echo $searchRow['memo']; ?> </td>
                            <td class="delete">
                                <a href="todo_update.php?del_list=<?php echo $searchRow['list_id'] ?>">x</a>
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