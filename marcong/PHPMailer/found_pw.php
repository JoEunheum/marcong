<?php
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "./src/PHPMailer.php";
require "./src/SMTP.php";
require "./src/Exception.php";

$email = $_POST['email'];
$message = sprintf('%06d',rand(000000,999999));


$query_email = "SELECT * FROM personal_info WHERE email = '$email';";
$result_email = mysqli_query($con, $query_email);
if(mysqli_num_rows($result_email) == 0){
  echo 0;
}else{
  $mail = new PHPMailer(true);
  try{
    $mail -> SMTPDebug = 0; // 디버깅 설정
    $mail -> isSMTP(); // SMTP 사용 설정
    // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
    $mail -> Host = "smtp.naver.com";               // 네이버의 smtp 서버
    $mail -> SMTPAuth = true;                         // SMTP 인증을 사용함
    $mail -> Username = "jwh6295@naver.com";    // 메일 계정 (지메일일경우 지메일 계정)
    $mail -> Password = "dms1gma2#$";                  // 메일 비밀번호
    $mail -> SMTPSecure = "ssl";                       // SSL을 사용함
    $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
    $mail -> CharSet = "utf-8"; // 문자셋 인코딩
    // 보내는 메일
    $mail -> setFrom("jwh6295@naver.com", "marcong");
    // 받는 메일
    $mail -> addAddress($email, $email);
    // 메일 내용
    $mail -> isHTML(true); // HTML 태그 사용 여부
    $mail -> Subject = "말콩 인증번호 입니다.";  // 메일 제목
    $mail -> Body = "말콩 인증번호 $message 입니다.";     // 메일 내용
    // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
    // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
    // $mail -> SMTPOptions = array(
    //   "ssl" => array(
    //   "verify_peer" => false
    //   , "verify_peer_name" => false
    //   , "allow_self_signed" => true
    //   )
    // );
    // 메일 전송
    $mail -> send();
    $output = "<div class='modal-body'>
       <div class='form-group'>
           <h6>인증번호</h6>
           <input type='number' id='certification_Number' class='form-control' name='certification_Number' placeholder='인증번호 6자리를 입력해주세요.' onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' max='999999' maxlength='6' oninput='maxLengthCheck(this)'/>
           <input id='certification' type='hidden' value='$message'/>
         </div>
       </div>
       <div class='modal-footer'>
         <input id='ok_num' type='button' class='btn btn-primary' value='확인'>
       </div></div>";
      echo $output;
  }catch (Exception $e) {
    echo "Message could not be sent. Mailer Error : ", $mail -> ErrorInfo;
  }
}
 ?>
