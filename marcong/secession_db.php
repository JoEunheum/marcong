<?php
$servername = "localhost";
$username = "heumheum2";
$password = "password";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$email = $_POST['email'];
$query_del = "DELETE FROM personal_info WHERE email = '$email';";
if(mysqli_query($con, $query_del)){
  echo "탈퇴되었습니다.";
}else{
  echo mysqli_error($con);
}
mysqli_close($con);
 ?>
