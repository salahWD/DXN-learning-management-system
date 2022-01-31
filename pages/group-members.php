<?php

  $group_id = $URL[2];
  $group = new Group();
  $group->id = $group_id;
  
  $pass = false;

  # Authuntication And Check If This Group Belong To This Teacher
  if ($user::USER_TYPE == 2):
    $groups = array_column($group::get_id_by_teacher($user->teacher_id), "id");
    if (in_array($group_id, $groups)):
      $pass = true;
    endif;
  else:
    $pass = true;
  endif;

  if ($pass):

    $group->members = Student::student_obj($group::get_members($group_id));
    $group->path    = Course::course_obj($group::get_path_courses($group_id));
  
?>
<div class="container">
  <div class="text-center mt-4 mb-4 pb-4">
    <h2 class="d-inline under-line-title">اعضاء المجموعة</h2>
  </div>
  <div class="mt-md-3 row">
    <div class="col-md-8">
      <div class="list table table-hover" id="members-table">
        <div class="sub-title table-row">
          <div class="cell">#</div>
          <div class="cell">اسم الطالب</div>
          <div class="cell">التقدم</div>
        </div>
        <?php if (count($group->members) > 0):?>
          <?php foreach($group->members as $member):?>
            <div class="table-row">
              <div class="cell"><?php echo $member->student_id;?></div>
              <div class="cell"><?php echo $member->fullname;?></div>
              <div class="cell"><?php echo rand(30, 100);?>%</div>
            </div>
          <?php endforeach;?>
        <?php else:?>
          <div class="sub-title text-center alert alert-danger border-0 mt-2">
            لا يوجد اعضاء في هذه المجموعة
          </div>
        <?php endif;?>
        <?php // echo theURL . language . "/group-add-member/" . $group->id;?>
        <button id="add-member" class="btn btn-primary mt-3"><i class="fa fa-plus" aria-hidden="true"></i> اضافة عضو للمجموعة</button>
      </div>
    </div>
    <div class="col-md-4">
      <div class="list path_details">
          <h3 class="sub-title">خطة التعلم</h3>
          <?php if (count($group->path) > 0):?>
            <?php foreach($group->path as $i => $course):?>
              <div class="level-point">
                <a href="<?php echo theURL . language . "/manage-course/" . $course->id;?>" class="circle"><span><?php echo $i + 1;?></span></a>
                <a href="<?php echo theURL . language . "/manage-course/" . $course->id;?>" class="text-decoration-none lead"><p class="title"><?php echo $course->title;?></p></a>
                <p class="desc"><?php echo substr($course->description, 0, 40);?></p>
              </div>
            <?php endforeach;?>
          <?php else:?>
            <div class="sub-title text-center alert alert-danger border-0 mt-2">
              لا يوجد دورات في الخطة المختارة
            </div>
          <?php endif;?>
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