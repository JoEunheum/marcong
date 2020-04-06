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
    <script src="https://apis.google.com/js/api:client.js"></script>
    <script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>

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
<button id="pw_found" type="button" class="btn-block shadow btn btn-light">비밀번호 찾기</button>
</div>
</div>
</br>
<p>
		<button id="googleBtn"data-onsuccess="onSignIn" class="btn btn-block btn-outline-danger"> <i class="fab fa-google-plus-g"></i>   구글로 로그인</button>
    <a href="javascript:loginWithKakao()" class="btn btn-block btn-outline-warning"> <i class="fas fa-comment"></i>   카카오로 로그인</a>
	</p>
  </div>

  <form name="foundForm" method="POST">
      <!-- The Modal -->
  <div class="modal fade" id="foundModal">
  <div class="modal-dialog modal-dialog-centered">
  <div id="reset_div" class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
      <input readonly type="text" class="font-weight-bold" id="found_header" style="border: 0 none; font-size:150%; width:200px;" value="비밀번호 찾기"/>
      <button id="close_found" type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div id="reset_number">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <h6>이메일</h6>
          <input type="email" id="email" class="form-control"name="email" placeholder="이메일을 입력해주세요.">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input id="found_pw"type="button" class="btn btn-primary" value="찾기">
      </div>
    </div>

  </div>
  </div>
  </div>
    </form>

<script>
var idnumber = "<?php echo $id; ?>";
var googleUser = {};
var startApp = function() {
  gapi.load('auth2', function(){
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id: '207222079685-lugbo8q601dhviovadrr3p99p7ndqrh4.apps.googleusercontent.com',
      cookiepolicy: 'single_host_origin'
      // Request scopes in addition to 'profile' and 'email'
      //scope: 'additional_scope'
    });
    attachSignin(document.getElementById('googleBtn'));
  });
};

function attachSignin(element) {
  // console.log(element.id);
  auth2.attachClickHandler(element, {},
      function(googleUser) {
        var uid = googleUser.getBasicProfile().getId();
        var email = googleUser.getBasicProfile().getEmail();
        $.ajax({
          type: "POST",
          url : "./uid_check.php",
          data : {g_uid : uid, email : email},
          dataType : "text",
          success : function(data){
            if(data == '0'){
              alert('회원가입 페이지로 이동합니다.');
              location.replace('./signup_uid.php');
            }else{
              alert("로그인 되었습니다.");
              if(idnumber != ''){
                location.replace("store_item.php?id=<?php echo $id; ?>");
              }else{
                location.replace("./main.php");
              }
            }
          },
          error : function(data){
            alert('error');
          }
        });

      }, function(error) {
        // alert(JSON.stringify(error, undefined, 2));
      });
}
startApp();

//<![CDATA[
  // 사용할 앱의 JavaScript 키를 설정해 주세요.
  Kakao.init('08d65c3f64046fc30f8aefe7e6b9eb49');
  function loginWithKakao() {
    // 로그인 창을 띄웁니다.
    var access = Kakao.Auth.getAccessToken();
    if(!access){
      Kakao.Auth.loginForm({
        success: function(authObj) {
          Kakao.API.request({
            url: '/v2/user/me',
            success: function(res) {
              var uid = JSON.stringify(res.id);
              var email = JSON.stringify(res.kakao_account.email);
              email = email.slice(1, -1);
              $.ajax({
                  type: "POST",
                  url : "./uid_check.php",
                  data : {uid : uid, email : email},
                  dataType : "text",
                  success : function(data){
                    if(data == '0'){
                      alert('회원가입 페이지로 이동합니다.');
                      location.replace('./signup_uid.php');
                    }else{
                      alert("로그인 되었습니다.");
                      if(idnumber != ''){
                        location.replace("store_item.php?id=<?php echo $id; ?>");
                      }else{
                        location.replace("./main.php");
                      }
                    }
                  },
                  error : function(data){
                    alert('error');
                  }
                }); //end ajax
            },
            fail: function(error) {
              alert(JSON.stringify(error));
            }
          });
        },
        fail: function(err) {
          alert(JSON.stringify(err));
        }
      });
    }else{
      Kakao.Auth.login({
        success: function(authObj) {
          Kakao.API.request({
            url: '/v2/user/me',
            success: function(res) {
              var uid = JSON.stringify(res.id);
              var email = JSON.stringify(res.kakao_account.email);
              email = email.slice(1, -1);
              $.ajax({
                  type: "POST",
                  url : "./uid_check.php",
                  data : {uid : uid, email : email},
                  dataType : "text",
                  success : function(data){
                      alert("로그인 되었습니다.");
                      if(idnumber != ''){
                        location.replace("store_item.php?id=<?php echo $id; ?>");
                      }else{
                        location.replace("./main.php");
                      }
                  },
                  error : function(data){
                    alert('error');
                  }
                }); //end ajax
            },
            fail: function(error) {
              alert(JSON.stringify(error));
            }
          });
        },
        fail: function(err) {
          alert(JSON.stringify(err));
        }
      });
    }

  }
