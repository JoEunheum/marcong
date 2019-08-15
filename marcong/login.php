<?php
$id = $_GET['id'];
 ?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
  <title>회원 로그인</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
  .border {
    display: inline-block;
  }
  </style>
</head>
<body>
  <header>
    <?php include "top.php" ?>
  </header>

  <div class="pull-right sticky-top">
    <?php include "sidemenu.php" ?>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-8 border border-bottom-0">
      </br>
        <h2 class="text-muted">MEMBERS</h2>
        <h1>LOGIN</h1>
  </br>
          <input type="radio"  name="selectRadio" value="personal" onclick="signCheck(this)" checked>개인
            <input type="radio"  name="selectRadio" value="office" onclick="signCheck(this)">업체

            <script>
              function signCheck(radio_val){
                if(radio_val.value=='personal'){
                  $('#login_form').attr("action", "login_db.php");
                }else{
                  $('#login_form').attr("action","login_office.php");
                }
              }
            </script>

        <form id="login_form" action="login_db.php" method="post" class="form-signin needs-validation" novalidate>

          <div class="form-group">
              <div class="input-group">
              	<div class="input-group-prepend">
              		   <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              		</div>
                  <input type="text" name="id" value="<?php echo $id; ?>" hidden/>
		                <input name="email" class="form-control" id="userid" placeholder="Enter email" type="email"  required autofocus/>
                    <div class="valid-feedback">Ok</div>
                    <div class="invalid-feedback">정확한 이메일 형식을 입력해주세요.</div>
                  </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
		              <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input name="password" type="password" class="form-control" id="pwd" placeholder="Enter password" required>
                <div class="valid-feedback">Ok</div>
                <div class="invalid-feedback">비밀번호를 입력해주세요.</div>
          </div>
          </div>

        </br>
          <input type="submit" class="shadow btn btn-secondary" value="로그인"/>
        </form>
</div>
<div class="col-md-4 col-sm-10 border border-bottom-0">
</br>
  <h2 class="text-muted">SIGN</h2>
  <h1>UP</h1>
</br>
<a href="signup.php" class="btn-block shadow btn btn-secondary" role="button">회원가입하기</a>
</br>
<button type="button" class="btn-block shadow btn btn-light">비밀번호 찾기</button>
</div>
</div>
</br>
<p>
		<a href="#" class="btn btn-block btn-outline-danger"> <i class="fab fa-google-plus-g"></i>   구글로 로그인</a>
		<a href="#" class="btn btn-block btn-outline-primary"> <i class="fab fa-facebook-f"></i>   페이스북으로 로그인</a>
    <a href="#" class="btn btn-block btn-outline-warning"> <i class="fas fa-comment"></i>   카카오로 로그인</a>
	</p>
  </div>
<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

</script>

<footer>
  <?php include "footer.php" ?>
</footer>
</body>

</html>
