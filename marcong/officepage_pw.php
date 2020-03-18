<?php
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
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
$password = md5($_POST['password']);

$query_office = "SELECT password FROM office_info WHERE password = '$password' AND email = '$email';";
$result_office = mysqli_query($con,$query_office);
$row = mysqli_num_rows($result_office);
if($row==0){
  echo $row;
  mysqli_close($con);
}else{
  include "officepage_info_in.php";
  mysqli_close($con);
}
 ?>
