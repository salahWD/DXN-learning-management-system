<?php

  $id = $URL[2];
  $type = $URL[3];

  if ($user::USER_TYPE == 2) {
    $item = new Item();
    $course_id = $item->get_course_id($id, $type);
    $course = new Course();
    $course->id = $course_id;
    $course->permission = $course->get_teacher_permission($user->teacher_id);
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
    header("Location: " . theURL . language . "/manage-course");
    exit(); 
  }else {?>
    <div class="container">
      <div class="alert alert-danger mt-4 text-center">
        <h3 class="title">لا تملك صلاحيات الحذف</h3>
        <p class="title">عذرا يبدو انك لا تملك الصلاحية لحذف هذه الدورة يرجى مراجعة المدرب المسؤول عن هذه الدورة</p>
      </div>  
    </div>
  <?php
  }