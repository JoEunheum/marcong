<?php
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$email = $_POST['email'];
$password = md5($_POST['password']);
$officenumber = $_POST['number'];
$title = $_POST['title'];
$subname = $_POST['subname'];
$introduce = $_POST['introduce'];
$day_week = $_POST['day_week']; //array
$open_time = $_POST['opentime'];
$close_time = $_POST['closetime'];
$today = $open_time.' ~ '.$close_time;
$homepage = $_POST['homepage'];
$address = $_POST['address'];
$workday='';
for ($i=0; $i < sizeof($day_week); $i++) {
 $workday=$workday.$day_week[$i].' ';
}

$query = "SELECT email from personal_info WHERE email='$email';";
$result = mysqli_query($con,$query);
$row = mysqli_num_rows($result);
$query_offi= "SELECT email from office_info WHERE email = '$email';";
$result_offi = mysqli_query($con, $query_offi);
$row_offi = mysqli_num_rows($result_offi);

if($row || $row_offi){
  ?>
 <script>
 alert('이미 존재하는 이메일입니다.');
 history.back();
 </script>
 <?php
}else{
  $query_office = "INSERT INTO office_info(email, password, office_number, name, subname, introduce, address, today, workday, homepage) VALUES('$email', '$password','$officenumber', '$title','$subname', '$introduce', '$address', '$today','$workday', '$homepage');";
  if(mysqli_query($con,$query_office)){
    ?>
    <script>
    alert('가입 되었습니다.');
    location.replace("./login.php");
    </script>
<?php
}else{
  echo mysqli_error($con);
}
mysqli_close($con);
}
 ?>
