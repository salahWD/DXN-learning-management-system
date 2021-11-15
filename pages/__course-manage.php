<?php


if (isset($URL[2]) && !empty($URL[2]) && is_numeric($URL[2])) {
  
  // Create Object
  $course_id = intval($URL[2]);
  $course = new Course();
  $course->id = $course_id;
  $_SESSION["course_manage_id"] = $course_id;// come check in create item page make sure that there is a $SESSION course_manage_id
  
  // Get Items
  if ($course->get_teacher_permission($user->id)):
    $course->set_data($course->get_course());
    $course->items = $course->get_items_all();?>

    <div class="container">
      <div class="col text-center mt-2 mb-4">
        <h1 class="under-line-title d-inline"><?php echo $course->title;?></h1>
        
        <button type="button" id="add-item-btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#item-model">
          <i class="fa fa-fw fa-plus"></i>
        </button>
        <div dir="rtl" class="modal fade" id="item-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">نوع المادة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col text-center">
                    <div class="rounded border border-primary pt-2 item-type" data-page="lecture-add">
                      <h3 class="under-line-title p-1 d-inline">
                        محاضرة
                      </h3>
                      <p class="mt-4">اضافة مقطع فيديو تعليمي داخل الدورة الحالية</p>
                    </div>
                  </div>
                  <div class="col text-center">
                    <div class="rounded border pt-2 item-type" data-page="exam-add">
                      <h3 class="under-line-title p-1 d-inline">
                        اختبار
                      </h3>
                      <p class="mt-4">اضافة اختبار مكون من أسئلة واجابات داخل الدورة الحالية</p>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-center">
                  <a class="btn btn-success" id="sendBtn">Send</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if (isset($course->items) && !empty($course->items) &&  count($course->items) > 0) {?>

        <div class="row">
          <?php foreach ($course->items as $i => $item):?>

            <div class="card col-sm-4 col-md-3">
              <div class="card-body">
                <a
                  <?php if ($item::TYPE == 2):?>
                    href="<?php echo theURL . language . "/exam-manage/" . $course_id . "/" . $item->order . "/1";?>">
                  <?php else:?>
                    href="<?php echo theURL . language . "/lecture-manage/" . $course_id . "/" . $item->order;?>">
                  <?php endif;?>
                  <h2>
                    <?php echo $item->title;?>
                  </h2>
                </a>
                  <?php
                    if ($item::TYPE == 2) {
                      echo '<span class="badge badge-pill bg-danger">exam</span>';
                    }else {
                      echo '<span class="badge badge-pill bg-success">lecture</span>';
                    }
                  ?>
                <div class="delete link">
                  <i class="fa fa-fw fa-trash text-danger"></i>
                  <a class="text-danger text-decoration-none" href="<?php echo theURL . language . "/item-delete/" . $item->id . "/" . $item::TYPE;?>">Delete</a>
                </div>
                <div class="edit link">
                  <i class="fa fa-fw fa-edit text-success"></i>
                  <?php if ($item::TYPE == 2):?>
                    <a class="text-success text-decoration-none" href="<?php echo theURL . language . "/exam-manage/" . $course->id . "/" . $item->order;?>">Edit</a>
                  <?php else:?>
                    <a class="text-success text-decoration-none" href="<?php echo theURL . language . "/lecture-manage/" . $course->id . "/" . $item->order;?>">Edit</a>
                  <?php endif;?>
                </div>
              </div>
            </div>
          
          <?php endforeach;?>
        </div>
        <?php
      }else if ($course->items == 2) {
        echo "<h1>there is no items</h1>";
        exit();
      }else if ($course->items == 3) {
        echo "<h1>there is no Access</h1>";
        exit();
      }else {
        echo "<h1>items Array is empty</h1>";
        exit();
      }// end of rowCount check
      ?>
    </div>

  <?php else:?>
    <div class="container">
      <div class="alert alert-danger text-center mt-4">
        <h3>Not Allowed</h3>
        <p class="lead">This Course Is Not Avalible Or You Have No Permission To Manage It</p>
      </div>
    </div>
  <?php endif;
}else {// if there is no course_id

  // Get Items
  $user->courses = $user->get_own_courses();

  if (count($user->courses) > 0) {?>

    <div class="container">
      <div class="row">
        <?php foreach ($courses as $course):?>
        
          <div class="card col-sm-6 col-md-4">
            <div class="card-body">
              <h2><?php echo $course->title;?></h2>
            </div>
          </div>

        <?php endforeach;?>
      </div>
    </div>

    <?php
  }else {
    echo "<h1>ther is no acces</h1>";
    exit();
  }// end of rowCount check


}// end of "if ther is course id" check