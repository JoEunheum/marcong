<?php
session_start();
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
$query_email = "SELECT * FROM personal_info WHERE email = '$email';";
$result_email = mysqli_query($con, $query_email);

if(mysqli_num_rows($result_email) == 0){ // no email
  if(isset($_POST['g_uid'])){ // google_login
    $uid = $_POST['g_uid'];
    $query_uid = "SELECT g_uid FROM personal_info WHERE g_uid = '$uid';";
    $result_uid = mysqli_query($con, $query_uid);
    if(mysqli_num_rows($result_uid) == 0){
      $_SESSION['g_uid'] = $uid;
      $_SESSION['uid_email'] = $email;
      echo 0; //singup
    }
  }else{ // kakao login
    $uid = $_POST['uid'];
    $query_uid = "SELECT uid FROM personal_info WHERE uid = '$uid';";
    $result_uid = mysqli_query($con, $query_uid);
    if(mysqli_num_rows($result_uid) == 0){
      $_SESSION['uid'] = $uid;
      $_SESSION['uid_email'] = $email;
      echo 0; //singup
    }
  }
}else{ //use email
  if(isset($_POST['g_uid'])){ // google login
    $uid = $_POST['g_uid'];
    $query_uid = "SELECT g_uid FROM personal_info WHERE g_uid = '$uid' AND email = '$email';";
    $result_uid = mysqli_query($con, $query_uid);
    if(mysqli_num_rows($result_uid) == 0){
      $query_update = "UPDATE personal_info SET g_uid = '$uid' WHERE email = '$email';";
      mysqli_query($con, $query_update);
    }
    $query = "SELECT name FROM personal_info WHERE g_uid = '$uid' AND email = '$email';";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email']=$email;
    $_SESSION['name']=$row['name'];
    $_SESSION['uid'] = $uid;
    echo 1; //login

    }else{ //kakao login

      $uid = $_POST['uid'];
      $query_uid = "SELECT uid FROM personal_info WHERE uid = '$uid' AND email = '$email';";
      $result_uid = mysqli_query($con, $query_uid);
      if(mysqli_num_rows($result_uid) == 0){
        $query_update = "UPDATE personal_info SET uid = '$uid' WHERE email = '$email';";
        mysqli_query($con, $query_update);
      }
      $query = "SELECT name FROM personal_info WHERE uid = '$uid' AND email = '$email';";
      $result = mysqli_query($con,$query);
      $row = mysqli_fetch_assoc($result);
      $_SESSION['email']=$email;
      $_SESSION['name']=$row['name'];
      $_SESSION['uid'] = $uid;
      echo 1; //login
    }
  }
mysqli_close($con);
 ?>
