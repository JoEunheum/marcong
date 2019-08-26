<?php
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$email = $_POST['email'];
$query_email = "SELECT email FROM personal_info WHERE email = '$email';";
$result_email = mysqli_query($con, $query_email);
$query_offi= "SELECT email from office_info WHERE email = '$email';";
$result_offi = mysqli_query($con, $query_offi);
$count = mysqli_num_rows($result_email) + mysqli_num_rows($result_offi);
echo $count;
mysqli_close($con);
 ?>
