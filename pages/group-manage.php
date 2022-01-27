<?php

$group_id = intval($URL[2]);

$group = new Group();
$group->set_data($group->get_group($group_id));

if ($user::USER_TYPE == 2) {
  $paths = $user->get_paths();
}

?>

<div class="container">
  <div class="text-center mt-4 mb-4 pb-4">
    <h2 class="d-inline under-line-title">تعديل المجموعة</h2>
  </div>
  <div class="row">
    <div class="col-md-8 offset-2 mt-md-5">
      <form action="<?php echo theURL . language . '/group-edit-prc/' . $group_id;?>" method="POST">
        
        <!-- Name input -->
        <div class="form-outline mb-4">
          <div class="form-outline">
            <label class="form-label" for="name">اسم المجموعة</label>
            <input value="<?php echo $group->name;?>" type="text" id="name" name="name" placeholder="اسم المجموعة" class="form-control">
          </div>
        </div>
  
        <!-- Description textarea -->
        <div class="form-outline mb-4">
          <label class="form-label" for="desc">الوصف</label>
          <textarea id="desc" placeholder="وصف المجموعة" name="desc" class="form-control"><?php echo $group->description;?></textarea>
        </div>
  
        <?php if(isset($paths) && is_array($paths) && count($paths) > 0):?>
        <div class="form-outline mb-4">
          <label class="form-label" for="path">الخطة التدريبية</label>
          <select class="form-control" name="path" id="path">
            <?php foreach($paths as $path):?>
              <?php if ($path["id"] == $group->path_id):?>
                <option selected value="<?php echo $path["id"];?>"><?php echo $path["name"];?></option>
              <?php else:?>
                <option value="<?php echo $path["id"];?>"><?php echo $path["name"];?></option>
              <?php endif;?>
            <?php endforeach;?>
          </select>
        </div>
        <?php endif;?>
  
        <!-- Submit button -->
        <button type="submit" class="btn btn-primary w-100">Create</button>
        
      </form>
    </div>
  </div>
</div>