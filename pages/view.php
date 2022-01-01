<?php

$course_id  = $URL[2];
$item_order = $URL[3];

$is_allowed = Item::is_allowed($user->student_id, $course_id, $item_order);

if ($is_allowed) {
  
  $item = Item::get_item_type_id($course_id, $item_order);
  
  if ($item) {
  
    if ($item["type"] == 1) {
    
    $exam = new Exam();
    $exam->id = $item["id"];
    $exam->set_data($exam->get_exam());
    $exam->get_questions();
    
    // set exam info in session to push it to exam_proces to presec it
    unset($_SESSION["exam_result"]);
    $_SESSION["exam_result"]["course_id"]  = $course_id;
    $_SESSION["exam_result"]["exam_id"]    = $exam->id;
    $_SESSION["exam_result"]["exam_title"] = $exam->title;
    ?>
    <div class="container">

      <div id="exam">
        <div class="text-center mb-3 mt-3">
          <h2 class="under-line-title d-inline"><?php echo $exam->title;?></h2>
        </div>
        <form method="POST" id="answersForm" action="<?php echo theURL . language . "/exam-proces";?>">
          <?php foreach($exam->questions as $i => $quest):?>
            <div class="question-show p-2">
              <div class="fw-bold question-text h4"><?php echo $i+1 . ". " . $quest->question;?></div>
              <?php foreach($quest->answers as $x => $ansr):?>
                <div class="form-check">
                <?php
                  if ($quest->multible_option == 2):?>
                    <input id="<?php echo $i?>/<?php echo $x;?>" name="questions[<?php echo $quest->id;?>][]" value="<?php echo $ansr->id?>" type="checkbox">
                  <?php else:?>
                    <input id="<?php echo $i?>/<?php echo $x;?>" name="questions[<?php echo $quest->id;?>]" value="<?php echo $ansr->id?>" type="radio">
                  <?php endif;?>
                  <label class="fw-normal" for="<?php echo $i?>/<?php echo $x;?>"><?php echo $ansr->answer;?></label>
                </div>
              <?php endforeach;?>
            </div>
            <hr>
          <?php endforeach;?>
        </form>
        <div class="d-flex justify-content-around mt-4 pb-4">
          <button class="btn btn-primary" id="send" type="submit" form="answersForm">Send</button>
          <a class="btn btn-danger" href="<?php echo theURL . language . "/course/" . $exam->course_id;?>">Cancel</a>
        </div>
  
        <div id="exam">
          <div class="text-center mb-3 mt-3">
            <h2 class="under-line-title d-inline"><?php echo $exam->title;?></h2>
          </div>
          <form method="POST" id="answersForm" data-value="<?php echo $exam->id;?>">
            <input type="hidden" >
            <?php foreach($exam->questions as $i => $quest):?>
              <div class="question-show p-2" data-value="<?php echo $quest->id;?>">
                <div class="fw-bold question-text h4"><?php echo $i+1 . ". " . $quest->question;?></div>
                <?php foreach($quest->answers as $x => $ansr):?>
                  <div class="form-check">
                    <input value="<?php echo $ansr->id?>" <?php if ($quest->multible_option == 2) {echo "type=\"checkbox\"";}else {echo 'type="radio" name="question_' . $quest->id . '"';}?>
                    id="<?php echo $i?>/<?php echo $x;?>">
                    <label class="fw-normal" for="<?php echo $i?>/<?php echo $x;?>"><?php echo $ansr->answer;?></label>
                  </div>
                <?php endforeach;?>
              </div>
              <hr>
            <?php endforeach;?>
          </form>
          <div class="d-flex justify-content-around mt-4 pb-4">
            <button class="btn btn-primary" id="send" type="button">Send</button>
            <a class="btn btn-danger" href="<?php echo theURL . language . "/course/" . $exam->course_id;?>">Cancel</a>
          </div>
        </div>
      </div>
      
      <?php
    }
  
  }else {?>
  
    <div class="container">
      <div class="alert alert-danger text-center mt-4">
        <h3>not avalible</h3>
        <p class="lead">this item is not avalible, please go back to <a class="link" href="<?php echo theURL . language . "/home";?>">Home</a></p>
      </div>
    </div>
  
  <?php  
  }

}else {?>
  
    <div class="container">
      <div class="alert alert-danger text-center mt-4">
        <h3>غير متاح</h3>
        <p class="lead">هذه المحاضرة غير متاحة. يرجى مشاهدة العناصر بالتسلسل</p>
      </div>
    </div>
  
  <?php  
  }