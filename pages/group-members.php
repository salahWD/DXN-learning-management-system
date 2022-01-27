<?php

  $group_id = $URL[2];
  $group = new Group();
  $group->id = $group_id;
  $members = $group->get_members();

  $courses_data = $group->get_path_courses();
  $courses = [];
  foreach($courses_data as $course_data):
    $course = new Course();
    $course->set_data($course_data);
    array_push($courses, $course);
  endforeach;
  
  $pass = false;

  if ($user::USER_TYPE == 2):

    $groups = array_column($group->get_id_by_teacher($user->teacher_id), "id");

    if (in_array($group_id, $groups)):
      $pass = true;
    endif;
  else:
    $pass = true;
  endif;

  if ($pass):
?>

<div class="container">
  <div class="text-center mt-4 mb-4 pb-4">
    <h2 class="d-inline under-line-title">تعديل المجموعة</h2>
  </div>
  <div class="mt-md-3 row">
    <div class="col-md-8">
      <div class="list table table-hover">
        <div class="sub-title table-row">
          <div class="cell">#</div>
          <div class="cell">اسم الطالب</div>
          <div class="cell">التقدم</div>
        </div>
        <?php if (is_array($members) && count($members) > 0):?>
          <?php foreach($members as $member):?>
            <div class="table-row">
              <div class="cell"><?php echo $member["student_id"];?></div>
              <div class="cell"><?php echo $member["fullname"];?></div>
              <div class="cell"><?php echo rand(30, 100);?>%</div>
            </div>
          <?php endforeach;?>
        <?php else:?>
          <div class="sub-title text-center alert alert-danger border-0 mt-2">
            لا يوجد اعضاء في هذه المجموعة
          </div>
        <?php endif;?>
      </div>
    </div>
    <div class="col-md-4">
      <div class="list path_details">
          <h3 class="sub-title">خطة التعلم</h3>
        <?php foreach($courses as $i => $course):?>
          <div class="level-point">
            <a href="<?php echo theURL . language . "/course/";?>" class="circle"><span><?php echo $i + 1;?></span></a>
            <p class="title"><?php echo $course->title;?></p>
            <p class="desc"><?php echo $course->description;?></p>
          </div>
          <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
<?php else:?>
  <div class="container">
    <div class="sub-title text-center alert alert-danger border-0 mt-2">لا تملك الصلاحيات</div>
    <p class="lead">يبدو انك لا تملك الصلاحية لتعديل الأعضاء في هذه المجموعة</p>
  </div>
<?php endif;