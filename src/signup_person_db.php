<?php
// Create connection
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$name = $_POST['name'];
$email =$_POST['email'];
$password = md5($_POST['password']);
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$birth = $year ."-". $month ."-". $day;
$number = $_POST['number'];
$query = "INSERT INTO personal_info(email,password,name,date_of_birth, phone_number) VALUES('$email','$password','$name','$birth','$number');";
  if (mysqli_query($con, $query)) {
      ?>  <script>
      alert('가입 되었습니다.');
      location.replace("./login.php");
      </script>
  <?php
  }else{
    echo mysqli_error($con);
  }
 mysqli_close($con);
?>
