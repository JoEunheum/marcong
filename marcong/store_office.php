<?php
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$idnumber = $_GET['idnumber'];

$query_item = "SELECT idnumber FROM office_menu WHERE idnumber = '$idnumber';";
$result_item = mysqli_query($con, $query_item);
$row_item = mysqli_num_rows($result_item);
echo $row_item;
 ?>
