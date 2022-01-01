<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["questions"]) && !empty($_POST["questions"]) && is_array($_POST["questions"])) {
      
      $exam = new ExamProces();
      $exam->id = intval($_SESSION["exam_result"]["exam_id"]);
      $exam->min_mark = $exam->get_min_mark();
      $exam->get_compare_table();

      $exam->coompare_answers($_POST["questions"]);
      
      $_SESSION["exam_result"]["exam_full_mark"]    = $exam->some_markes();
      $_SESSION["exam_result"]["questions_marks"]   = $exam->compare_table;
      $_SESSION["exam_result"]["exam_min_mark"]     = intval($exam->min_mark);
      
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