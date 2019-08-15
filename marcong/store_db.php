<?php
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}

$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");

$idnumber = $_SESSION['idnumber'];
$name = $_SESSION['name'];
$subname = $_SESSION['subname'];

$query_info= "INSERT INTO office_item(idnumber, name, subname) VALUES('$idnumber','$name','$subname');";
if(!mysqli_query($con, $query_info)){
	mysqli_close($con);
	?><script>
			alert('error');
			history.back();
	</script><?php
}

$menu = $_POST['menu'];
$price = $_POST['price'];
$number_create = $_POST['number_create'];
$cont = count($menu); //메뉴, 가격 개수

for ($i=0; $i < $cont; $i++) {
	$query_menu = "INSERT INTO office_menu(idnumber, menu, price, number_create) VALUES ('$idnumber','$menu[$i]','$price[$i]','$number_create[$i]');";

	if(!mysqli_query($con,$query_menu)){
		$query_info = "DELETE FROM office_item WHERE idnumber = '$idnumber';";
		mysqli_query($con,$query_info);
		mysqli_close($con);
		?>
		<script>
				alert('menu_error');
				history.back();
		</script>
		<?php
		break;
	}
}

$imagename = $_FILES['pic']['name'];
$imgcont = count($imagename); //이미지 개수
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
			$query_info = "DELETE FROM office_item WHERE idnumber = '$idnumber';";
			$query_menu = "DELETE FROM office_menu WHERE idnumber = '$idnumber';";
			mysqli_query($con,$query_info);
			mysqli_query($con,$query_menu);
			mysqli_close($con);
			break;
		}else {
			?>
			<script>
			alert("글을 올렸습니다.");
			location.replace("./store.php");
		</script><?php
		}
	}else{
		$query_info = "DELETE FROM office_item WHERE idnumber = '$idnumber';";
		$query_menu = "DELETE FROM office_menu WHERE idnumber = '$idnumber';";
		mysqli_query($con,$query_info);
		mysqli_query($con,$query_menu);
		mysqli_close($con);
		break;
	}
}
mysqli_close($con);
 ?>