//]]>
</script>


<script>
// Disable form submissions if there are invalid fields
function maxLengthCheck(object){
   if (object.value.length > object.maxLength){
    object.value = object.value.slice(0, object.maxLength);
   }
 }

function onlyNumber(event){
			event = event || window.event;
			var keyID = (event.which) ? event.which : event.keyCode;
			if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 )
				return;
			else
				return false;
		}
		function removeChar(event) {
			event = event || window.event;
			var keyID = (event.which) ? event.which : event.keyCode;
			if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 )
				return;
			else
				event.target.value = event.target.value.replace(/[^0-9]/g, "");
		}

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

$('#pw_found').click(function(){
  $('#foundModal').modal({backdrop : "static"});

  $('.onlyAlphabetAndNumber').keyup(function(event) {
    if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
      var inputVal = $(this).val();
      $(this).val($(this).val().replace(/[^_a-z0-9]/gi, '')); //_(underscore), 영어, 숫자만 가능
    }
  });

  $('#foundModal').on('hidden.bs.modal', function () {
  location.reload();
});

  $('#found_pw').click(function(){
    var email = $('#email').val();
    if(email == ''){
      alert('이메일을 입력해주세요.');
    }else{
      $.ajax({
        type:"POST",
        url : "./PHPMailer/found_pw.php",
        data : {email : email},
        dataType : "text",
        success:function(data){
          if(data == 0){
            alert('가입되지 않은 이메일입니다.');
          }else{
            alert('해당 이메일로 인증번호를 보냈습니다.');
            $('#reset_number').empty();
            $('#reset_number').html(data);

            $('#ok_num').click(function(){
              var certification_number = $('#certification_Number').val();
              var certification = $('#certification').val()
              if(certification_number == ''){
                alert('인증번호 6자리를 입력해주세요.');
              }else if(certification_number != certification){
                alert('인증번호가 일치하지 않습니다.');
              }else{
                $('#found_header').val("비밀번호 변경");
                $('#reset_number').empty();
                var change = "<div class='modal-body'>\
                <div class='form-group'>\
                  <tr>\
                      <th>비밀번호 </th>\
                      <td><input type='password' class='onlyAlphabetAndNumber form-control' id='pw' placeholder='비밀번호 변경' maxlength='30'></td>\
                  </tr>\
                </div>\
                <div class='form-group'>\
                  <tr>\
                      <th>비밀번호 확인</th>\
                      <td><input type='password' class='onlyAlphabetAndNumber mt-1 form-control' id='pwCheck'  placeholder='비밀번호 확인' maxlength='30' name='password'></td>\
                  </tr>\
                </div>\
                </div></div>\
                <div class='modal-footer'>\
                <input id='change_pw' type='button' class='btn btn-primary' value='변경'>\
                </div></div>";
                $('#reset_number').html(change);
                $('#change_pw').click(function(){

                  if ($('#pw').val() == "") {
                    alert("패스워드를 입력하여 주시기 바랍니다.");
                    $('#pw').focus();
                  }else if($('#pwCheck').val() == ""){
                    alert("패스워드 확인을 입력하여 주시기 바랍니다.");
                    $('#pwCheck').focus();
                  }else if($('#pw').val() != $('#pwCheck').val()) {
                    alert("패스워드가 일치하지 않습니다.");
                    $('#pwCheck').focus();
                  }else{
                    var pw = $('#pwCheck').val();

                    $.ajax({
                      type: "POST",
                      url : "./pw_change.php",
                      data : {email : email, pw : pw},
                      dataType : "text",
                      success : function(data){
                        alert(data);
                        $('#foundModal').modal("hide");
                      },
                      error : function(data){
                        alert('error');
                      }
                    });

                  }
                }); //end change

              }

            }); //end number

          }
        },
        error : function(data){
          alert('error');
        }
      });

    }

  }); //end email

});//end modal
</script>

<footer>
  <?php include "footer.php" ?>
</footer>
</body>

</html>
