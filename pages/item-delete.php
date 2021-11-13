<?php

  $id = intval($URL[2]);
  $type = intval($URL[3]);

  if ($type == 2) {
    $exam = new Exam();
    $exam->id = $id;
    $exam->delete_exam();
    exit();
  }else if ($type == 1) {
    $lecture = new Lecture();
    $lecture->id = $id;
    $lecture->delete_lecture();
  }else {
    header("Location: " . theURL . language . "/manage-course");
    exit();
  }
  header("Location: " . theURL . language . "/manage-course");
  exit();