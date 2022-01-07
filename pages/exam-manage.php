<?php

$order        = $URL[3];

$exam         = new Exam();
$exam->id     = $URL[2];
$exam->set_data($exam->get_exam($exam->id));

$course       = new Course();
$course->id   = $exam->course_id;

# permission check
if ($user::USER_TYPE == 2):
  $course->permission = $course->get_teacher_permission($user->teacher_id);
  if (!$course->check_permission("UPDATE")):?>
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="alert alert-danger mt-4">
            <div class="alert-title">لا تملك الصلاحيات</div>
            <p class="lead">عذرا يبدو انك لا تملك صلاحيات التعديل</p>
          </div>
        </div>
      </div>
    </div> 
    <?php
    exit();
  endif;
endif;

if ($order == "add") {// there is add tag
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $question = new Question();
  
    $is_multiple = isset($_POST["is_multiple"]) ? 2: 1;

    // Create Array Of Answer Objects
    if (isset($_POST["question"]) && (isset($_POST["answer"]) || isset($_POST["update"]))) {

      $info = [
        "exam_id"         => $exam->id,
        "question"        => $_POST["question"],
        "answers"         => $_POST["answer"],
        "multible_option" => $is_multiple,
      ];
    
      $question->set_data($info);
      
      if ($question->insert_question()) {
        header("Location: " . theURL . language . "/exam-manage/" . $exam->id . "/add");
        exit();
      }else {
        echo "Error: inserting";// error
        exit();
      }

    }else {
      echo "Error: info is not full";// error
      exit();
    }
  }

}else {// if there is question Order 

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $is_multiple = isset($_POST["is_multiple"]) ? 2: 1;
    
    $update = [];
    if (isset($_POST["update"]) && !empty($_POST["update"]) && count($_POST["update"]) > 0) {
      foreach ($_POST["update"] as $upd) {
        $obj = new Answer();
        $obj->set_data($upd);
        array_push($update, $obj);
      }
    }else {
      echo "Error: no Update Answers Found";//error
      exit();
    }
  
    $info = [
      "id"              => $_POST["quest_id"],
      "exam_id"         => $exam->id,
      "question"        => $_POST["question"],
      "update"          => $update,
      "answers"         => $_POST["answer"],
      "order"           => 1,
      "multible_option" => $is_multiple,
    ];
    
    $question = new Question(); 
    $question->set_data($info);

    if (count($question->update) > 0) {
      $question->update_question();
    }

    header("Location: " . theURL . language . "/exam-manage/" . $exam->id . "/" . $order);
    exit();
    
  }// end post order

  if (isset($URL[4]) && $URL[4] == "del") {

    $question = new Question();
    $result = $question->delete_question_by_order($exam->id, $order);

    if ($result):
      header("Location: " . theURL . language . "/exam-manage/" . $exam->id . "/add");
    else:?>
      <div class="container">
        <div class="alert alert-danger mt-4 text-center">
          <h3 class="title">يتعذر الحذف</h3>
          <p>يبدو ان هناك خطأ يمنع حذف هذا السؤال.</p>
        </div>
      </div>
      <?php
    endif;
    exit();
  }

  $quest  = new Question();

  $data = $quest->get_question_by_order($exam->id, $order);

  if (!empty($data)):
    $quest->set_data($data);

  else:?>
    <div class="container">
      <div class="alert alert-danger mt-4 text-center">
        <h3 class="title">لا يوجد سؤال بهذا الترتيب</h3>
        <p>يبدو انه لا يوجد سؤال بالترتيب المطلوب</p>
      </div>
    </div>
    <?php
    exit();
  endif;

}
  ?>

