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
      <div class="list table-hover" id="members-table">
        <div class="sub-title table-row">
          <div class="cell id">#</div>
          <div class="cell name">اسم الطالب</div>
          <div class="cell percent">التقدم</div>
          <div class="cell control">الخيارات</div>
        </div>
        <?php if (count($group->members) > 0):?>
          <div id="user-error" class="error-area sub-title text-center alert alert-danger border-0 mt-2">
            لا يوجد اعضاء في هذه المجموعة
          </div>
          <?php foreach($group->members as $i => $member):?>
            <div class="table-row">
              <div data-id="<?php echo $member->student_id;?>" class="cell id"><?php echo $i + 1;?></div>
              <div class="cell name"><?php echo $member->fullname;?></div>
              <div class="cell percent"><?php echo rand(30, 100);?>%</div>
              <div class="cell control">
                <button class="btn btn-danger delete-btn"><i class="fas fa-trash"></i></button>
              </div>
            </div>
          <?php endforeach;?>
        <?php else:?>
          <div id="user-error" class="error-area sub-title text-center alert alert-danger border-0 mt-2 show">
            لا يوجد اعضاء في هذه المجموعة
          </div>
        <?php endif;?>
        <button id="add-member" class="btn btn-primary mt-3 add-item-btn">
          <i class="fa fa-plus" aria-hidden="true"></i> 
          <span data-error="لا يوجد اعضاء قابلين للأضافة">
          اضافة عضو للمجموعة
          </span>
        </button>
      </div>
    </div>
    <div class="col-md-4">
      <div class="list path_details" id="path-courses-list">
          <h3 class="sub-title">خطة التعلم</h3>
          <?php if (count($group->path) > 0):?>
            <div id="path-error" class="error-area sub-title text-center alert alert-danger border-0 mt-2 error">
              لا يوجد دورات في الخطة المختارة
            </div>
            <?php foreach($group->path as $i => $course):?>
              <div id="a<?php echo $i;?>" data-order="<?php echo $i+1;?>" class="drop-container">
                <div id="b<?php echo $i;?>" data-id="<?php echo $course->id;?>" class="level-point" draggable="true">
                  <div class="control-list">
                    <button data-url="<?php echo theURL . language . "/path-course-manage/" . $course->id;?>" class="delete-course-button btn btn-danger edit"><i class="fas fa-trash"></i></button>
                  </div>
                  <a href="<?php echo theURL . language . "/manage-course/" . $course->id;?>" class="circle"><span><?php echo $i + 1;?></span></a>
                  <div class="info">
                    <a href="<?php echo theURL . language . "/manage-course/" . $course->id;?>" class="text-decoration-none lead"><p class="title"><?php echo $course->title;?></p></a>
                    <p class="desc"><?php echo substr($course->description, 0, 40);?></p>
                  </div>
                </div>
              </div>
            <?php endforeach;?>
          <?php else:?>
            <div id="path-error" class="error-area sub-title text-center alert alert-danger border-0 mt-2 show">
              لا يوجد دورات في الخطة المختارة
            </div>
          <?php endif;?>
          <button id="add-course-to-path-button" class="btn btn-primary mt-2 add-item-btn">
            <i class="fa fa-plus" aria-hidden="true"></i> 
            <span data-error="لا يوجد دورات قابلة للأضافة">
            اضافة دورة للخطة
            </span>
          </button>
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