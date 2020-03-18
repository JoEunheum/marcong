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

$list_count = $_POST['listcount'];
$idnumber = $_POST['idnumber'];

$query_reviews = "SELECT name, grade, coment, upload_time FROM review WHERE idnumber = '$idnumber' ORDER BY upload_time DESC LIMIT $list_count, 5;";
$result_reviews = mysqli_query($con,$query_reviews);
$count_reviews = mysqli_num_rows($result_reviews);
$sum = $list_count + $count_reviews;

$i=0;
while ($row_review = mysqli_fetch_assoc($result_reviews)) {
  $name[$i] = $row_review['name'];
  $review_grade[$i] = $row_review['grade'];
  $coment[$i] = $row_review['coment'];
  $upload = explode(' ', $row_review['upload_time']);
   $upload_time[$i] = $upload[0];
  if($review_grade[$i] >= 0.0 && $review_grade[$i] < 1.9){
    $review_grade_tag[$i] = '별로에요';
  }else if($review_grade[$i] >= 2.0 && $review_grade[$i] < 2.9){
    $review_grade_tag[$i] = '잘모르겠어요';
  }else if($review_grade[$i] >= 3.0 && $review_grade[$i] < 3.9){
    $review_grade_tag[$i] = '그럭저럭';
  }else if($review_grade[$i] >= 4.0 && $review_grade[$i] < 4.9){
    $review_grade_tag[$i] = '가볼만해요';
  }else{
    $review_grade_tag[$i] = '인생마카롱';
  }
  $html = "<input id='plus_sum' type ='hidden' value = '$sum'>
  <h6>$upload_time[$i] $name[$i]</h6>
  <h4 class='text-warning'>$review_grade[$i] <strong class='text-dark'>$review_grade_tag[$i]</strong></h4>
  <h5 class='text-secondary'>$coment[$i]</h5>
  <hr>";
  echo $html;
  $i++;
}

mysqli_close($con);
 ?>
