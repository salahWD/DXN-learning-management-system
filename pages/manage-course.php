<?php

  if (isset($URL[2]) && !empty($URL[2]) && is_numeric($URL[2])):

    $course_id = $URL[2];
    
    if ($user::USER_TYPE == 1) {
      $course = new Course();
      $course->set_data(Course::get_course($course_id));
    }else {
      $user->accessible_courses = Teacher::get_own_courses_id_name($user->teacher_id, "ANY");
      $course = isset($user->accessible_courses[$course_id]) ? $user->accessible_courses[$course_id] : NULL;
    }
    
    if (isset($course) && !empty($course) && is_object($course)) {
      $course->items = $course->get_items_all();
    }else {?>
      <div class="container">
        <div class="alert alert-danger text-center mt-3">
          <h3 class="title">هذة الدورة غير متوفرة</h3>
          <p>عذرا لكن يبدو ان هذه الدورة غير متوفرة او لا تملك صلاحية الوصول لها</p>
        </div>
      </div>
      <?php
      exit();
    }


?>

  <div class="container">
    <div class="text-center mb-5 mt-3">
      <h1 class="d-inline under-line-title ">
        <?php echo $course->title?>
      </h1>
      <div style="float: right">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItem">
          <i class="fa fa-plus"></i>
        </button>
        
        <div class="modal fade" id="addItem" tabindex="-1" aria-labelledby="addItem" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">نوع المادة</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body item-type-container">
                <div class="row">
                  <div class="col">
                    <div class="card item-type" data-page="lecture-add/<?php echo $course->id?>">
                      <div class="card-body">
                        <h5 class="card-title">حلقة</h5>
                        <p class="card-text">مقطع فيديو يشرح موضوع معين ضمن الدورة</p>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card item-type" data-page="exam-add/<?php echo $course->id?>">
                      <div class="card-body">
                        <h5 class="card-title">اختبار</h5>
                        <p class="card-text">مجموعة من الاسئلة و الخيارات لأختبار مستوى الطالب</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                <a href="" class="btn btn-primary" id="sendBtn">حفظ</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      if (!empty($course->items) && count($course->items) > 0):
        
        foreach($course->items as $item):?>
  
          <div class="col-md-3 col-sm-6">
            <div class="card <?php
              if ($item->show_status == 0) {
                  echo "close";
              }elseif ($item->show_status == 1) {
                echo "border border-primary";
              }elseif ($item->show_status == 2) {
                echo "border border-success";
              }?> item">
              <div class="card-header">
                <?php echo $item->title;?>
              </div>
              <?php if ($item->show_status == 0):?>
                <img src="<?php echo ($item::TYPE == 1) ? theURL . thumbURL . $item->thumbnail : theURL . imageURL . "exam-default.jpg";?>"
                  alt="leecture thumbnail"
                  class="card-img-top">
              <?php else:?>
                <a href="<?php echo theURL . language . "/view/" . $course->id . "/" . $item->order?>">
                  <img src="<?php echo ($item::TYPE == 1) ? theURL . thumbURL . $item->thumbnail : theURL . imageURL . "exam-default.jpg";?>"
                      alt="leecture thumbnail"
                      class="card-img-top">
                </a>
              <?php endif;?>
              <div class="card-body">
                <?php echo $item->description;?>
              </div>
              <div class="card-footer p-1 text-muted" style="padding-left: 1rem!important;">
                <?php if($item->day_before > 0 && $item->day_before < 30):?>
                  Added :<?php echo $item->day_before . "d";?>
                <?php elseif($item->day_before == 0):?>
                  Added : Today
                <?php else:?>
                  Added : <?php echo $item->date;?>
                <?php endif;?>
              </div>
            </div>
              <div class="p-2 d-flex justify-content-around">
                <?php if ($item::TYPE == 1):?>
                  <a href="<?php echo theURL . language . "/lecture-manage/" . $item->id;?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <?php else:?>
                  <a href="<?php echo theURL . language . "/exam-manage/" . $item->id . "/add";?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <?php endif;?>
                <a href="<?php echo theURL . language . "/item-delete/" . $item->id . "/" . $item::TYPE;?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                <a href="<?php echo theURL . language . "/view/" . $course->id . "/" . $item->order;?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
              </div>
          </div>
  
        <?php endforeach;?>
  
      <?php else:?>
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <h3>Empty Course !!</h3>
            <p class="lead">This course is empty. You can wait for teachers to add lectures and exams to this course
              Or you can just contact your teacher</p>
          </div>
        </div>
        <div class="col-md-2"></div>
      <?php endif;?>
    </div>
  </div>

<?php
  else:
    unset($user->accessible_courses);
    if ($user::USER_TYPE == 1) {
      $user->accessible_courses = course::get_courses_all();
    }else {
      $user->accessible_courses = Teacher::get_own_courses_id_name($user->teacher_id, "ANY");
    }
    if (isset($user->accessible_courses) && !empty($user->accessible_courses) && count($user->accessible_courses) > 0) {?>
      <div class="container pt-4">
        <div class="text-center mt-2 mb-4 pb-3">
          <h2 class="under-line-title d-inline">ادارة الدورات</h2>
          <a style="float: right" href="<?php echo theURL . language . "/course-add";?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
          <?php foreach ($user->accessible_courses as $course):?>
            <div class="col-md-4">
              <div class="card mb-3">
                <a href="<?php echo theURL . language . "/manage-course/" . $course->id?>">
                  <div class="card-body">
                    <h3 class="title"><?php echo $course->title;?></h3>
                  </div>
                </a>
              </div> 
              <div class="p-2 d-flex justify-content-around">
                <?php if($course->check_permission("UPDATE")):?>
                  <a href="<?php echo theURL . language . "/manage-course/" . $course->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <?php endif;?>
                <?php if($course->check_permission("DELETE")):?>
                  <a href="<?php echo theURL . language . "/course-delete/" . $course->id;?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                <?php endif;?>
                <a href="<?php echo theURL . language . "/course/" . $course->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
              </div>
            </div>
          <?php endforeach;?>
        </div>
      </div>
    <?php }else {?>
      <div class="container">
        <div class="alert alert-danger mt-4 text-center">
          <h2 class="title">There's No Courses You Can Manage</h2>
          <p class="lead">You Did't Create Any Course And You There Is No Shared Courses With You</p>
        </div>
      </div>
    <?php
    }
?>

<?php
  endif;
?>
