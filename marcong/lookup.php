<?php
session_start();
if(!isset($_SESSION['email'])) {
	echo "<meta http-equiv='refresh' content='0;url=main.php'>";
	exit;
}else{
	$email = $_SESSION['email'];
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

$query_look = "SELECT reservation_number, reser_day, title, idnumber,  price, status FROM reservation_look WHERE email = '$email' ORDER BY reser_day DESC;";
$result_look = mysqli_query($con, $query_look);
$today = date("Y-m-d");

$i=0;
while($row_look = mysqli_fetch_assoc($result_look)){
	$reservation_number[$i] = $row_look['reservation_number'];
	$reservation_day[$i] = $row_look['reser_day'];
	$title[$i] = $row_look['title'];
	$idnumber[$i] = $row_look['idnumber'];
	$price[$i] = number_format($row_look['price']);
	$status[$i] = $row_look['status'];
	$timestamp = strtotime("$reservation_day[$i] +15 days");
	$timedate = date("Y-m-d", $timestamp);
	// $timedate = date("Y-m-d", $timestamp);
	echo $timedate;
	if($today > $reservation_day[$i]){
		//예약한 날로부터 다음날
		if($status[$i]=='O'){
			$query_status = "UPDATE reservation_look SET status = 'N' WHERE reservation_number = '$reservation_number[$i]';";
			mysqli_query($con,$query_status);
			$status[$i]='N';
		}
	}
$query_review = "SELECT grade, coment FROM review WHERE reservation_number = '$reservation_number[$i]';";
$result_review = mysqli_query($con, $query_review);
$row_review = mysqli_fetch_assoc($result_review);
$grade[$i] = $row_review['grade'];
$coment[$i] = $row_review['coment'];

	$i++;
}

mysqli_close($con);
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <title>마이페이지</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

			<style>

			.starR1{
		    background: url('./ico_review.png') no-repeat -104px 0;
		    background-size: auto 100%;
		    width: 30px;
		    height: 60px;
		    float:left;
				right:-19%;
				position: relative;
		    cursor: pointer;
			}
			.starR2{
    	background: url('./ico_review.png') no-repeat right 0;
	    background-size: auto 100%;
	    width: 30px;
	    height: 60px;
	    float:left;
			right:-19%;
			position: relative;
	    cursor: pointer;
		}
		.starR1.on{background-position: 0 0;}
		.starR2.on{background-position: -30px 0;}
</style>

 </head>
 <body>
   <header>
     <?php include "top.php" ?>
   </header>
   <div class="pull-right sticky-top">
     <?php include "sidemenu.php" ?>
   </div>

   <div id="div_look" class="container">
     <h3>예약조회</h3>
     <hr>

     <div class="row">
       <div class="col-sm-2">
         <ul class="list-group list-group-flush">
           <a href="./mypage.php" style="border: 0 none;" class="list-group-item list-group-item-action">개인정보변경</a>
           <a href="./wishlist.php" style="border: 0 none;" class="list-group-item list-group-item-action">관심상품</a>
           <a href="./lookup.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>예약조회</h5></a>
					 <a href="./secession.php" style="border: 0 none;" class="list-group-item list-group-item-action">회원탈퇴</a>
         </ul>
       </div>

				 <?php
				 if (count($reservation_number)==0) {
				 ?>
				    <div class="col text-center">
							<br>
	            <br>
	            <h4>예약 한 상품이 없습니다.</h4>
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
								<th>업체</th>
								<th>메뉴</th>
								<th>수량</th>
								<th>가격</th>
								<th>상태</th>
								<th>비고</th>
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
									 	<a href="store_item.php?id=<?php echo $idnumber[$i]; ?>"><p><?php echo $title[$i]; ?></p></a>
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
									 	<p><?php echo $price[$i]; ?> 원</p>
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
										}else if($status[$i]=='E' || $status[$i]=='W'){
											?>
											<p class="text-success">수령완료</p>
											<?php
										}else{
											?>
											<p class="text-danger">미수령</p>
											<?php
										}
										?>
									 </td>

									 <td width="15%" class="align-middle">
									 	<?php
										 if($today == $reservation_day[$i]){
											//예약한 날
											if($status[$i]=='O'){
												?>
												<button data-id="<?php echo $reservation_number[$i]; ?>" type="button" class="btn btn-success"name="receive">상품수령</button>
												<button data-id="<?php echo $reservation_number[$i]; ?>" type="button" class="btn btn-danger" name="cancle">예약취소</button>
												<?php
											}
										}else if($today < $reservation_day[$i]){
											//결제한 날(예약 전)
											if($status[$i]=='O'){
												?>
												<button data-id="<?php echo $reservation_number[$i]; ?>" type="button" class="btn btn-danger"name="cancle">예약취소</button>
												<?php
											}
										}

										if($status[$i] =='E'){
											?>
											<button data-id="<?php echo $reservation_number[$i]; ?>" data-office = "<?php echo $idnumber[$i]; ?>" type="button" class="btn btn-success" name="item_review">리뷰쓰기</button>
											<?php
										}

										if($status[$i] =='W'){
											?>
											<button data-id="<?php echo $reservation_number[$i]; ?>" data-office = "<?php echo $idnumber[$i]; ?>" data-grade ="<?php echo $grade[$i]; ?>" data-coment = "<?php echo $coment[$i]; ?>" class="btn btn-primary" type="button" name="item_edit">리뷰수정</button>
											<button data-id="<?php echo $reservation_number[$i]; ?>" data-office = "<?php echo $idnumber[$i]; ?>" class="btn btn-danger" type="button" name="item_del">리뷰삭제</button>
											<?php
										}

										if($status[$i] == 'N'){
											?>
											<button data-id="<?php echo $reservation_number[$i]; ?>" type="button" class="btn btn-success"name="receive">상품수령</button>
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

	 <!-- The Modal -->
<div class="modal fade" id="cancleModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

 <!-- Modal Header -->
 <div class="modal-header">
	 <h4>예약취소</h4>
	 <button type="button" class="close" data-dismiss="modal">&times;</button>
 </div>

 <!-- Modal body -->
 <div class="modal-body">
	 <p>예약날짜 기준 1일전 ---> <strong class="text-warning">100% 환불</strong></p>
	 <p>예약날짜 당일 ---> <strong class="text-warning">50% 환불</strong></p>
	 <p>예약날짜 기준 다음날 ---> <strong class="text-warning">0% 환불</strong></p>
</div>

 <!-- Modal footer -->
 <div class="modal-footer">
	 <input id="cancle" type="button" class="btn btn-danger" value="예약취소">
 </div>
</div>
</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="reviewModal">
<div class="modal-dialog">
<div class="modal-content">

<!-- Modal Header -->
<div class="modal-header">
<h4>리뷰작성</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
		<div class="starRev">
			<span id="s_0_5" data-grade = "0.5" class="starR1 on"></span>
			<span id="s_1_0" data-grade = "1.0" class="starR2 on"></span>
			<span id="s_1_5" data-grade = "1.5" class="starR1 on"></span>
			<span id="s_2_0" data-grade = "2.0" class="starR2 on"></span>
			<span id="s_2_5" data-grade = "2.5" class="starR1 on"></span>
			<span id="s_3_0" data-grade = "3.0" class="starR2 on"></span>
			<span id="s_3_5" data-grade = "3.5" class="starR1"></span>
			<span id="s_4_0" data-grade = "4.0" class="starR2"></span>
			<span id="s_4_5" data-grade = "4.5" class="starR1"></span>
			<span id="s_5_0" data-grade = "5.0" class="starR2"></span>
		</div>

		<textarea id="coment" class="ml-5 mt-4" name="coment" rows="4" placeholder="리뷰를 작성해주세요."></textarea>

</div>

<!-- Modal footer -->
<div class="modal-footer">
<input id="review" type="button" class="btn btn-primary" value="작성">
</div>
</div>
</div>
</div>


   <footer>
     <?php include "footer.php" ?>
   </footer>

<script>

		$('button').on("click", function(){
			var reservation_number = $(this).data('id');
			if(this.name == 'receive'){
				var receive_check = confirm('수령완료 하시겠습니까?');
				if(receive_check){
					$.ajax({
						type:"POST",
						url:"./lookup_db.php",
						data : {reservation_number : reservation_number, status : 'E'},
						success : function(data){
							alert(data);
							location.reload();
						},
						error : function(data){
							alert('error');
						}

					});
				}
			}else if(this.name == 'cancle'){

				$('#cancleModal').modal("show");
				$('#cancle').off().on('click', function(){
					var cancle_check = confirm('예약취소 하시겠습니까?');
					if(cancle_check){
						$.ajax({
							type:"POST",
							url:"./lookup_db.php",
							data : {reservation_number : reservation_number, status : 'X'},
							success : function(data){
								alert(data);
								location.reload();
							},
							error : function(data){
								alert('error');
							}

						});
					}
					$("#cancleModal").modal('hide');
				});

			}else if(this.name == 'item_review'){
				var idnumber = $(this).data('office');
				var grade=3.0;
					$('#reviewModal').modal("show");
					$('.starRev span').on('click', function(){
						grade=$(this).data('grade');
	  				$(this).parent().children('span').removeClass('on');
	  				$(this).addClass('on').prevAll('span').addClass('on');
	  				return false;
				});
				$('#review').off().on('click', function(){
					var coment = $('#coment').val();
					if(coment == ''){
						alert('리뷰를 작성해주세요.');
					}else{
						var review_check = confirm('리뷰를 올릴까요?');
						if(review_check){
							$.ajax({
								type:"POST",
								url:"./review.php",
								data : {reservation_number : reservation_number, idnumber : idnumber, coment : coment, grade : grade, status : 'W'},
								success : function(data){
									alert(data);
									location.reload();
								},
								error : function(data){
									alert('error');
								}
							});
						}else{
							return review_check;
						}
						$("#reviewModal").modal('hide');
					}
				});

			}else if(this.name == 'item_edit'){

				var idnumber = $(this).data('office');
				var coment = $(this).data('coment');
				var grade = $(this).data('grade');

				if(grade == 0.5){
					var span_name = 's_0_5';
				}else if(grade == 1.0){
					var span_name = 's_1_0';
				}else if(grade == 1.5){
					var span_name = 's_1_5';
				}else if(grade == 2.0){
					var span_name = 's_2_0';
				}else if(grade ==2.5){
					var span_name = 's_2_5';
				}else if(grade == 3.0){
					var span_name = 's_3_0';
				}else if(grade == 3.5){
					var span_name = 's_3_5';
				}else if(grade == 4.0){
					var span_name = 's_4_0';
				}else if(grade == 4.5){
					var span_name = 's_4_5';
				}else{
					var span_name = 's_5_0';
				}
				$('#reviewModal').modal("show");
				$('#coment').val(coment);
				$('.starRev span').parent().children('span').removeClass('on');
				$("#"+span_name).addClass('on').prevAll('span').addClass('on');
				$('.starRev span').on('click', function(){
					grade=$(this).data('grade');
					$(this).parent().children('span').removeClass('on');
					$(this).addClass('on').prevAll('span').addClass('on');
					return false;
			});

			$('#review').off().on('click', function(){
				coment = $('#coment').val();
				if(coment == ''){
					alert('리뷰를 작성해주세요.');
				}else{
					var review_check = confirm('리뷰를 수정할까요?');
					if(review_check){
						$.ajax({
							type:"POST",
							url:"./review_edit.php",
							data : {reservation_number : reservation_number, idnumber : idnumber, coment : coment, grade : grade},
							success : function(data){
								alert(data);
								location.reload();
							},
							error : function(data){
								alert('error');
							}
						});
					}else{
						return review_check;
					}
					$("#reviewModal").modal('hide');
				}
			});

			}else if(this.name == 'item_del'){
				var idnumber = $(this).data('office');
				var item_del_check = confirm('리뷰를 삭제하시겠습니까?');
				if(item_del_check){
					$.ajax({
						type:"POST",
						url:"./review_del.php",
						data : {reservation_number : reservation_number, status : 'E', idnumber : idnumber},
						success : function(data){
							alert(data);
							location.reload();
						},
						error : function(data){
							alert('error');
						}
					});
				}else{
					return item_del_check;
				}
			}


		});
</script>

 </body>
 </html>
