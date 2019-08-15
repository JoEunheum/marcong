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

$reservation_number = $_POST['reservation_number'];
$idnumber = $_POST['idnumber'];
$grade = $_POST['grade'];
$coment = $_POST['coment'];

$email = $_SESSION['email'];

$query_review = "UPDATE review SET grade = '$grade', coment = '$coment' WHERE reservation_number = '$reservation_number' AND email = '$email';";
if(!mysqli_query($con, $query_review)){
  echo mysqli_error($con);
  mysqli_close($con);
}else{
  $query_grade = "SELECT grade FROM review WHERE idnumber = '$idnumber';";
  $result_grade = mysqli_query($con, $query_grade);
  $sum = 0;
  $i=0; //size check
  while ($row_grade = mysqli_fetch_assoc($result_grade)) {
    $sum+=$row_grade['grade'];
    $i++;
  }
  $avg = $sum/$i;
  $grade_avg = round($avg, 1);
  $query_office = "UPDATE office_item SET grade = '$grade_avg' WHERE idnumber = '$idnumber';";
  if(!mysqli_query($con, $query_office)){
    echo mysqli_error($con);
    mysqli_close($con);
  }else{
      echo "리뷰가 수정되었습니다.";
      mysqli_close($con);
    }
  }

 ?>
