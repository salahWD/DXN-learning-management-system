<?php

$course_id  = $URL[2];
$item_order = $URL[3];
$item = new Item();

if ($item->get_item_type($course_id, $item_order)) {

  if ($item->type == 1) {
  
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
  }else {// if it's an exam
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $exam = new Exam();
      $exam->set_data($exam->get_exam($course_id, $item_order));
  
      $post_quests = [];
  
      echo "<pre>";
      print_r($_POST);
      echo "</pre>";
      exit();
      foreach($_POST["answers"] as $i => $question):
  
        $quest = new Question();
        $quest->id = $i;
  
        if (is_array($question) && COUNT($question) > 0) {
          foreach($question as $ansr):
            $ans = new Answer();
            $ans->set_data(["id" => $ansr, "question_id" => $i]);
            array_push($quest->answers, $ans);
          endforeach;
        }else {
          $ansr = new Answer();
          $ansr->set_data(["id" => $question, "question_id" => $i]);
          array_push($quest->answers, $ansr);
        }
  
        $post_quests[$quest->id] = $quest;
      endforeach;
      
      if ($user::USER_TYPE <= 2) {
        $result = $exam->compare_answers($exam::ADMIN, $post_quests);
      }else {
        $result = $exam->compare_answers($user->student_id, $post_quests);
      }
  
      $_SESSION["exam_result"] = $result;

      header("Location: " . theURL . language . "/exam-result");
      exit();
  
    }else {
  
      $exam = new Exam();
      $exam->id = $exam->get_id_by_order($course_id, $item_order);
      $exam->get_questions();
      ?>
      <div class="container">
        <h2 class="text-center mb-3 mt-3 h2"><?php echo $exam->title;?></h2>
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
          <button class="btn btn-danger" type="button">Cancel</button>
        </div>
      </div>
      <?php
    }
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