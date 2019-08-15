<?php
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}

$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$idnumber = $_GET['id'];
$query_picture = "SELECT image FROM office_picture where idnumber = '$idnumber';";
$result = mysqli_query($con,$query_picture);
$i=0;
while($row = mysqli_fetch_assoc($result)){
  $imageURL[$i] = $row['image'];
  $i++;
}
$size = sizeof($imageURL);
for ($i=0; $i < $size; $i++) {

  if(!unlink($imageURL[$i])){
    ?>
    <script>
    alert('"삭제에러!!"');
    history.back();
    </script> <?php
    mysqli_close($con);
    break;
  }else{
    if($i==$size-1){
      $query_info = "DELETE FROM office_item WHERE idnumber = '$idnumber';";
      mysqli_query($con, $query_info);
      $query_menu = "DELETE FROM office_menu WHERE idnumber = '$idnumber';";
      mysqli_query($con, $query_menu);
      $query_picture = "DELETE FROM office_picture WHERE idnumber = '$idnumber';";
      mysqli_query($con, $query_picture);
      ?>
      <script>
      alert("삭제하였습니다.");
      location.replace("./store.php");
      </script> <?php
      mysqli_close($con);
    }
  }
}
 ?>
