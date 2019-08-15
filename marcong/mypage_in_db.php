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
$phone_number = $_POST['number'];
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$birth = $year ."-". $month ."-". $day;
if($_POST['password'] != ""){
  $password = md5($_POST['password']);
  $query_person = "UPDATE personal_info SET password = '$password', phone_number = '$phone_number', date_of_birth = '$birth' WHERE email = '$email';";

  if(!mysqli_query($con,$query_person)){
    echo "쿼리문 오류 :".mysqli_error($con);
  }else{
    ?>
    <script>
      alert("변경되었습니다.");
      location.replace("./mypage.php");
    </script>
    <?php
  }
}else{
  $query_person = "UPDATE personal_info SET phone_number = '$phone_number', date_of_birth = '$birth' WHERE email = '$email';";

  if(!mysqli_query($con,$query_person)){
    echo "쿼리문 오류 :".mysqli_error($con);
  }else{
    ?>
    <script>
      alert("변경되었습니다.");
      location.replace("./mypage.php");
    </script>
    <?php
  }
}
mysqli_close($con);
 ?>
