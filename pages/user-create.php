<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST'):

      if (isset($_POST['register_form']) && !empty($_POST['register_form'])) {
        if (isset($_POST["register_form"]['user_type']) && $_POST["register_form"]['user_type'] == 1) {

          $teacher = new Teacher();
          $teacher->set_teacher($_POST["register_form"]);

          if ($teacher->create_teacher()) {
            $user_type = ($_SESSION["user"]::USER_TYPE == 1) ? "admin" : "teacher";
            header("Location: " . theURL . language . '/dashboard-' . $user_type);// done_redirect
            exit();
          }else {
            echo "error on creating teacher";// error
            exit();
          }
        }else {
          $student = new Student();
          $student->set_data($_POST["register_form"]);
          
          if ($student->create_student()) {
            $user_type = ($_SESSION["user"]::USER_TYPE == 1) ? "admin" : "teacher";
            header("Location: " . theURL . language . '/dashboard-' . $user_type);// done_redirect
            exit();
          }else {
            echo "error on creating student";// error
            exit();
          }
        }

      }else {// if ther is a Shortage in POST info
        header("Location: " . theURL . language . '/user-create');// error_redirect
        exit();
      }
    endif;
  ?>

  <div class="register">
    <form action="<?php echo theURL . language . '/user-create';?>" method="POST">
      <div class="form-container">
        <h2 class="title">تسجيل مستخدم</h2>
        <div class="input-container radio">
          <div class="option">
            <input
                type="radio"
                name="register_form[user_type]"
                id="student"
                checked
                value="0">
            <label for="student">طالب</label>
          </div>
          <div class="option">
            <input
                type="radio"
                name="register_form[user_type]"
                id="teacher"
                value="1">
            <label for="teacher">استاذ</label>
          </div>
        </div>
        <div class="input-container teacher">
          <input
              type="text"
              name="teacher_info[permission]"
              id="teacher_info"
              class="form-control">
          <div class="label-container">
            <label for="teacher_info">معلومات الاستاذ</label>
          </div>
        </div>
        <div class="input-container student">
          <input
              type="text"
              name="student_info[father_name]"
              id="student_info"
              class="form-control">
          <div class="label-container">
            <label for="student_info">معلومات الطالب</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="text"
              name="register_form[fullname]"
              id="fullname"
              value="teacher doctur"
              class="form-control">
          <div class="label-container">
            <label for="fullname">الاسم الكامل</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="email"
              name="register_form[email]"
              id="email"
              value="teacher@info.com"
              class="form-control">
          <div class="label-container">
            <label for="email">البريد الالكتروني</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="text"
              name="register_form[username]"
              id="username"
              value="teacher_user"
              class="form-control">
          <div class="label-container">
            <label for="username">اسم المستخدم</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="date"
              value="2019-06-17"
              name="register_form[birthdate]"
              id="birthdate"
              class="form-control">
          <div class="label-container">
            <label for="birthdate">تاريخ الميلاد</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="number"
              name="register_form[dxnid]"
              id="dxnid"
              value="555"
              class="form-control">
          <div class="label-container">
            <label for="dxnid">معرف DXN</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="password"
              value="123"
              name="register_form[password]"
              id="pass"
              class="form-control">
          <div class="label-container">
            <label for="pass">كلمة المرور</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="text"
              name="register_form[country]"
              value="istanbul"
              id="country"
              class="form-control">
          <div class="label-container">
            <label for="country">المدينة</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="number"
              name="register_form[mobile]"
              value="123321123"
              id="phone"
              class="form-control">
          <div class="label-container">
            <label for="phone">رقم الهاتف</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="text"
              name="register_form[job]"
              id="job"
              value="designer"
              class="form-control">
          <div class="label-container">
            <label for="job">الوظيفة</label>
          </div>
        </div>
        <div class="input-container">
          <input
              type="text"
              name="register_form[address]"
              id="address"
              value="here"
              class="form-control">
          <div class="label-container">
            <label for="address">العنوان</label>
          </div>
        </div>
        <div class="input-container radio">
          <div class="option">
            <input
                type="radio"
                name="register_form[gander]"
                id="female"
                value="0">
            <label for="female">انثى</label>
          </div>
          <div class="option">
            <input
                type="radio"
                name="register_form[gander]"
                id="male"
                checked
                value="1">
            <label for="male">ذكر</label>
          </div>
        </div>
        <div class="d-grid mt-4">
          <input type="submit" value="انشاء عضو" class="btn btn-primary">
        </div>
      </div>
    </form>
  </div>

?>