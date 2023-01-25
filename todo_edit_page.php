<?php
include_once 'TodoController.php';
// post get 말고 put - restfull api 공부
// 모달창으로 바꾸기
if ( isset($_GET['edit_list'])){
    $edit_list_id = $_GET['edit_list'];
    $edit_todo_select = $todo_control->getTodoList('list_id='.$edit_list_id,'*');
    $edit_todo = mysqli_fetch_array($edit_todo_select);
}
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
                        수정하기
                    </div>

                    <hr class="my-4">

                    <form action="todo_update.php" method="post">
                        <div class="pb-2">
                            <div class="card">
    <!--                            <div class="card-body">-->
    <!--                                <div id="in_title">-->
                                        <textarea name="todo_text" class="form-control form-control-lg me-3" rows="1" cols="55" placeholder="할일" maxlength="100" required><?php echo $edit_todo['todo_text']; ?></textarea>
                                        <input type='text' class='d-none' name='edit_todolist_id' value='<?php echo $edit_todo['list_id'] ?>'>
    <!--                                </div>-->
    <!--                            </div>-->
                            </div>
                        </div>
                        <div class="mb-4 pt-2 pb-3">
                            <textarea name="todo_memo" class="form-control form-control-lg me-3" id="ucontent" placeholder="메모"><?php echo $edit_todo['memo']; ?></textarea>
                            <div class="text-end">
                                <button type="submit" class="text text-right btn btn-primary mt-3">저장</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>