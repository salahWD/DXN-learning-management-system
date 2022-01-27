<?php

    $teacher = $_SESSION["user"];

?>
<div class="container">
	<div class="text-center mt-4 mb-4">
		<h2 class="d-inline under-line-title">لوحة التحكم</h2>
	</div>
<div class="row">
	<div class="col-md-4">
			<div class="card text-center">
					<div class="card-body">
							<h3 class="card-title">اضافة دورة</h3>
							<hr>
							<a href="<?php echo theURL . language . "/course-add";?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
					</div>
			</div>
	</div>
	<div class="col-md-4">
		<div class="card text-center">
			<div class="card-body">
				<h3 class="card-title">ادارة الدورات</h3>
				<hr>
				<a href="<?php echo theURL . language . "/manage-course";?>" class="btn btn-primary"><i class="fa fa-tasks"></i></a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card text-center">
			<div class="card-body">
				<h3 class="card-title">اضافة مادة</h3>
				<hr>
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItem">
					<i class="fa fa-plus"></i>
				</button>
				<div class="modal fade" id="addItem" tabindex="-1" aria-labelledby="addItem" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">

							<div class="modal-header">
								<h4 class="modal-title">نوع المادة</h4>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body item-type-container">
								<div class="row">
									<div class="col">
										<div class="card item-type" data-page="lecture-add">
											<div class="card-body">
												<h5 class="card-title">حلقة</h5>
												<p class="card-text">مقطع فيديو يشرح موضوع معين ضمن الدورة</p>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="card item-type" data-page="exam-add">
											<div class="card-body">
												<h5 class="card-title">اختبار</h5>
												<p class="card-text">مجموعة من الاسئلة و الخيارات لأختبار مستوى الطالب</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
								<a href="" class="btn btn-primary" id="sendBtn">حفظ</a>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card text-center">
			<div class="card-body">
				<h3 class="card-title">ادارة المجموعات</h3>
				<hr>
				<a href="<?php echo theURL . language . "/manage-groups";?>" class="btn btn-primary"><i class="fa fa-tasks"></i></a>
			</div>
		</div>
	</div>
</div>