<?php
  $course = new Course();
  $course->id = intval($URL[2]);
  
  if ($user::USER_TYPE == 1) {
    $course->delete_course();
    header("Location: " . theURL . language . "/manage-course");
    exit();
  }else {
    $course->permission = $course->get_teacher_permission($user->teacher_id);
    if ($course->check_permission("DELETE")) {
      $course->delete_course();
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
  }

?>