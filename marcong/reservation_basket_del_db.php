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

$email = $_POST['email'];
$idnumber = $_POST['idnumber'];
$basket_time = $_POST['basket_time'];

$query_info_delete = "DELETE FROM basket_info WHERE email = '$email' AND idnumber = '$idnumber' AND basket_time = '$basket_time';";
mysqli_query($con, $query_info_delete);

$query_menu_delete = "DELETE FROM basket_menu WHERE idnumber = '$idnumber' AND basket_time = '$basket_time';";
mysqli_query($con, $query_menu_delete);
 ?>
