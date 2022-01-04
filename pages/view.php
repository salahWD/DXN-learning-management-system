<?php
$course_id  = $URL[2];
$item_order = $URL[3];
$item = new Item();

if ($item->get_item_type_id($course_id, $item_order)) {

  if ($item->type == 1):
  
    $lecture = new Lecture();
    $lecture->set_data($lecture->get_lecture($course_id, $item_order));
  
    ?>
    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="embed-responsive mt-4 col-8 embed-responsive-16by9">
          <video id="video-viewr" controls class="w-100">
            <source src="<?php echo theURL . lecturesURL . $lecture->video;?>" type="video/mp4">
            <source src="<?php echo theURL . lecturesURL . $lecture->video;?>" type="video/ogg">
            Error Loding File
          </video>
        </div>
        <div class="col-md-2"></div>
      </div>
      <div class="d-flex justify-content-around mt-2 pb-3">
        <button class="btn btn-primary" type="button">Next</button>
        <button class="btn btn-primary" type="button">Prev</button>
      </div>
    </div>
    <?php
  else:// item type 2 = exam, 1 = lecture
  
    $exam = new Exam();
    $exam->id = $item->id;
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
      </div>
    </div>
    
  <?php endif;
  
}else {?>
  
    <div class="container">
      <div class="alert alert-danger text-center mt-4">
        <h3>غير متاح</h3>
        <p class="lead">هذه المحاضرة غير متاحة. يرجى مشاهدة العناصر بالتسلسل</p>
      </div>
    </div>
  
  <?php  
  }