<?php

  if ($user::USER_TYPE == 1) {
    $groups = Group::get_all();
  }else {
    $groups = Group::get_all_by_teacher($user->teacher_id);
  }

if (count($groups) > 0):?>

    <div class="container">
      <div class="text-center mt-4 mb-4 pb-4">
        <h2 class="d-inline under-line-title">ادارة المجموعات</h2>
        <a style="float: right" href="<?php echo theURL . language . "/groups-add";?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>
      </div>
      <div class="row mt-5 pt-3">
        <?php foreach($groups as $group_data):
            $group = new Group();
            $group->set_data($group_data);
          ?>
          <div class="col-md-4">
            <div class="group-container">
              <h5 class="group-title"><?php echo $group->name;?></h5>
              <div class="card group">
                <div class="card-body">
                  <p class="card-text"><?php echo $group->description;?></p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">عدد الطلاب: <span><?php echo rand(1, 10);?></span></li>
                </ul>
              </div>
            </div>
          </div>
        <?php endforeach;?>
      </div>
    </div>

<?php else:?>
  
  <div class="container">
    <div class="alert alert-danger text-center mt-4">
      <h3>لا يوجد عناصر</h3>
      <p class="lead">يبدو انه لا يوجد اي مجموعات قد تم انشائها</p>
    </div>
  </div>
  
<?php endif;?>
