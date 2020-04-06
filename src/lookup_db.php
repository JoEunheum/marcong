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

$reservation_number = $_POST['reservation_number'];
$status = $_POST['status'];

$query_look = "UPDATE reservation_look SET status = '$status' WHERE reservation_number = '$reservation_number';";
if(!mysqli_query($con, $query_look)){
  echo mysqli_error($con);
}else{
  if($status == 'E'){
    echo "완료하였습니다.";
  }else{ //status == X
    $query_cancel = "SELECT look.idnumber, menu.menu, menu.menu_count FROM reservation_look AS look JOIN reservation_menu AS menu ON look.reservation_number = menu.reservation_number WHERE look.reservation_number = '$reservation_number';";

    $result_cancel = mysqli_query($con, $query_cancel);
    $i = 0;
    while ($row_cancel = mysqli_fetch_assoc($result_cancel)) {
      $idnumber = $row_cancel['idnumber'];
      $reservation_menu[$i] = $row_cancel['menu'];
      $reservation_count[$i] = $row_cancel['menu_count'];
      $i++;
    }
    $query_office = "SELECT menu, number_sales FROM office_menu WHERE idnumber = '$idnumber';";
    $result_office = mysqli_query($con, $query_office);
    $i=0;
    $check = 0;
    while ($row_office = mysqli_fetch_assoc($result_office)) {
      $office_menu[$i] = $row_office['menu'];
      $office_count[$i] = $row_office['number_sales'];
      for ($j=0; $j < count($reservation_menu); $j++) {
        if(strpos($office_menu[$i], $reservation_menu[$j]) !== false){
          $office_count[$i] -= $reservation_count[$j];
          $query_update = "UPDATE office_menu SET number_sales = '$office_count[$i]' WHERE idnumber = '$idnumber' AND menu = '$office_menu[$i]';";
          if(!mysqli_query($con,$query_update)){
            $check = 0;
            break;
          }else{
            $check = 1;
          }
        }
      }
      $i++;
    }
    if($check){
      echo "취소되었습니다.";
    }else{
      echo mysqli_error($con);
    }
  }
}
 ?>
