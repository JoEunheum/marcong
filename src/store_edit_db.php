<?php
session_start();
session_cache_expire(1800);
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$idnumber = $_GET['id'];

$menu = $_POST['menu'];
$price = $_POST['price'];
$number_create = $_POST['number_create'];
$size_menu = count($menu);

// DELETE MENU
$query_menu = "DELETE FROM office_menu WHERE idnumber = '$idnumber';";
mysqli_query($con,$query_menu);

// EDIT MENU
for ($i=0; $i < $size_menu; $i++) {
  $query_menu = "INSERT INTO office_menu(idnumber, menu, price, number_create) VALUES('$idnumber','$menu[$i]','$price[$i]','$number_create[$i]');";
  mysqli_query($con,$query_menu);
}
$query_item = "UPDATE office_item SET today_update = now() WHERE idnumber = '$idnumber';";
if(isset($_POST['imagename'])){
	mysqli_query($con,$query_item);
  ?>
  <script>
  alert("편집 되었습니다.");
  location.replace("./store.php?id=<?php echo $idnumber;?>");
</script><?php
}else{
  //DELETE IMAGE
  $query_pic = "SELECT image FROM office_picture WHERE idnumber = '$idnumber';";
  $result_pic = mysqli_query($con, $query_pic);
  $i = 0;
  while($row_pic = mysqli_fetch_assoc($result_pic)){
    $imageURL[$i] = $row_pic['image'];
    $i++;
  }
  $size_pic = count($imageURL);
  for ($i=0; $i < $size_pic; $i++) {
    unlink($imageURL[$i]);
  }

//DELETE QUERY
$query_picture = "DELETE FROM office_picture WHERE idnumber = '$idnumber';";
mysqli_query($con, $query_picture);

//INSERT IMAGE
  $imagename = $_FILES['pic']['name'];
  $imgcont = count($imagename);
  $imageURL = array();
  for ($i=0; $i <$imgcont ; $i++) {
    $imagetype[$i]=substr(strrchr($imagename[$i],'.'),1);
  	$imagename[$i] = date("YmdHis").$i.'.'.$imagetype[$i];
  	$imageURL[$i]="";
  }
  $imageerror = $_FILES['pic']['error'];
  $imagetemp = $_FILES['pic']['tmp_name'];
  $imagePath = "store_img/";

  for ($i=0; $i < $imgcont; $i++) {
  	$check =0;
  	if(is_uploaded_file($imagetemp[$i])){
  		if(move_uploaded_file($imagetemp[$i], $imagePath . $imagename[$i])) {
  			$imageURL[$i] = $imagePath . $imagename[$i];
  			$check = 1;
  		}
  		else {
  			?><script>
            alert('<?php echo $imageerror[$i];?>');
            history.back();
        </script><?php
  	  	$check=0;
  		}

  	}else{
  		?><script>
          alert('최소 한 개 이상의 이미지를 넣어주세요.'); //아마 자바스크립트에서 막아놔서 이건 안뜰듯
          history.back();
      </script><?php
      $check=0;
  	}

  	if($check){
  		$query_picture = "INSERT INTO office_picture(idnumber, image) VALUES('$idnumber','$imageURL[$i]');";
  		if(!mysqli_query($con,$query_picture)){
  			echo("쿼리오류 발생: " . mysqli_error($con));
  			$query_menu = "DELETE FROM office_menu WHERE idnumber = '$idnumber';";
  			mysqli_query($con,$query_menu);
  			mysqli_close($con);
  			break;
  		}else {
        if($i==$imgcont-1){
					mysqli_query($con,$query_item);
    			?>
    			<script>
    			alert("편집 되었습니다.");
    			location.replace("./store.php?id=<?php echo $idnumber;?>");
    		</script><?php
				mysqli_close($con);
        }
  		}
  	}else{
  		$query_menu = "DELETE FROM office_menu WHERE idnumber = '$idnumber';";
  		mysqli_query($con,$query_menu);
  		mysqli_close($con);
  		break;
  	}
  }
}



 ?>
