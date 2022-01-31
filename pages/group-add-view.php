<?php

  if ($user::USER_TYPE == 2) {
    $paths = $user->get_paths();
  }

  $icons = Group::get_icons();

?>

<div class="container">
  <div class="text-center mt-4 mb-4 pb-4">
    <h2 class="d-inline under-line-title">اضافة مجموعة</h2>
  </div>
  <div class="col-md-8 offset-2 mt-md-5">
    <form action="<?php echo theURL . language . '/group-add-prc';?>" method="POST">
      
      <!-- Name input -->
      <div class="form-outline mb-4">
        <div class="form-outline">
          <label class="form-label" for="name">اسم المجموعة</label>
          <input type="text" id="name" name="name" placeholder="اسم المجموعة" class="form-control"
          <?php echo isset($_POST['name']) ? 'value="' . $_POST["name"] . '"': '';?>/>
        </div>
      </div>

      <!-- Description textarea -->
      <div class="form-outline mb-4">
        <label class="form-label" for="desc">الوصف</label>
        <textarea id="desc" placeholder="وصف المجموعة" name="desc" class="form-control"><?php echo isset($_POST['desc']) ? $_POST["desc"]: '';?></textarea>
      </div>

      <div class="form-outline mb-4">
        <label class="form-label" for="path">الخطة التدريبية</label>
        <select class="form-control" name="path" id="path">
          <?php if (is_array($paths) && count($paths) > 0):?>
            <?php foreach($paths as $path):?>
              <option value="<?php echo $path["id"];?>"><?php echo $path["name"];?></option>
            <?php endforeach;?>
          <?php endif;?>
        </select>
      </div>

      <div class="form-outline mb-4">
        <label class="form-label">اختر ايقونة</label>
        <input type="hidden" name="icon" id="icon-id-input">
        <?php if (is_array($icons) && count($icons) > 0):?>
          <div class="d-flex flex-wrap-nowrap icon-container overflow-hidden">
            <?php foreach($icons as $icon):?>
              <div class="icon" data-id="<?php echo $icon["id"];?>">
                <img width=50 loading="lazy" src="<?php echo theURL . imageURL . "icons/" . $icon["icon"];?>" alt="icon">
              </div>
            <?php endforeach;?>
          </div>
        <?php endif;?>
      </div>
      
      <!-- Submit button -->
      <button type="submit" class="btn btn-primary w-100">Create</button>
      
    </form>
  </div>
</div>