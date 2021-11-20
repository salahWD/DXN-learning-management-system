<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["exam_id"]) && !empty($_POST["exam_id"]) && is_numeric($_POST["exam_id"])) {

    if (isset($_POST["questions"]) && !empty($_POST["questions"]) && is_array($_POST["questions"])) {

      $exam = new ExamProces();
      $exam->id = intval($_POST["exam_id"]);
      $exam->get_compare_table();
      $exam->coompare_answers($_POST["questions"]);

      echo json_encode($exam->some_markes());
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