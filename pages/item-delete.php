<?php

  $id = $URL[2];
  $type = $URL[3];

  if ($user::USER_TYPE == 2) {
    $item = new Item();
    $item->set_data(["id" => $id, "type" => $type]);
    $course_id = $item->get_course_id();
    $course = new Course();
    $course->id = $course_id;
    $course->get_teacher_permission($user->teacher_id);
    $access = $course->check_permission("DELETE");
  }else {
    $access = true;
  }

  if ($access) {
    if ($type == 2) {
      $exam = new Exam();
      $exam->id = $id;
      $exam->delete_exam();
    }else if ($type == 1) {
      $lecture = new Lecture();
      $lecture->id = $id;
      $lecture->delete_lecture();
    }
  }
  header("Location: " . theURL . language . "/manage-course");
  exit();