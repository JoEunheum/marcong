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

$email = $_POST['email'];
$password = md5($_POST['pw']);

$query_change = "UPDATE personal_info SET password = '$password' WHERE email = '$email';";
if(!mysqli_query($con, $query_change)){
  echo mysqli_error($con);
}else{
  echo "비밀번호가 변경되었습니다.";
}

mysqli_close($con);

 ?>
