<?php
include_once 'TodoController.php';

if ( isset($_GET['search']) )
$search_text = $_GET['search'];
$where = 'todo_text LIKE \'%'.$search_text.'%\'';
$todo_search = ($todo_control->getTodoList($where, '*'));
$todo_search_count = $todo_control->getTodoRowsCount($where);
// 카운트 쿼리의미 없음 페이징 관련 공부 io 작업(성능 올리기위해 제일 중요한 작업) io 줄이기
?>
<html>
<?php include_once 'head.php'; ?>
<body>
    <div class="container py-5">
        <div class="row d-flex">
            <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                    <div class="card-body py-4 px-4 px-md-5">
                        <a href="index.php" class="fs-2 text mt-3 mb-4 pb-3 text-primary">
                            <i class="fas fa-home"></i>
                        </a>
                        <div class="h1 text-center pb-2">
                            '<?= $search_text ?>' 검색결과 <?= $todo_search_count ?>개
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                            <p class="small mb-0 ms-4 me-2 text-muted">Search</p>
                            <form action="search_list_page.php" method="get">
                                <input class="bg-light border-light rounded-pill form-control-sm" type="text" name="search" placeholder="검색하세요" required>
                                <button type="submit" name="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                            </form>
                        </div>


                        <?php while ($todo_search_row = mysqli_fetch_array($todo_search)) { ?>
                            <ul class="list-group list-group-horizontal rounded-0 bg-transparent">
                                <li class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                                    <div class="d-flex align-items-center form-check">
                                        <a id="cheBtn" href="todo_update.php?check_list_id=<?php echo $todo_search_row['list_id'] ?>">
                                            <?php if ($todo_search_row['success']) { ?>
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
                                                <?php echo $todo_search_row['todo_text']; ?>
                                            </p>
                                        </div>
                                        <div class="text-start text-muted">
                                            <p class="small mb-0">
                                                <?php echo $todo_search_row['memo']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <!--                            예상 날짜 입력란 -->
                                <li class="list-group-item d-flex align-items-center border-0 bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <?php
                                        // 예상날짜 변수
                                        $now_datetime = date('Y-m-d H:i:s');
                                        $plan_datetime = $todo_search_row['planned_time'];
                                        $str_now = strtotime($now_datetime);
                                        $str_plan_datetime = strtotime($plan_datetime);
                                        // strtotime() - 주어진 날짜 형식의 문자열을 1970년 1월 1일 0시 부서 시작하는 유닉스 타임스탬프로 변환
                                        // UNIX time - 1970년 1월 1일 00:00:00 로부터 현재까지의 누적된 초(seconds) 값
                                        ?>
                                        <?php if ( 1 < $str_plan_datetime && $str_plan_datetime <= $str_now) { ?>
                                            <del class="fs-6 text text-black-50 me-3">날짜가 지났습니다 : <?php echo $todo_search_row['planned_time'] ?></del>
                                        <?php } else if ($str_now < $str_plan_datetime) { ?>
                                            <p class="me-3">예상 완료 날짜 : <?php echo $todo_search_row['planned_time'] ?></p>
                                        <?php } else { ?>
                                            <p></p>
                                        <?php } ?>
                                        <p class="small mb-0">
                                        <form class="d-grid gap-2 d-md-flex justify-content-md-end" action="todo_update.php">
                                            <input type='text' class='d-none' name='list_id' value='<?php echo $todo_search_row['list_id'] ?>'>
                                            <input type='text' class='bg-light border-light datetimepicker end_dt form-control-sm' name='planned_datetime' required style="width: 140px;">
                                            <button class="btn btn-warning inline" type="submit" name="submit"><i class="text-white fas fa-calendar-check"></i></button>
                                        </form>
                                        </p>
                                    </div>
                                </li>
                                <!--                            메모 및 편집, 삭제, 날짜시간 출력 -->
                                <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                                    <div class="d-flex flex-row justify-content-end">
                                        <?php if ($todo_search_row['success']) { ?>
                                            <p class="text-info" title="Edit todo"><i class="text-body-tertiary fas fa-pencil-alt me-3"></i></p>
                                        <?php } else { ?>
                                            <a href="todo_edit_page.php?edit_list=<?php echo $todo_search_row['list_id'] ?>" class="text-info" title="Edit todo"><i class="fas fa-pencil-alt me-3"></i></a>
                                        <?php } ?>
                                        <a href="todo_update.php?del_list=<?php echo $todo_search_row['list_id'] ?>" class="text-danger"title="Delete todo"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                    <div class="text-end text-muted ">
                                        <p class="small mb-0"><i class="fas fa-info-circle"></i>
                                            Add <?php echo $todo_search_row['add_time']; ?>
                                            / Done <?php echo $todo_search_row['done_time']; ?>
                                        </p>
                                    </div>
                                </li>

                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>