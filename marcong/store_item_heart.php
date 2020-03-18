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

$like_check = $_POST['check'];
$email = $_POST['email'];
$idnumber = $_POST['idnumber'];
$office_like = $_POST['office_like'];

if($like_check =='N'){
  $query_check = "UPDATE personal_wish SET like_check = 'Y' WHERE email = '$email' AND item_id = '$idnumber';";
  mysqli_query($con, $query_check);
  $check='Y';
  $office_like+=1;
  $query_like = "UPDATE office_item SET office_like = '$office_like' WHERE idnumber = '$idnumber';";
  mysqli_query($con, $query_like);

}else{
  $query_check = "UPDATE personal_wish SET like_check = 'N' WHERE email = '$email' AND item_id = '$idnumber';";
  mysqli_query($con, $query_check);
  $check='N';
  $office_like-=1;
  $query_like = "UPDATE office_item SET office_like = '$office_like' WHERE idnumber = '$idnumber';";
  mysqli_query($con, $query_like);
}
mysqli_close($con);
echo $check;
 ?>
