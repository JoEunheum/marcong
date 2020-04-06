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

$count = $_POST['count'];
$menu = $_POST['menu'];
$email = $_POST['email'];
$index = $_POST['index'];

$query_basket = "SELECT idnumber, basket_time FROM basket_info WHERE email = '$email';";
$result_basket = mysqli_query($con, $query_basket);
$i = 0;
while ($row_basket = mysqli_fetch_assoc($result_basket)) {
  $idnumber[$i] = $row_basket['idnumber'];
  $basket_time[$i]= $row_basket['basket_time'];
  $i++;
}

$query_basket_menu = "SELECT office_menu, office_price, office_count FROM basket_menu WHERE idnumber = '$idnumber[$index]' AND basket_time = '$basket_time[$index]';";
$result_basket_menu = mysqli_query($con, $query_basket_menu);
$i = 0;
$sum = 0;
while($row_basket_menu = mysqli_fetch_assoc($result_basket_menu)){
  $office_menu[$i] = $row_basket_menu['office_menu'];
  $office_price[$i] = $row_basket_menu['office_price'];
  $office_count[$i] = $row_basket_menu['office_count'];

  if(strpos($office_menu[$i], $menu) !== false){
    $query_update = "UPDATE basket_menu SET office_count = '$count' WHERE idnumber = '$idnumber[$index]' AND basket_time = '$basket_time[$index]' AND office_menu = '$office_menu[$i]';";
    if(!mysqli_query($con, $query_update)){
      echo mysqli_error($con);
      break;
    }else{
      $office_count[$i] = $count;
    }
  }
  $sum += $office_price[$i] * $office_count[$i];
  $i++;
}
echo number_format($sum);
mysqli_close($con);
 ?>
