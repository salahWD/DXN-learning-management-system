<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container">
				<a class="navbar-brand" href="#" style="font-size: 1rem;">
					<span style="font-size: 1.5rem; color: rebeccapurple;font-weight:bold;">L</span>earning
					<span style="font-size: 1.5rem; color: rebeccapurple;font-weight:bold;">N</span>etwork
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
					<ul class="navbar-nav flex-row-reverse align-items-center">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle p-0" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?php echo isset($user->username) && !empty($user->username) ? $user->username: "Gust";?>
								<i class="fa fa-user user-icon"></i>
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<li>
									<a class="dropdown-item">
										الأعدادات
										<i class="fa fa-gear fa-fw"></i>
									</a>
								</li>
								<li>
									<a class="dropdown-item">
										الوضع الداكن
										<i class="fas fa-moon fa-fw"></i>
									</a>
								</li>
								<?php if (isset($_SESSION['user'])):?>
									<li>
										<a href="<?php echo theURL . language . "/logout";?>" class="dropdown-item">
											تسجيل الخروج
											<i class="fas fa-sign-out-alt fa-fw"></i>
										</a>
									</li>
								<?php else:?>
									<li>
										<a href="<?php echo theURL . language . "/login";?>" class="dropdown-item">
											تسجيل الدخول
											<i class="fas fa-sign-in-alt fa-fw"></i>
										</a>
									</li>
								<?php endif;?>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="<?php echo theURL . language . "/home";?>">
								الرئيسية
								<i class="fa fa-home fa-fw"></i>
							</a>
						</li>
						<?php if (isset($user)):?>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href=
								"<?php if ($user::USER_TYPE == 1) {
									echo theURL . language . "/dashboard-admin";
								}elseif ($user::USER_TYPE == 2) {
									echo theURL . language . "/dashboard-teacher";
								}else {
									echo theURL . language . "/dashboard-student";
								}?>">
									لوحة التحكم
									<i class="fas fa-tachometer-alt fa-fw"></i>
								</a>
							</li>
						<?php endif;?>
						<?php if (isset($user)):?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo theURL . language . "/course/1";?>">
									التعليم
									<i class="fa fa-book fa-fw"></i>
								</a>
							</li>
						<?php endif;?>
						<?php if (isset($user)):?>
							<li class="nav-item">
								<a class="nav-link" href="">
									الاحصائيات
									<i class="fas fa-chart-bar fa-fw"></i>
								</a>
							</li>
						<?php endif;?>
					</ul>
				</div>
			</div>
		</nav>
	</header>