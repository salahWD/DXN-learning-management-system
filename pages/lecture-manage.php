<?php
  
  $lctr_order = $URL[3];
  $lecture    = new Lecture();
  $course     = new Course();
  $course->id = $URL[2];
  
  if ($user::USER_TYPE == 1) {
    $lecture->set_data($lecture->get_lecture($course->id, $lctr_order));
    $course->set_data(["items" => $course->get_items_id_name()]);
  }else {

    if ($course->get_teacher_permission($user->id)):
      
      $perm = str_split($course->permission);

      if ($perm[1] == 1):// update permission

        $lecture->set_data(
          $lecture->get_lecture($course->id, $lctr_order)
        );
    
        $course->id = $lecture->course_id;
    
        $course->set_data([
          "items" => $course->get_items_id_name()
        ]);
        
      else:?>
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="alert alert-danger">
                <div class="alert-title">No Access !!</div>
                <p class="lead">You Have No Access To This course</p>
              </div>
            </div>
          </div>
        </div> 
      <?php endif;?>
    <?php else:?>
     <div class="container">
       <div class="row">
         <div class="col">
           <div class="alert alert-danger">
             <div class="alert-title">No Access !!</div>
             <p class="lead">You Have No Access To This course</p>
           </div>
         </div>
       </div>
     </div> 
    <?php endif;
  }
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