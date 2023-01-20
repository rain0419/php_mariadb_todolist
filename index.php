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
<!--    <link rel="stylesheet" href="./index.css">-->
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>To Do List</title>
</head>
<body>
<!--<section class="vh-100">-->
    <div class="container py-5">
        <div class="row d-flex">
            <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                    <div class="card-body py-4 px-4 px-md-5">
                        <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">To Do List</p>
                        <ul>
                            <li><?= $rowTotal, "개의 할 일 작성<br>"; ?></li>
                            <li><?= $rowTodo, "개 해야함<br>"; ?></li>
                            <li><?= $rowDone, "개 완료함<br>"; ?></li>
                        </ul>

                        <div class="pb-2">

                            <div class="card">
                                <div class="card-body">
                                    <form action="todo_update.php" method="post" class="d-flex flex-row align-items-center">
                                        <input type="text" class="form-control form-control-lg me-3" id="exampleFormControlInput1" name="add_text" placeholder="할 일을 입력하세요.">
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                            <p class="small mb-0 ms-4 me-2 text-muted">Search</p>
                            <form action="search_list.php" method="get">
                                <input class="bg-light border-light rounded-pill form-control-sm" type="text" name="search" placeholder="검색하세요" required>
                                <button type="submit" name="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                            </form>
                        </div>


                        <?php while ($allRow = mysqli_fetch_array($allSelect)) { ?>
                        <ul class="list-group list-group-horizontal rounded-0 bg-transparent">
<!--                            <li class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">-->
                            <li class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                                <div class="d-flex align-items-center form-check">
                                    <a id="cheBtn" href="todo_update.php?check=<?php echo $allRow['list_id'] ?>">
                                        <?php if ($allRow['success']) { ?>
                                            <i class="fas fa-check-square"></i>
                                        <?php } else { ?>
                                            <i class="far fa-square"></i>
                                        <?php } ?>
                                    </a>
                                </div>
                            </li>
                            <li class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row justify-content-start mb-1">
                                        <p class="lead fw-normal mb-0">
                                            <?php echo $allRow['list_id']; ?>
                                            <?php echo $allRow['todo_text']; ?>
                                        </p>
                                    </div>
                                    <div class="text-start text-muted">
                                        <p class="small mb-0">
                                            <?php echo $allRow['memo']; ?>
                                        </p>
                                    </div>
                                </div>
                            </li>
<!--                            예상 날짜 입력란 -->
                            <li class="list-group-item d-flex align-items-center border-0 bg-transparent">
                                <div class="d-flex align-items-center">
                                    <?php $now = date('Y-m-d H:i:s');
                                    $planTime = $allRow['planned_time'];
                                    $strNow = strtotime($now);
                                    $strPlanTime = strtotime($planTime);
//                                    var_dump($strNow);
//                                    var_dump($strPlanTime);
//                                  strtotime() - 주어진 날짜 형식의 문자열을 1970년 1월 1일 0시 부서 시작하는 유닉스 타임스탬프로 변환
//                                  UNIX time - 1970년 1월 1일 00:00:00 로부터 현재까지의 누적된 초(seconds) 값
                                    ?>
                                    <?php if ( 1 < $strPlanTime && $strPlanTime <= $strNow) { ?>
                                        <del class="fs-6 text text-black-50 me-3">날짜가 지났습니다 : <?php echo $allRow['planned_time'] ?></del>
                                    <?php } else if ($strNow < $strPlanTime) { ?>
                                        <p class="me-3">예상 완료 날짜 : <?php echo $allRow['planned_time'] ?></p>
                                    <?php } else { ?>
                                        <p></p>
                                    <?php } ?>
                                    <p class="small mb-0">
                                        <form class="d-grid gap-2 d-md-flex justify-content-md-end" action="todo_update.php">
                                                <input type='text' class='d-none' name='list_id' value='<?php echo $allRow['list_id'] ?>'>
                                                <input type='text' class='bg-light border-light datetimepicker end_dt form-control-sm' name='end_dt' style="width: 140px;">
                                                <button class="btn btn-warning inline" type="submit" name="submit"><i class="text-white fas fa-calendar-check"></i></button>
                                        </form>
<!--                                        </a>-->
                                    </p>
                                </div>
                            </li>
<!--                            메모 및 편집, 삭제, 날짜시간 출력 -->
                            <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                                <div class="d-flex flex-row justify-content-end">
                                    <?php if ($allRow['success']) { ?>
                                    <p class="text-info" title="Edit todo"><i class="text-body-tertiary fas fa-pencil-alt me-3"></i></p>
                                    <?php } else { ?>
                                    <a href="todo_edit_page.php?edit_list=<?php echo $allRow['list_id'] ?>" class="text-info" title="Edit todo"><i class="fas fa-pencil-alt me-3"></i></a>
                                    <?php } ?>
                                    <a href="todo_update.php?del_list=<?php echo $allRow['list_id'] ?>" class="text-danger"title="Delete todo"><i class="fas fa-trash-alt"></i></a>
                                </div>
                                <div class="text-end text-muted ">
<!--                                    <a href="#!" class="text-muted" data-mdb-toggle="tooltip" title="Created date">-->
                                        <p class="small mb-0"><i class="fas fa-info-circle"></i>
                                            Add <?php echo $allRow['add_time']; ?>
                                            / Done <?php echo $allRow['done_time']; ?>
                                        </p>
<!--                                    </a>-->
                                </div>
                            </li>

                        </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>
</html>


<script type="text/javascript">
    $(function() {
        $(".datetimepicker").datetimepicker({
            format: "Y-m-d H:i",
        });
    });

</script>