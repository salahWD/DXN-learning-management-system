<?php

if ($user::USER_TYPE == 3):
  // get course info from session
  $course = $user->get_course_from_session(intval($URL[2]));
else:
  // get course info
  $course = new Course();
  $course->id = intval($URL[2]);
  $course->set_data($course->get_course());
  $course->show_status = 2;
  
endif;

if (is_object($course) && !empty($course)):
  if ($course->show_status == 2 || $course->show_status == 3):

    // get items info
    if ($user::USER_TYPE == 3) {
      $course->items = $course->get_items_for_students($user->student_id);
    }elseif ($user::USER_TYPE < 3) {
      $course->items = $course->get_items_for_manage();
    }
    ?>

    <div class="container">
      <div class="col text-center mb-5 mt-3">
        <h1 class="d-inline under-line-title ">
          <?php echo $course->title?>
        </h1>
      </div>
      <div class="row">
        <?php
        if (!empty($course->items) && count($course->items) > 0):
          
          foreach($course->items as $item):?>

            <div class="col-md-3 col-sm-6">
              <div class="card <?php
                if ($item->show_status == 1) {
                    echo "close";
                }elseif ($item->show_status == 2) {
                  echo "border border-primary";
                }elseif ($item->show_status == 3) {
                  echo "border border-success";
                }?> item">
                <div class="card-header">
                  <?php echo $item->title;?>
                </div>
                <?php if ($item->show_status == 1):?>
                  <img src="<?php echo ($item::TYPE == 1) ? theURL . imagesURL . $item->thumbnail : theURL . imageURL . "exam-default.jpg";?>"
                    alt="lecture thumbnail"
                    class="card-img-top">
                <?php else:?>
                  <a href="<?php echo theURL . language . "/view/" . $course->id . "/" . $item->order?>">
                    <img src="<?php echo ($item::TYPE == 1) ? theURL . imagesURL . $item->thumbnail : theURL . imageURL . "exam-default.jpg";?>"
                        alt="lecture thumbnail"
                        class="card-img-top">
                  </a>
                <?php endif;?>
                <div class="card-body">
                  <?php echo $item->description;?>
                </div>
                <div class="card-footer p-1 text-muted" style="padding-right: 1rem!important;">
                  <?php if($item->day_before > 0 && $item->day_before < 30):?>
                    Added :<?php echo $item->day_before . "d";?>
                  <?php elseif($item->day_before == 0):?>
                    Added : Today
                  <?php else:?>
                    Added : <?php echo $item->date;?>
                  <?php endif;?>
                </div>
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

  <?php else:?>
      <div class="container">
        <div class="alert alert-danger text-center mt-4">
          <h3>لا تملك الصلاحة للدخول</h3>
          <p>يبدو انك لا تملك صلاحية الوصول الى هذه الدورة</p>
        </div>
      </div>
  <?php endif;?>
<?php else:?>
  <div class="container">
    <div class="alert alert-danger text-center mt-4">
      <h3>هذه الدورة غير موجودة</h3>
      <p>قد يكون قد تم حذف هذه الدورة او حجبها</p>
    </div>
  </div>
<?php endif;?>