<?php
  unset($user->main_courses);// remove main courses
  unset($_SESSION["course_id"]);// remove last course he wes in
  $user->main_courses = $user->get_courses_path($user->student_id);// get main courses
  $stop_showing_courses = false;// it mean this course is the first closed course and it will open it then change itself to be true
?>
<div class="container">
  <div class="row">
    <div class="col-md-12 mt-3 mb-5 text-center">
      <h2 class="under-line-title d-inline">لوحة التحكم</h2>
    </div>
    <div class="col-md-8">
      <div class="d-flex flex-column">
        <?php foreach ($user->main_courses as $course):?>

            <?php if ($course->show_status == 3):?>
              <div class="card course mb-3">
                <div class="card-body pb-2 pt-2">
                  <div class="header">
                    <strong class="text-muted">دورة</strong>
                    <i class="fas fa-ellipsis-v fa-fw text-black-50"></i>
                  </div>
                </div>
                <div class="note bg-success text-light">
                  <small>تم اجتياز هذه الدورة بالفعل</small>
                </div>
                <div class="card-body pt-0">
                  <div class="d-flex course-content justify-content-between align-items-center">
                    <div>
                      <h4 class="card-title mb-1">
                        <a href="<?php echo theURL . language . "/course/" . $course->id?>" class="link text-success">
                          <?php echo $course->title;?>
                        </a>
                      </h4>
                      <small class="rounded-pill badge border border-success p-2 text-muted">تم الأجتياز</small>
                    </div>
                    <div>
                      <a href="<?php echo theURL . language . "/course/" . $course->id?>" class="btn btn-success">الدورة منتهية</a>
                    </div>
                  </div>
                  <hr>
                  <small class="card-subtitle text-muted"><?php echo $course->date?></small>
                </div>
              </div>
            <?php elseif ($course->show_status == 2):?>
              <div class="card current course mb-3">
                <div class="card-body pb-2 pt-2">
                  <div class="header">
                    <strong class="text-muted">دورة</strong>
                    <i class="fas fa-ellipsis-v fa-fw text-black-50"></i>
                  </div>
                </div>
                <div class="note">
                  <small>يجب عليك انهاء هذه الدورة قبل البداية بغيرها</small>
                </div>
                <div class="card-body pt-0">
                  <div class="d-flex course-content justify-content-between align-items-center">
                    <div>
                      <h4 class="card-title mb-1">
                        <a href="<?php echo theURL . language . "/course/" . $course->id?>" class="link">
                          <?php echo $course->title;?>
                        </a>
                      </h4>
                      <small class="rounded-pill badge border border-primary p-2 text-muted">في تقدم</small>
                    </div>
                    <div>
                      <a href="<?php echo theURL . language . "/course/" . $course->id?>" class="btn btn-primary">أكمل الدورة</a>
                    </div>
                  </div>
                  <hr>
                  <small class="card-subtitle text-muted"><?php echo $course->date?></small>
                </div>
              </div>
            <?php elseif ($course->show_status == 1):?>
              <div class="card close course mb-3">
                <div class="card-body pb-2 pt-2">
                  <div class="header">
                    <strong class="text-muted">دورة</strong>
                    <i class="fas fa-ellipsis-v fa-fw text-black-50"></i>
                  </div>
                </div>
                <div class="note">
                  <small>يجب عليك انهاء الدورات السابقة لفتح هذه الدورة</small>
                </div>
                <div class="card-body pt-0">
                  <div class="d-flex course-content justify-content-between align-items-center">
                    <div>
                      <h4 class="card-title mb-1">
                        <?php echo $course->title;?>
                      </h4>
                      <small class="rounded-pill badge border border-dark p-2 text-muted">مقفل</small>
                    </div>
                    <div>
                      <buttin type="button" class="btn btn-secondary">مقفل</buttin>
                    </div>
                  </div>
                  <hr>
                  <small class="card-subtitle text-muted"><?php echo $course->date?></small>
                </div>
              </div>  
            <?php endif;?>
            
        <?php endforeach;?>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-side-bar">
        <ul class="list-unstyled bg-secondary rounded p-2 text-light text-center">
          <h2>Badget name</h2>
          <hr>
          <li class="item mb-2">lecture name</li>
          <li class="item mb-2">lecture name</li>
          <li class="item mb-2">lecture name</li>
          <li class="item mb-2">lecture name</li>
          <li class="item mb-2">lecture name</li>
          <li class="item">lecture name</li>
        </ul>
      </div>
    </div>
  </div>
</div>