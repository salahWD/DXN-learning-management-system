<div class="container">
  <div class="col-md-8 offset-2 mt-md-5">
    <form action="<?php echo theURL . language . '/groups-add-prc';?>" method="POST">
      
      <!-- Name input -->
      <div class="form-outline mb-4">
        <div class="form-outline">
          <label class="form-label" for="name">اسم المجموعة</label>
          <input type="text" id="name" name="title" placeholder="اسم المجموعة" class="form-control"
          <?php echo isset($_POST['name']) ? 'value="' . $_POST["name"] . '"': '';?>/>
        </div>
      </div>
    
      <!-- Description textarea -->
      <div class="form-outline mb-4">
        <label class="form-label" for="desc">الوصف</label>
        <textarea id="desc" placeholder="وصف المجموعة" name="desc" class="form-control"><?php echo isset($_POST['desc']) ? $_POST["desc"]: '';?></textarea>
      </div>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary w-100">Create</button>
      
    </form>
  </div>
</div>