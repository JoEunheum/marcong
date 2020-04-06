<?php
session_start();
// Create connection
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$name = $_POST['name'];
$email =$_POST['email'];
$number = $_POST['number'];
if(isset($_POST['uid'])){
  $uid = $_POST['uid'];
  $query = "INSERT INTO personal_info (email, name, phone_number, uid) VALUES('$email', '$name', '$number', '$uid');";
    if (mysqli_query($con, $query)) {
      $_SESSION['email']=$email;
      $_SESSION['name']=$name;
      $_SESSION['uid'] = $uid;
        ?>  <script>
        alert('가입 되었습니다.');
        location.replace("./main.php");
        </script>
    <?php
  }else{
      echo mysqli_error($con);
    }
}else{
  $uid = $_POST['g_uid'];
  $query = "INSERT INTO personal_info (email, name, phone_number, g_uid) VALUES('$email', '$name', '$number', '$uid');";
    if (mysqli_query($con, $query)) {
      $_SESSION['email']=$email;
      $_SESSION['name']=$name;
      $_SESSION['uid'] = $uid;
        ?>  <script>
        alert('가입 되었습니다.');
        location.replace("./main.php");
        </script>
    <?php
  }else{
      echo mysqli_error($con);
    }
}
 mysqli_close($con);
?>
