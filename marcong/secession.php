<?php
session_start();
if(!isset($_SESSION['email'])) {
	echo "<meta http-equiv='refresh' content='0;url=main.php'>";
	exit;
}

$servername = "localhost";
$username = "heumheum2";
$password = "password";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
}
$email = $_SESSION['email'];
$query_pw = "SELECT password FROM personal_info WHERE email = '$email';";
$result_pw = mysqli_query($con, $query_pw);
$row_pw = mysqli_fetch_assoc($result_pw);
$pw = $row_pw['password'];
mysqli_close($con);
 ?>

 <!DOCTYPE html>
 <html lang="ko">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
	 <!-- <meta name="google-signin-client_id" content="207222079685-lugbo8q601dhviovadrr3p99p7ndqrh4.apps.googleusercontent.com"> -->
     <title>마이페이지</title>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
			 <script src="https://apis.google.com/js/api:client.js"></script>
	     <script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
  </head>
  <body>
    <header>
      <?php include "top.php" ?>
    </header>
    <div class="pull-right sticky-top">
      <?php include "sidemenu.php" ?>
    </div>

    <div id="div_edit" class="container" style="height:500px;">
      <h3>회원탈퇴</h3>
      <hr>

      <div class="row">
        <div class="col-sm-2">
          <ul class="list-group list-group-flush sticky-top">
            <a href="./mypage.php" style="border: 0 none;" class="list-group-item list-group-item-action">개인정보변경</a>
            <a href="./wishlist.php" style="border: 0 none;" class="list-group-item list-group-item-action">관심상품</a>
            <a href="./lookup.php" style="border: 0 none;" class="list-group-item list-group-item-action">예약조회</a>
						<a href="./secession.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>회원탈퇴</h5></a>
          </ul>
        </div>
        <div class="col-sm-1">
        </div>
				<?php
				if(!empty($pw)){
					if(isset($_SESSION['uid'])){
							$uid = $_SESSION['uid'];
					}
					?>
					<div id="em" class="col">
	            <div class="card text-center">
	              <div class="card-body">
	                <br>
	               <p>정보 확인을 위해 비밀번호를 입력해주시기 바랍니다.</p>
	               <br>
	               <div class="input-group">
	                 <input id="pw" type="password" class="form-control text-center" name="pw"/>
	                 <div class="input-group-append">
	                   <button id="pw_bt" type="button" class="btn btn-success"name="button">입력
	                   </button>
										 <input id="uid" type="hidden" name="uid" value="<?php echo $uid; ?>">
	                 </div>
	               </div>
	               <br>
	              </div>
	            </div>
	        </div>
					<?php
				}else{
					$uid = $_SESSION['uid'];
					?>
          <div id="em" class="col">
	            <div class="card text-center">
	              <div id="card_div" class="card-body">
	                   <button id="certification_bt" type="button" class="btn btn-success btn-block"name="button">인증번호 받기
	                   </button>
	              </div>
	            </div>
	        </div>
          <?php
				}
				 ?>
        <div class="col-sm-2">
        </div>

      </div>
    </div>

    <footer>
      <?php include "footer.php" ?>
    </footer>

    <script>
		$(function startApp() {
		  gapi.load('auth2', function(){
		    // Retrieve the singleton for the GoogleAuth library and set up the client.
		    auth2 = gapi.auth2.init({
		      client_id: '207222079685-lugbo8q601dhviovadrr3p99p7ndqrh4.apps.googleusercontent.com',
		      cookiepolicy: 'single_host_origin'
		      // Request scopes in addition to 'profile' and 'email'
		      //scope: 'additional_scope'
		    });
		  });
		});

		function signOut() {
				var auth3 = gapi.auth2.getAuthInstance();
	    	auth3.signOut().then(function() {
				auth3.disconnect();
				alert("탈퇴되었습니다.");
				location.replace("./logout.php");
	    });
  }

	function kakaoOut(){
		Kakao.init('08d65c3f64046fc30f8aefe7e6b9eb49');
		Kakao.Auth.logout(function(logout){
			alert("탈퇴되었습니다.");
			location.replace("./logout.php");
		});
	}

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

    $('#pw_bt').click(function(){
			var uid = $('#uid').val();
			var pw = $('#pw').val();
      $.ajax({
        type:"POST",
         url: "./secession_pw.php",
         data : {email : "<?php echo $email; ?>", password : pw},
         dataType:"text",
         success : function(data){
           if(data != 0){
						 var secession_check = confirm("탈퇴하시겠습니까?");
						 if(secession_check){
							 if(uid == ''){
								 $.ajax({
									 type:"POST",
									 url: "./secession_db.php",
									 data : {email : "<?php echo $email; ?>"},
									 dataType:"text",
									 success : function(data){
										 alert(data);
										 location.replace("./logout.php");
									 },
									 error : function(data){
										 alert('error');
									 }
								 });
							 }else{
								 $.ajax({
 									type : "POST",
 									url : "./uid_confirm.php",
 									data : {email : "<?php echo $email; ?>", uid : "<?php echo $uid; ?>"},
 									dataType : "text",
 									success : function(data){
 										if(data == 0){ //google
 											signOut();
 										}else{ //kakao
 											kakaoOut();
 										}
 									},
 									error : function(data){
 										alert('error');
 									}
 								});
							 }
						 }
           }else{
             alert("잘못 입력하였습니다.");
           }
         },
         error : function(data){
           alert('error');
         }
      });
    });

    $('#certification_bt').click(function(){
      $.ajax({
        type : "POST",
        url : "./PHPMailer/certification_email.php",
        data : {email : "<?php echo $email; ?>"},
        dataType : "text",
        success : function(data){
          alert("인증번호를 보냈습니다.");
          $('#card_div').empty();
					console.log(data);
          var card = "<input type='number' id='certification_Number' class='form-control' name='certification_Number' placeholder='인증번호 6자리를 입력해주세요.' onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' max='999999' maxlength='6' oninput='maxLengthCheck(this)'/>\
					<br>\
          <button id='secession_bt' class='btn btn-primary btn-block' type='button'>확인</button>";
          $('#card_div').html(card);
					$('#secession_bt').click(function(){
						if($('#certification_Number').val() == data){
							var secession_check = confirm("탈퇴하시겠습니까?");
							if(secession_check){
								$.ajax({
									type : "POST",
									url : "./uid_confirm.php",
									data : {email : "<?php echo $email; ?>", uid : "<?php echo $uid; ?>"},
									dataType : "text",
									success : function(data){
										if(data == 0){ //google
											signOut();
										}else{ //kakao
											kakaoOut();
										}
									},
									error : function(data){
										alert('error');
									}
								});
							}else{
								alert("취소하였습니다.");
								location.replace();
							}
						}else if($('#certification_Number').val() == ''){
							alert("인증번호를 입력해주세요.");
						}else{
							alert("일치하지 않는 인증번호입니다.");
						}
					});
        },
        error : function(data){
          alert('mailer error');
        }
      });
    });
    </script>
  </body>
  </html>
