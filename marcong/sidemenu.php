<?php
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if(isset($_COOKIE['todayview'])){
  $temp = explode(",",$_COOKIE['todayview']);
}
$today_view=array_reverse($temp);

for ($i=0; $i < sizeof($today_view); $i++) {
  $query_side_info = "SELECT name FROM office_info WHERE idnumber = '$today_view[$i]';";
  $result_side_info = mysqli_query($con, $query_side_info);
  $row_side_info = mysqli_fetch_assoc($result_side_info);
  $side_name[$i] = $row_side_info['name'];

  $query_side_pic = "SELECT image FROM office_picture WHERE idnumber= '$today_view[$i]';";
  $result_side_pic = mysqli_query($con,$query_side_pic);
  $row_side_pic = mysqli_fetch_assoc($result_side_pic);
  $side_image[$i] = $row_side_pic['image'];
}
mysqli_close($con);
 ?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
<style>
body {
  font-family: "Lato", sans-serif;
}
ul{

    list-style:none;

    list-style-type:none;

    }
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  right: 0;
  background-color: #FFF;
  overflow-x: hidden;
  transition: 0.5s;
  border:1px solid gray;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main{
  transition: margin-right .5s;
  padding:16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}

}
</style>
</head>
<body>

    <div id="main">
      <nav class="navbar justify-content-end">
        <ul>
          <li><button type="button" class="btn btn-secondary" onclick="openNav()" name="button">&#9664;</button></li>
          <li><button id="top_bt" type="button" name="button" class="btn btn-secondary">&#9650;</button></li>
          <li><button id="down_bt" type="button" name="button" class="btn btn-secondary">&#9660;</button></li>
        </ul>
      </nav>
      <input type="text" id="check_nav" value="0" hidden>
    </div>

<div id="mySidenav" class="sidenav">
  <h4 class="text-center">TODAY'S VIEW</h4>
  <h4 class="text-center">ㅡ</h4>
  <?php
  for ($i=0; $i < sizeof($today_view) ; $i++) {
    ?>
    <div class="card mx-auto" style="width:210px">
    <img class="card-img-top" src="<?php echo $side_image[$i]; ?>" alt="Card image" style="width:100%">
    <div class="card-body">
      <a href="store_item.php?id=<?php echo $today_view[$i]; ?>" class="card-title text-dark stretched-link"><?php echo $side_name[$i]; ?></a>
    </div>
  </div>
  <br>
    <?php
  }
   ?>

</div>

<script>
function openNav() {
  var check_nav = Number($("#check_nav").val());

  if(!check_nav){
    $("#mySidenav").css("width","250px");
    $("#main").css("marginRight","250px");
    $("#check_nav").val('1');
  }else{
    $("#mySidenav").css("width","0");
    $("#main").css("marginRight","0");
    $("#check_nav").val('0');
  }
}

  $("#top_bt").click(function(){
    $('html, body').animate({
      scrollTop:'0'
    },700);
  });


  $("#down_bt").click(function(){
    var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
    $('html,body').animate({
      scrollTop: scrollBottom
    },700);
  });

</script>

</body>
</html>
