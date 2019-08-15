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

$email = $_SESSION['email'];
$basket_key = $_GET['time_key'];

echo $basket_key;
$query_basket_info_del = "DELETE FROM basket_info WHERE basket_time = '$basket_key' AND email = '$email';";
if(!mysqli_query($con, $query_basket_info_del)){
  echo "error";
}
$query_basket_menu_del = "DELETE FROM basket_menu WHERE basket_time = '$basket_key';";
if(!mysqli_query($con, $query_basket_menu_del)){
  echo "error";
}
mysqli_close($con);
 ?>
