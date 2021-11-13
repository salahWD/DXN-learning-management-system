<?php

  if ($user::USER_TYPE == 1) {
    $groups = Group::get_all();
  }else {
    $groups = Group::get_all_by_teacher($user->teacher_id);
  }

?>

<div class="container">
	<div class="text-center mt-4 mb-4">
		<h2 class="d-inline under-line-title">ادارة المجموعات</h2>
  </div>
  <div class="row">
    <?php foreach($groups as $group):?>
      <div class="col-md-4">
        <div class="card">
          <img src="http://placehold.it/450x450/<?php echo floor(rand(0, 9)) . floor(rand(0, 9)) . floor(rand(0, 9));?>" class="card-img-top" alt="image">
          <div class="card-body">
            <h5 class="card-title">المبيعات</h5>
            <p class="card-text">هذة المجموعة خاصة لطلاب المبيعات ولا تشمل التسويق عامة</p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">An item</li>
            <li class="list-group-item">A second item</li>
            <li class="list-group-item">A third item</li>
          </ul>
        </div>
      </div>
    <?php endforeach;?>
  </div>
</div>