<?php

  $id = intval($URL[2]);
  $type = intval($URL[3]);
  if ($type == 2) {
    Exam::delete_exam($id);
  }else if ($type == 1) {
    Lecture::delete_lecture($id);
  }else {
    header("Location: " . theURL . language . "/course-manage");
    exit();
  }
  header("Location: " . theURL . language . "/course-manage");
  exit();