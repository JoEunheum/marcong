<?php
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}else{
	$idnumber = $_SESSION['idnumber'];
}

$servername = "localhost";
$username = "heumheum2";
$password = "password";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
}

$query_look = "SELECT reservation_number, reser_day, name, phone_number, price, status FROM reservation_look WHERE idnumber = '$idnumber' ORDER BY reser_day DESC;";
$result_look = mysqli_query($con, $query_look);
$i=0;
while($row_look = mysqli_fetch_assoc($result_look)){
	$reservation_number[$i] = $row_look['reservation_number'];
	$reservation_day[$i] = $row_look['reser_day'];
	$name[$i] = $row_look['name'];
	$phone_number[$i] = $row_look['phone_number'];
	$price[$i] = number_format($row_look['price']);
	$status[$i] = $row_look['status'];
	$i++;
}
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <title>업체페이지</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 </head>
 <body>
   <header>
     <?php include "top.php" ?>
   </header>
   <div class="pull-right sticky-top">
     <?php include "sidemenu.php" ?>
   </div>

   <div id="div_look" class="container">
     <h3>예약확인</h3>
     <hr>

     <div class="row">
       <div class="col-sm-2">
         <ul class="list-group list-group-flush">
           <a href="./officepage_info.php" style="border: 0 none;" class="list-group-item list-group-item-action">업체정보수정</a>
           <a href="./officepage_menu.php" style="border: 0 none;" class="list-group-item list-group-item-action">마카롱</a>
           <a href="./officepage_lookup.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>예약확인</h5></a>
         </ul>
       </div>

			 <?php
			 if(count($reservation_number)==0){
				 ?>
				 <div class="col text-center">
					 <br>
					 <br>
					 <h4>예약 한 유저가 없습니다.</h4>
					 <br>
				 </div>
				 <script>
				 	$("#div_look").css("height","600px");
				 </script>
				 <?php
			 }else{
				 ?>
				 <div class="col">
					 <table class="table">
						 <thead class="thead-light text-center">
							 <tr>
							 	<th>예약번호</th>
								<th>예약날짜</th>
								<th>이름</th>
								<th>번호</th>
								<th>메뉴</th>
								<th>수량</th>
								<th>가격</th>
								<th>상태</th>
							 </tr>
						 </thead>
						 <tbody class="text-center">
							 <?php
							 $con = new mysqli($servername, $username, $password, $dbname);
							 if ($con->connect_error) {
							 		die("Connection failed: " . $con->connect_error);
							 }
							 for ($i=0; $i < count($reservation_number); $i++) {
								 $query_menu = "SELECT menu, menu_count FROM reservation_menu WHERE reservation_number = '$reservation_number[$i]';";
								 $result_menu = mysqli_query($con, $query_menu);
								 $j = 0;
								 unset($menu, $count);
								 while ($row_menu = mysqli_fetch_assoc($result_menu)) {
									 $menu[$j] = $row_menu['menu'];
									 $count[$j] = $row_menu['menu_count'];
									 $j++;
								 }
								 ?>
								 <tr>
									 <td class="align-middle">
									 	<p><?php echo $reservation_number[$i]; ?></p>
									 </td>

									 <td class="align-middle">
									 	<p><?php echo $reservation_day[$i]; ?></p>
									 </td>

									 <td class="align-middle">
									 	<p class="font-weight-bold"><?php echo $name[$i]; ?></p>
									 </td>

									 <td class="align-middle">
									 	<p><?php echo $phone_number[$i]; ?></p>
									 </td>

									 <td class="align-middle">
										<?php
										for ($j=0; $j < count($menu); $j++) {
											?>
											<p class="text-left"><?php echo $menu[$j]; ?></p>
											<?php
										}
										?>
									 </td>

									 <td class="align-middle">
										 <?php
	 									for ($j=0; $j < count($menu); $j++) {
	 										?>
	 										<p class="text-left"><?php echo $count[$j]; ?> 개</p>
	 										<?php
	 									}
	 									?>
									 </td>

									 <td class="align-middle">
									 	<p class="font-weight-bold"><?php echo $price[$i]; ?> 원</p>
									 </td>

									 <td class="align-middle">
									 	<?php
										if($status[$i]=='O'){
											?>
											<p class="text-primary">결제완료</p>
											<?php
										}else if($status[$i]=='X'){
											?>
											<p class="text-danger">예약취소</p>
											<?php
										}else{
											?>
											<p class="text-success">수령완료</p>
											<?php
										}
										?>
									 </td>
								 </tr>

								<?php
							 }
							  ?>

						 </tbody>
					 </table>
				 </div>
				 <?php
			 }
			  ?>
     </div>
   </div>

   <footer>
     <?php include "footer.php" ?>
   </footer>

 </body>
 </html>
