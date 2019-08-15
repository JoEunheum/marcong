<?php
session_start();
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$idnumber = $_SESSION['idnumber'];
$title = $_POST['title'];
$email = $_POST['email'];
$officenumber = $_POST['number'];
$subname = $_POST['subname'];
$introduce = $_POST['introduce'];
$day_week = $_POST['day_week']; //array
$open_time = $_POST['opentime'];
$close_time = $_POST['closetime'];
$today = $open_time.' ~ '.$close_time;
$homepage = $_POST['homepage'];
$address = $_POST['address'];
$workday='';
for ($i=0; $i < sizeof($day_week); $i++) {
 $workday=$workday.$day_week[$i].' ';
}

$query_item = "UPDATE office_item SET name = '$title', subname = '$subname' WHERE idnumber = '$idnumber';";
mysqli_query($con, $query_item);

if($_POST['password'] != ""){
  $password = md5($_POST['password']);
  $query_of_edit = "UPDATE office_info SET password = '$password', name = '$title', office_number = '$officenumber', subname = '$subname', introduce = '$introduce', address = '$address', today = '$today', workday = '$workday', homepage = '$homepage' WHERE email = '$email';";

  if(!mysqli_query($con, $query_of_edit)){
    echo mysqli_error($con);
  }else{
    ?>
    <script>
      alert("변경되었습니다.");
      location.replace("./officepage_info.php");
    </script>
    <?php
  }
}else{
  $query_of_edit = "UPDATE office_info SET name = '$title', office_number = '$officenumber', subname = '$subname', introduce = '$introduce', address = '$address', today = '$today', workday = '$workday', homepage = '$homepage' WHERE email = '$email';";

  if(!mysqli_query($con, $query_of_edit)){
    echo mysqli_error($con);
  }else{
    ?>
    <script>
      alert("변경되었습니다.");
      location.replace("./officepage_info.php");
    </script>
    <?php
  }
}
mysqli_close($con);
 ?>
