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
$status = $_POST['status'];

$email = $_SESSION['email'];
$name = $_SESSION['name'];

$query_review = "INSERT INTO review(reservation_number, idnumber, email, name, coment, grade) VALUES('$reservation_number', '$idnumber', '$email', '$name', '$coment', '$grade');";
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
    $query_look = "UPDATE reservation_look SET status = '$status' WHERE reservation_number = '$reservation_number';";
    if(!mysqli_query($con, $query_look)){
      echo mysqli_error($con);
      mysqli_close($con);
    }else{
      echo "리뷰가 작성되었습니다.";
      mysqli_close($con);
    }
  }
}
 ?>
