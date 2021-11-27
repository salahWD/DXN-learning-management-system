<?php

$course_id  = $URL[2];
$item_order = $URL[3];

$is_allowed = Item::is_allowed($user->student_id, $course_id, $item_order);

if ($is_allowed) {
  
  $item = Item::get_item_type_id($course_id, $item_order);
  
  if ($item) {
  
    if ($item["type"] == 1) {
    
      $lecture = new Lecture();
      $lecture->id = $item["id"];
      $lecture->set_data($lecture->get_lecture());
    
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
          <a class="btn btn-primary" href="<?php echo theURL . language . "/view/" . $course_id . "/" . ($item_order + 1);?>">Next</a>
          <a class="btn btn-danger" href="<?php echo theURL . language . "/course/" . $course_id;?>">Cancel</a>
        </div>
      </div>
      <?php
    }else {// if it's an exam
      
      $exam = new Exam();
      $exam->id = $item["id"];
      $exam->set_data($exam->get_exam());
      $exam->get_questions();
      ?>
      <div class="container">
  
        <div class="result d-none" id="result">
          <div class="text-center mb-4 mt-3">
            <h2 class="under-line-title d-inline"><?php echo $exam->title;?></h2>
          </div>
          <div class="alert text-center" id="result-alert">
            <h4 class="fw-bold" id="result-status"></h4>
            <p class="lead" id="result-text"></p>
            <div class="card bordered" id="result-itemsContaioner">
              <ul class="list-unstyled list-group list-group-flush" id="result-items">
              </ul>
            </div>
          </div>
          <div class="d-flex justify-content-around mt-4 pb-4">
            <a class="btn btn-success" data-target="<?php echo theURL . language . "/view/" . $exam->course_id . "/" . (intval($item_order) + 1);?>">Next</a>
            <a class="btn btn-danger" href="<?php echo theURL . language . "/view/" . $exam->course_id . "/" . $item_order;?>">Redo</a>
          </div>
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