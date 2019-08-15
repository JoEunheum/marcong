<?php
session_start();
if(!isset($_SESSION['admin'])) {
	echo "<meta http-equiv='refresh' content='0;url=notice.php'>";
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
$no = $_GET['no'];
$query_info = "select image_url from board where no = '$no'";
$result_set = mysqli_query($con, $query_info);
$row = mysqli_fetch_assoc($result_set);

$imageURL = $row['image_url'];

if($imageURL){
	if(!unlink($imageURL)){
	  ?>
	  <script>
	  alert('"삭제에러!!"');
	  history.back();
	  </script> <?php
	  mysqli_close($con);
	}else{
	  $query_delete = "delete from board where no= '$no';";
	  $result_delete = mysqli_query($con,$query_delete);
	  $query_increment = "alter table board auto_increment=1;";
	  $result_increment = mysqli_query($con,$query_increment);
	  ?>
	  <script>
	  alert("삭제하였습니다.");
	  location.replace("./notice.php?division=all");

	  </script> <?php
	  mysqli_close($con);
	}
}else{
	$query_delete = "delete from board where no= '$no';";
	mysqli_query($con,$query_delete);
	$query_increment = "alter table board auto_increment=1;";
	mysqli_query($con,$query_increment);
	?>
	<script>
	alert("삭제하였습니다.");
	location.replace("./notice.php?division=all");

	</script> <?php
	mysqli_close($con);
}


?>
