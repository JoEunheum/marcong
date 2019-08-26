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
$uid = $_POST['uid'];

$query_uid = "SELECT * FROM personal_info WHERE email = '$email' AND uid = '$uid';";
$result_uid = mysqli_query($con, $query_uid);
if(mysqli_num_rows($result_uid) == 0){
  $query_del = "DELETE FROM personal_info WHERE email = '$email' AND g_uid = '$uid';";
  if(mysqli_query($con, $query_del)){
    echo 0;
  }
}else{
  $query_del = "DELETE FROM personal_info WHERE email = '$email' AND uid = '$uid';";
  if(mysqli_query($con, $query_del)){
    echo 1;
  }
}
mysqli_close($con);

 ?>
