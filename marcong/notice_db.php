<?php
session_start();
if(!isset($_SESSION['admin'])) {
	echo "<meta http-equiv='refresh' content='0;url=notice.php'>";
	exit;
}

$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$title =$_POST['title'];
if($_POST['division']=="notice"){
  $division = "공지";
}else{
    $division = "이벤트";
}
$writer = $_SESSION['name'];
$comment = $_POST['comment'];
$imageURL ="";
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
          $imageURL = $imagePath . $imagename;
          $check =0;
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
  $query = "insert into notice (division, title, writer, write_day, image_url, comment) values";
  $query = $query."('$division','$title','$writer',now(),'$imageURL','$comment')";
  // 제목 중복 확인 하려면 프라이머리 키 설정해줘야함
  // $sql = "select count(*) from notice where title = '$title'";

  if(mysqli_query($con, $query)){
    ?>
		<script>
		alert("글을 올렸습니다.");
		location.replace("./notice.php?division=all");
	</script><?php
  }else{
    echo "쿼리오류 발생: ". mysqli_error($con);
  }
	mysqli_close($con);
}


?>
