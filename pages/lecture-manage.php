<?php
  
  if ($_SERVER["REQUEST_METHOD"] == "POST"):
    $lecture = new Lecture();
    $lecture->set_data($_POST);
    echo "<pre>";
    print_r($lecture);
    echo "</pre>";
  endif;

  $lecture    = new Lecture();
  $lecture->id = $URL[2];
  $lecture->set_data($lecture->get_lecture());

  $course = new Course();
  $course->id = $lecture->course_id;

  if ($user::USER_TYPE == 2):
    $course->permission = $course->get_teacher_permission($user->teacher_id);
    if (!$course->check_permission("UPDATE")):?>
      <div class="container">
        <div class="row">
          <div class="alert alert-danger text-center mt-4">
            <h3 class="alert-title">No Access !!</h3>
            <p class="lead">You Have No Access To This course</p>
          </div>
        </div>
      </div> 
      <?php
      exit();
    endif;
  endif;
    
  $course->items = $course->get_items_id_name();
?>

<div class="container item-manage">
  <div class="row">
    <div class="grid-2 p-2 mt-4">
      <div class="image-container">
        <img class="img-fluid w-100" src="<?php echo theURL . thumbnailsURL . $lecture->thumbnail;?>">
        <button name="thumbnail" id="thumbnail-btn" class="btn btn-success image-edit-btn">
          <i class="fa fa-fw fa-edit"></i>
        </button>
      </div>
      <form action="" method="POST">
        <div class="lecture-info" dir="rtl">
          <input name="thumbnail" type="file" id="thumbnail-input" class="d-none">
          <input name="title" type="text" placeholder="العنوان" class="form-control mb-2" value="<?php echo $lecture->title;?>">
          <textarea name="description" placeholder="الوصف" class="form-control" style="min-height:150px;max-height:300px;"><?php echo $lecture->description;?></textarea>
          <input class="btn btn-success w-100 mt-2" type="submit" value="تعديل">
          <div class="order-container">
            <ul class="list-unstyled mt-4">
              <?php if (!empty($course->items) && count($course->items) > 0):?>
                <?php foreach ($course->items as $i => $item):?>
                  <li draggable="true" class="btn <?php echo ($item->id == $lecture->id && $item::TYPE == $lecture::TYPE) ? "btn-success" : "btn-primary";?> rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $item->title;?>">
                    <?php echo ++$i;?>
                  </li>
                <?php endforeach;?>
              <?php endif;?>
            </ul>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>