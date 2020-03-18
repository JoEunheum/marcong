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
$uid = $_SESSION['uid'];
$query_in = "SELECT password, phone_number FROM personal_info WHERE uid = '$uid' OR g_uid = '$uid';";
$result_in = mysqli_query($con, $query_in);
$row_in = mysqli_fetch_assoc($result_in);
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$pw = $row_in['password'];
$phone_number = $row_in['phone_number'];
mysqli_close($con);
 ?>

 <!DOCTYPE html>
 <html lang="ko">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
     <title>마이페이지</title>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </head>
  <body>
    <header>
      <?php include "top.php" ?>
    </header>
    <div class="pull-right sticky-top">
      <?php include "sidemenu.php" ?>
    </div>

    <div id="div_edit" class="container" style="height:500px;">
      <h3>개인정보변경</h3>
      <hr>

      <div class="row">
        <div class="col-sm-2">
          <ul class="list-group list-group-flush sticky-top">
            <a href="./mypage.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>개인정보변경</h5></a>
            <a href="./wishlist.php" style="border: 0 none;" class="list-group-item list-group-item-action">관심상품</a>
            <a href="./lookup.php" style="border: 0 none;" class="list-group-item list-group-item-action">예약조회</a>
						<a href="./secession.php" style="border: 0 none;" class="list-group-item list-group-item-action">회원탈퇴</a>
          </ul>
        </div>
        <div class="col-sm-1">
        </div>
				<?php
				if(!isset($_SESSION['uid']) || !empty($pw)){
					?>
					<div id="em" class="col">
	            <div class="card text-center">
	              <div class="card-body">
	                <br>
	               <p>정보 변경을 위해 비밀번호를 입력해주시기 바랍니다.</p>
	               <br>
	               <div class="input-group">
	                 <input id="pw" type="password" class="form-control text-center" name="pw"/>
	                 <div class="input-group-append">
	                   <button id="pw_bt" type="button" class="btn btn-success"name="button">입력
	                   </button>
	                 </div>
	               </div>
	               <br>
	              </div>
	            </div>
	        </div>
					<?php
				}else{
					?>
					<div id="em" class="col">
					<form id="mypage_form" method="post">
					       <table class="table table-bordered">
					         <tbody>
					             <div class="form-group">
					               <tr>
					                   <th width="15%">이름: </th>
					                   <td><input readonly id="title" name="title" type="text" placeholder="이름을 입력하세요. " value="<?php echo $name; ?>" class="form-control onlyHangul"/></td>
					               </tr>
					             </div>

					             <div class="form-group">
					               <tr>
					                   <th>이메일: </th>
					                   <td><input readonly type="email" class="form-control" id="email" data-rule-required="true" name="email" value="<?php echo $email; ?>" maxlength="30"></td>
					               </tr>
					             </div>

					             <div class="form-group">
					               <tr>
					                   <th>휴대폰<br>번호:</th>
					                   <td><input type="tel" class="mt-1 form-control onlyNumber" id="phoneNumber" data-rule-required="true" placeholder="휴대폰번호 (- 없이 숫자만 입력)" maxlength="11" name="number" value="<?php echo $phone_number; ?>"></td>
					               </tr>
					             </div>

					                 <tr>
					                     <td colspan="2">
					                         <input id="upload" type="submit" value="변경" class="pull-right btn btn-success" formaction="./mypage_in_db.php"/>
					                     </td>
					                 </tr>
					         </tbody>
					       </table>
					</form>
				</div>

					<script type="text/javascript" src="mypage_in.js">
					</script>

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
    $('#pw_bt').click(function(){
      var pw = $('#pw').val();
      $.ajax({
        type:"POST",
         url: "./mypage_pw.php",
         data : {password : pw},
         dataType:"text",
         success : function(data){
           if(Number(data)!=0){
             $('#em').empty();
             $('#div_edit').css("height","700px");
             $('#em').prepend(data);
           }else{
             alert("잘못 입력하였습니다.");
           }
         },
         error : function(data){
           alert('error');
         }
      });
    });
    </script>
  </body>
  </html>
