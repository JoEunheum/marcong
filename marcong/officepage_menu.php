<?php
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}
$con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");
$idnumber = $_SESSION['idnumber'];
$query_menu = "SELECT name, subname, grade, office_like, look_up FROM office_item WHERE idnumber = '$idnumber';";
$result_menu = mysqli_query($con, $query_menu);
$row_menu = mysqli_fetch_assoc($result_menu);
if(count($row_menu)!=0){
  $name = $row_menu['name'];
  $subname = $row_menu['subname'];
  $grade = $row_menu['grade'];
  $office_like = $row_menu['office_like'];
  $look_up = $row_menu['look_up'];
  $query_pic = "SELECT image FROM office_picture WHERE idnumber = '$idnumber';";
  $result_pic = mysqli_query($con, $query_pic);
  $row_pic = mysqli_fetch_assoc($result_pic);
  $image = $row_pic['image'];
  $check=1;
  mysqli_close($con);
}else{
  $check = 0;
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

   <div class="container" style="height:500px;">
     <h3>마카롱</h3>
     <hr>

     <div class="row">
       <div class="col-sm-2">
         <ul class="list-group list-group-flush">
           <a href="./officepage_info.php" style="border: 0 none;" class="list-group-item list-group-item-action">업체정보수정</a>
           <a href="./officepage_menu.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>마카롱</h5></a>
           <a href="./officepage_lookup.php" style="border: 0 none;" class="list-group-item list-group-item-action">예약확인</a>
         </ul>
       </div>
       <div class="col-sm-3">
       </div>
       <div class="col">
         <?php
         if(!$check){
           ?>
           <br>
           <br>
           <h4>마카롱 등록을 해주세요.</h4>
           <br>
           <input type="button" class="btn btn-outline-success" onclick="item_write()" value="등록" style="width:250px;"/>
           <?php
         }else{
           ?>
           <div class="card" style="width:250px;">
               <h4 class="text-warning"><i class="fas fa-star"> <?php echo $grade; ?></i></h4>
               <img style="cursor:pointer" onclick="ope(<?php echo $idnumber; ?>)" class="card-img-top img-thumbnail" src="<?php echo $image;?>" alt="Card image">
               <div class="card-body">
                 <a style="cursor:pointer" class="nounderline text-dark" onclick="ope(<?php echo $idnumber; ?>)"><h4 class=" card-title"><?php echo $name; ?></h4></a>
                 <p class="card-text text-secondary target"><?php echo $subname; ?></p>
                 <pre class="card-text text-secondary"><i class="fas fa-pencil-alt"> 0</i>  <i class="fas fa-heart"> <?php echo $office_like; ?></i>  <i class="fas fa-eye"> <?php echo $look_up; ?></i></pre>
               </div>
             </div>
           <?php
         }
          ?>
       </div>

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

function item_write(){
  location.href="store_write.php";
}
</script>
 </body>
 </html>
