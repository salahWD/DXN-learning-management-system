<?php

if (isset($_SESSION['user'])):

  header("Location: " . theURL . language . '/home');// redirect
  exit();

else:
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new Teacher();
    
    $user->login($_POST['dxn-id'], $_POST['pass']);

    $_SESSION["user"] = $user;

    header("Location: " . theURL . language . '/dashboard-teacher');// redirect
    exit();

  }
  ?>
  <div class="login">
    <div class="container">
      <form action="<?php echo theURL . language . '/login-teacher';?>" method="POST">
        <div class="form-container">
          <h2 class="title">تسجيل الدخول</h2>
          <?php if (isset($errors)):?>
            <div class="errors">
              <?php foreach($errors as $err):?>
                <p class="lead text-danger m-0"><?php echo $err;?></p>
              <?php endforeach;?>
            </div>
          <?php endif;?>
          <div class="input-container">
            <input
                type="number"
                id="dxn_id"
                class="form-control"
                name="dxn-id">
            <div class="label-container">
              <label for="dxn_id">DXN معرف</label>
            </div>    
          </div>
          <div class="input-container">
            <input
                type="password"
                id="pass"
                class="form-control"
                name="pass">
            <div class="label-container">
              <label for="pass">كلمة المرور</label>
            </div>
          </div>
          <div class="check-container">
            <input
                type="checkbox"
                id="remember"
                name="remember">
            <label for="remember" class="checkbox-label">تذكرني</label>
          </div>
          <div class="d-grid mt-4">
            <button class="btn btn-primary" type=submit>تسجيل الدخول</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endif;?>