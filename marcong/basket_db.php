<?php
session_start();
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
// 메뉴 인덱스와, 수량을 가져옴.
$email = $_SESSION['email'];
$idnumber = $_GET['idnumber'];
$count = $_GET['cot'];
$menu_num = $_GET['menu_num'];

$query_basket = "SELECT basket_time FROM basket_info WHERE email = '$email' AND idnumber = '$idnumber';";
$result_basket = mysqli_query($con, $query_basket);
$row_basket = mysqli_fetch_assoc($result_basket);

if(count($row_basket) == 0){

  $query_info = "SELECT info.name, pic.image FROM office_info AS info JOIN office_picture AS pic ON info.idnumber = pic.idnumber WHERE info.idnumber = '$idnumber';";
  $result_info = mysqli_query($con, $query_info);
  if(!$row_info = mysqli_fetch_assoc($result_info)){
  }
  $name = $row_info['name'];
  $image = $row_info['image'];

  $date = date("Y-m-d");
  $time = date("H-i-s");
  $nextday = date("Y-m-d", strtotime("+1 day", strtotime($date))).' '.$time;
  
  $query_basket_info = "INSERT INTO basket_info(idnumber, basket_time, office_name, office_image, email) VALUES('$idnumber', '$nextday', '$name', '$image', '$email')";
  mysqli_query($con, $query_basket_info);

  $query_menu = "SELECT * FROM office_menu WHERE idnumber = '$idnumber';";
  $result_menu = mysqli_query($con, $query_menu);
  $i=0;
  while ($row_menu = mysqli_fetch_assoc($result_menu)) {
    $menu[$i] = $row_menu['menu'];
    $price[$i] = $row_menu['price'];
    $number[$i] = $row_menu['number_create'] - $row_menu['number_sales'];
    $i++;
  }

  $query_basket_menu = "INSERT INTO basket_menu(idnumber, basket_time, office_menu, office_price, office_count, count_max) VALUES('$idnumber', '$nextday', '$menu[$menu_num]', '$price[$menu_num]', '$count', '$number[$menu_num]')";

  mysqli_query($con, $query_basket_menu);
}else{

  $basket_time = $row_basket['basket_time'];
  $query_menu = "SELECT * FROM office_menu WHERE idnumber = '$idnumber';";
  $result_menu = mysqli_query($con, $query_menu);
  $i=0;
  while ($row_menu = mysqli_fetch_assoc($result_menu)) {
    $menu[$i] = $row_menu['menu'];
    $price[$i] = $row_menu['price'];
    $number[$i] = $row_menu['number_create'] - $row_menu['number_sales'];
    $i++;
  }

  $query_basket_menu = "SELECT office_menu, office_count FROM basket_menu WHERE idnumber = '$idnumber' AND basket_time='$basket_time';";
  $result_basket_menu = mysqli_query($con, $query_basket_menu);
  $i=0;
  $check = 0;
  while ($row_basket_menu = mysqli_fetch_assoc($result_basket_menu)) {
    $basket_menu[$i] = $row_basket_menu['office_menu'];
    $basket_count[$i] = $row_basket_menu['office_count'];
    if($menu[$menu_num] == $basket_menu[$i]){
      $basket_count[$i] += $count;

      $query_update = "UPDATE basket_menu SET office_count = '$basket_count[$i]' WHERE idnumber = '$idnumber' AND basket_time = '$basket_time' AND office_menu = '$basket_menu[$i]';";
      mysqli_query($con, $query_update);
      $check = 1;
      break;
    }else{
      $check = 0;
    }
    $i++;
  }
  if($check == 0){
    $query_basket_insert = "INSERT INTO basket_menu(idnumber, basket_time, office_menu, office_price, office_count, count_max) VALUES('$idnumber', '$basket_time', '$menu[$menu_num]', '$price[$menu_num]', '$count', '$number[$menu_num]')";
    mysqli_query($con, $query_basket_insert);
  }
}
mysqli_close($con);
 ?>
