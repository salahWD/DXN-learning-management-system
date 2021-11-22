<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["exam_id"]) && !empty($_POST["exam_id"]) && is_numeric($_POST["exam_id"])) {

    if (isset($_POST["questions"]) && !empty($_POST["questions"]) && is_array($_POST["questions"])) {

      $exam = new ExamProces();
      $exam->id = intval($_POST["exam_id"]);
      $exam->min_mark = $exam->get_min_mark();
      $exam->get_compare_table();
      $exam->coompare_answers($_POST["questions"]);

      $markes = $exam->some_markes();
      echo json_encode([
        "exam_full_mark" => $markes[0],
        "questions_mark" => $markes[1],
        "min_mark" => intval($exam->min_mark)
      ]);
    }else {
      echo json_encode(false);
    }
  }else {
    echo json_encode(false);
  }
}else {
  header("Location: " . theURL . language . "/login");
  exit();
}