<form action="<?php echo theURL . language . "/exam-manage/" . $exam->id . "/" . $order;?>" method="post">
  <div class="container">
    <h2 class="text-center mt-3"><?php echo $exam->title;?></h2>
    <hr>
    <div class="row" id="question-container">
      <div class="col-md-2">
        <div class="card text-center">
          <div class="card-header">Questions</div>
          <div class="card-body d-flex align-items-center flex-column" id="question-bar">
            <?php for ($i = 1; $i <= $exam->questions_count; $i++):?>
            <a href="<?php echo theURL . language . "/exam-manage/" . $exam->id . "/" . $i;?>" class="badge mb-3 question rounded-pill bg-primary"><?php echo $i;?></a>
            <?php endfor;?>
            <a href="<?php echo theURL . language . "/exam-manage/" . $exam->id . "/add";?>" class="badge mb-1 question null rounded-pill border border-info">
              <i class="fa fa-plus"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="col-9">
        <div class="card">
          <div class="card-header">
            <?php echo isset($quest->id) ? '<input type="hidden" name="quest_id" value="' . $quest->id . '">': '';?>
            <h3 class="card-title text-center" id="question-content"><?php echo isset($quest->question) ? $quest->question: "Question";?></h3>
              <input type="hidden" class="form-control mb-3" placeholder="Question" id="question-input" name="question" value="<?php echo isset($quest->question) ? $quest->question: "Question";?>">
            <div class="d-flex justify-content-around">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_multiple" id="is_multiple"
                <?php echo isset($quest->multible_option) && $quest->multible_option == 2 ? "checked": "";?>>
                <label class="form-check-label" for="is_multiple">multiple currect answers</label>
              </div>
            </div>
          </div>
          <div class="card-body" id="answer-container">
            <?php if (isset($quest) && !empty($quest->answers)): ?>
              <?php foreach($quest->answers as $i => $answer):?>
                <div class="input-group answer mb-3" data-status="update">
                  <input type="hidden" name="update[<?php echo $i;?>][is_right]" value="<?php echo $answer->is_right == 2 ? 2: 1;?>">
                  <input type="hidden" name="update[<?php echo $i;?>][id]" value="<?php echo $answer->id;?>">
                  <input type="text" class="form-control" name="update[<?php echo $i;?>][answer]" placeholder="Answer <?php echo $i;?>" <?php echo "value=\"" . $answer->answer . "\"";?>>
                  <button class="btn <?php if ($answer->is_right == 2) {echo "active";}?> check-answer btn-outline-success" type="button"><i class="fa fa-lg fa-check"></i></button>
                  <button class="btn delete-answer btn-outline-danger" type="button"><i class="fa fa-lg fa-trash"></i></button>
                </div>
              <?php endforeach;?>
            <?php else:// default tow answers ?>
              <div class="input-group answer mb-3" data-status="add">
                <input type="hidden" class="d-none" name="answer[1][is_right]" value="1">
                <input type="text" class="form-control" name="answer[1][answer]" placeholder="Answer 1">
                <button class="btn check-answer btn-outline-success" type="button"><i class="fa fa-lg fa-check"></i></button>
                <button class="btn delete-answer btn-outline-danger" type="button"><i class="fa fa-lg fa-trash"></i></button>
              </div>
              <div class="input-group answer mb-3" data-status="add">
                <input type="hidden" class="d-none" name="answer[2][is_right]" value="1">
                <input type="text" class="form-control" name="answer[2][answer]" placeholder="Answer 2">
                <button class="btn check-answer btn-outline-success" type="button"><i class="fa fa-lg fa-check"></i></button>
                <button class="btn delete-answer btn-outline-danger" type="button"><i class="fa fa-lg fa-trash"></i></button>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-md-1">
        <?php if (is_numeric($order)):?>
        <button data-bs-target="#deleteItem" data-bs-toggle="modal" class="btn btn-danger w-100"><i class="fa fa-lg fa-trash"></i></button>
        <div class="modal fade" id="deleteItem" tabindex="-1" aria-labelledby="addItem" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header border-bottom-danger">
                <h4 class="modal-title">تأكيد</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>هل أنت متأكد من حذف هذا السؤال نهائيا ؟</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                <a href="<?php echo theURL . language . "/exam-manage/" . $exam->id . "/" . $order . "/del";?>" class="btn btn-danger">حذف</a>
              </div>

            </div>
          </div>
        </div>
        <?php endif;?>
        <button id="add-answer" class="btn btn-primary mt-2 w-100"><i class="fa fa-lg fa-plus"></i></button>
      </div>
      <input type="submit" class="btn mt-4 btn-primary" value="submit">
    </div>
  </div>
</form>