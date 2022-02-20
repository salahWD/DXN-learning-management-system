<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["questions"]) && !empty($_POST["questions"]) && is_array($_POST["questions"])) {

      /* Proces Answers */
      $exam = new ExamProces();
      $exam->id = intval($_SESSION["exam"]["exam_info"]["exam_id"]);
      $exam->min_mark = $exam->get_min_mark();
      $exam->get_compare_table();

      $exam->compare_answers($_POST["questions"]);

      
      $full_mark = $exam->some_markes();

      $_SESSION["exam"]["exam_result"]["exam_full_mark"]    = $full_mark;
      $_SESSION["exam"]["exam_result"]["questions_marks"]   = $exam->compare_table;
      $_SESSION["exam"]["exam_result"]["exam_min_mark"]     = intval($exam->min_mark);


      if ($user::USER_TYPE == 3) {
        $exam->add_recorde();// save answers and date of exam take
        if ($full_mark >= $exam->min_mark) {
          $exam = new Exam();
          $exam->id = intval($_SESSION["exam"]["exam_info"]["exam_id"]);
          $exam->course_id = intval($_SESSION["course_id"]);
          $exam->item_pass($user->student_id);
        }
      }
      
      header("Location: " . theURL . language . "/exam-result");
      exit();
    }else {
      header("Location: " . theURL . language . "/exam-result");
      exit();
    }
}else {
  header("Location: " . theURL . language . "/dashboard-" . strtolower(get_class($user)));
  exit();
}