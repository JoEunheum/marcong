<?php
session_start();
if(!isset($_SESSION['admin'])) {
	echo "<meta http-equiv='refresh' content='0;url=notice.php'>";
	exit;
}

$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$no = $_GET['no'];
// 이미지 삭제를 위한 쿼리
$query_image = "SELECT image_url FROM notice WHERE no= $no;";
$result_image = mysqli_query($con, $query_image);
$row = mysqli_fetch_assoc($result_image);

$title =$_POST['title'];
if($_POST['division']=="notice"){
  $division = "공지";
}else{
    $division = "이벤트";
}
$imageURL = $_POST['image'];
$writer = $_SESSION['name'];
$comment = $_POST['comment'];
$check = 1;

//file upload
$imagetype=substr(strrchr($_FILES['pic']['name'],'.'),1);
$imagename = date("YmdHis").'.'.$imagetype;
$imageerror = $_FILES['pic']['error'];
$imagetemp = $_FILES['pic']['tmp_name'];

// 저장할 장소
$imagePath = "board_img/";

    if(is_uploaded_file($imagetemp)) {
      if(move_uploaded_file($imagetemp, $imagePath . $imagename)) {
          // 성공했을 때
					if(!unlink($row['image_url'])){
					  ?>
					  <script>
					  alert("삭제에러!!");
					  history.back();
					  </script> <?php
					  mysqli_close($con);
					}else{
						$imageURL = $imagePath . $imagename;
	          $check =0;
					}
      }
      else {
        ?><script>
            alert('error');
            history.back();
        </script><?php
      }
  }else{
    $check =0;
  }
if($check==0){
  $query = "UPDATE notice SET title = '$title', division = '$division', image_url = '$imageURL', writer = '$writer', comment = '$comment'  WHERE no = $no;";
  if(mysqli_query($con, $query)){
    ?><script>
    alert("편집되었습니다.");
    location.replace("./notice.php?division=all")</script><?php
  }else{
    echo("쿼리오류 발생: " . mysqli_error($con));
  }
  mysqli_close($con);
}

?>
