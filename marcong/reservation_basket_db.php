<?php

$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$reservation_number = $_POST['reservation_number'];
$idnumber = $_POST['idnumber'];
$date = $_POST['reservation_day'];
$reservation_day = date("Y-m-d", strtotime("+1 day", strtotime($date)));
$email = $_POST['email'];
$name = $_POST['name'];
$phone_number = $_POST['phone_number'];
$title = $_POST['title'];
$price = $_POST['total'];
$menu = json_decode(stripslashes($_POST['menu']));
$count =  json_decode(stripslashes($_POST['count']));

$query_look = "INSERT INTO reservation_look(reservation_number, idnumber, reser_day, email, name, phone_number, title, price) VALUES ('$reservation_number', '$idnumber', '$reservation_day', '$email', '$name', '$phone_number', '$title', '$price')";
$check = 0;
if(!mysqli_query($con,$query_look)){
  $check = 0;
}else{
  for ($i=0; $i < count($menu); $i++) {
    $query_look_menu = "INSERT INTO reservation_menu(reservation_number, menu, menu_count) VALUES('$reservation_number', '$menu[$i]', '$count[$i]')";
    if(!mysqli_query($con,$query_look_menu)){
      $check = 0;
      break;
    }else{
      $query_menu_select = "SELECT number_sales FROM office_menu WHERE idnumber = '$idnumber' AND menu = '$menu[$i]';";
      $result_menu_select = mysqli_query($con,$query_menu_select);
      $row_menu_select = mysqli_fetch_assoc($result_menu_select);
      $number_sales = $row_menu_select['number_sales'];

      $count_array=$number_sales+$count[$i]; // change
      $query_sale = "UPDATE office_menu SET number_sales = '$count_array' WHERE idnumber = '$idnumber' AND menu = '$menu[$i]';";
      mysqli_query($con,$query_sale);
      $check = 1;
    }
  }
}
if($check){
  echo "결제가 완료되었습니다.";
}else{
  echo "쿼리문 오류 :".mysqli_error($con);
}
mysqli_close($con);
 ?>
