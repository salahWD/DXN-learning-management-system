<?php

$members = $user->get_students();
$members = Student::student_obj($members);

?>
<div class="container">
  <div class="text-center mt-4 mb-4">
		<h2 class="d-inline under-line-title">ادارة الأعضاء</h2>
	</div>
  <div class="manage row mt-5">
    <div class="col-md-6">
      <div class="table table-hover d-table">
        <div class="d-table-row table-row-head">
          <div class="d-table-cell table-cell" scope="col">id</div>
          <div class="d-table-cell table-cell" scope="col">username</div>
          <div class="d-table-cell table-cell" scope="col">group</div>
        </div>
        <?php foreach ($members as $member):?>
          <div class="d-table-row table-row">
            <div class="d-table-cell table-cell"><a href="<?php echo theURL . language . "/user/" . $member->id;?>"><?php echo $member->id;?></a></div>
            <div class="d-table-cell table-cell"><a href="<?php echo theURL . language . "/user/" . $member->id;?>"><?php echo $member->username;?></a></div>
            <div class="d-table-cell table-cell">
              <?php echo !empty($member->group) ? "<a href=\"" . theURL . language . "/group-members/" . $member->group_id . "\">" . $member->group . "</a>" : "--";?>
            </div>
          </div>
        <?php endforeach;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="member-view">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-9 col-sm-8">
                <h3 class="title mt-3 pr-3"><?php echo $members[0]->username;?></h3>
              </div>
              <div class="col-md-3 col-sm-4 text-center">
                <img class="rounded-circle img-thumbnail img-fluid" src="https://via.placeholder.com/80/777/fff">
              </div>
            </div>
            <?php $last_course = $members[0]->get_current_course()?>
            <p class="lead"> الدورة الحالية: <a href="<?php echo theURL . language . "/manage-course/" . $last_course->id;?>"><?php echo $last_course->title;?></a></p>
            <p class="lead">المدرب المسئول: <?php echo $members[0]->dxn_upline;?></p>
          </div>
          <pre>
            <?php print_r($members[0]->get_current_course());?>
          </pre>
        </div>
      </div>
    </div>
  </div>
</div>