<?php
session_start();
if(!isset($_SESSION['email'])) {
	echo "<meta http-equiv='refresh' content='0;url=main.php'>";
	exit;
}

$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$email = $_SESSION['email'];
$password = md5($_POST['password']);

$query_person = "SELECT password FROM personal_info WHERE password = '$password' AND email = '$email';";
$result_person = mysqli_query($con,$query_person);
$row = mysqli_num_rows($result_person);
if($row==0){
  echo $row;
  mysqli_close($con);
}else{
  include "mypage_in.php";
  mysqli_close($con);
}
 ?>
