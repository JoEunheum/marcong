<?php
session_start();
if(!isset($_SESSION['email'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");
$email = $_SESSION['email'];

$query_wish = "SELECT item_id FROM personal_wish WHERE email = '$email' AND like_check = 'Y';";
$result_wish = mysqli_query($con, $query_wish);
$i = 0;
while ($row_wish = mysqli_fetch_assoc($result_wish)) {
	$idnumber[$i] = $row_wish['item_id'];
	$i++;
}

if(count($idnumber)!=0){
	for ($i=0; $i < count($idnumber); $i++) {
		$query_menu = "SELECT name, subname, grade, office_like, look_up FROM office_item WHERE idnumber = '$idnumber[$i]';";
		$result_menu = mysqli_query($con,$query_menu);
		$row_menu = mysqli_fetch_assoc($result_menu);
		$name[$i] = $row_menu['name'];
		$subname[$i] = $row_menu['subname'];
	  $grade[$i] = $row_menu['grade'];
	  $office_like[$i] = $row_menu['office_like'];
		$look_up[$i] = $row_menu['look_up'];

		$query_pic = "SELECT image FROM office_picture WHERE idnumber = '$idnumber[$i]';";
		$result_pic = mysqli_query($con, $query_pic);
		$row_pic = mysqli_fetch_assoc($result_pic);
		$image[$i] = $row_pic['image'];
	}
	mysqli_close($con);
}
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
				.target {
					display: inline-block;
					width: 200px;
					white-space: nowrap;
					overflow: hidden;
					text-overflow: ellipsis;
				}
			</style>

 </head>
 <body>
   <header>
     <?php include "top.php" ?>
   </header>
   <div class="pull-right sticky-top">
     <?php include "sidemenu.php" ?>
   </div>

   <div class="container" style="height:600px;">
     <h3>관심상품</h3>
     <hr>

     <div class="row">
       <div class="col-sm-2">
         <ul class="list-group list-group-flush">
           <a href="./mypage.php" style="border: 0 none;" class="list-group-item list-group-item-action">개인정보변경</a>
           <a href="./wishlist.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>관심상품</h5></a>
           <a href="./lookup.php" style="border: 0 none;" class="list-group-item list-group-item-action">예약조회</a>
         </ul>
       </div>

				 <?php
         if(count($idnumber)==0){
           ?>
					 <div class="col text-center">
           <br>
           <br>
           <h4>좋아요 한 상품이 없습니다.</h4>
           <br>
					 </div>
           <?php
         }else{
					 for ($i=0; $i < count($idnumber); $i++) {
					 	?>
						<div class="col-sm-3">
						<div class="card" style="width:250px;">
                <h4 class="text-warning"><i class="fas fa-star"> <?php echo $grade[$i]; ?></i></h4>
                <img style="cursor:pointer" onclick="ope(<?php echo $idnumber[$i]; ?>)" class="card-img-top img-thumbnail" src="<?php echo $image[$i];?>" alt="Card image">
                <div class="card-body">
                  <a style="cursor:pointer" class="nounderline text-dark" onclick="ope(<?php echo $idnumber[$i]; ?>)"><h4 class=" card-title"><?php echo $name[$i]; ?></h4></a>
                  <p class="card-text text-secondary target"><?php echo $subname[$i]; ?></p>
                  <pre class="card-text text-secondary"><i class="fas fa-pencil-alt"> 0</i>  <i class="fas fa-heart"> <?php echo $office_like[$i]; ?></i>  <i class="fas fa-eye"> <?php echo $look_up[$i]; ?></i></pre>
                </div>
              </div>
							</div>
						<?php
					 }
         }
          ?>

     </div>
   </div>

   <footer>
     <?php include "footer.php" ?>
   </footer>

<script>
function ope(input){
  $.ajax({
    type:"GET",
    url: "./todayview.php",
    data : {idnumber : input},
    dataType:"text",
    success : function(data){
      location.href="store_item.php?id="+data;
    },
    error : function(data){
      alert(data);
    }
  });
}

</script>
 </body>
 </html>
