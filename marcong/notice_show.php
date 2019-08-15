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
$no = $_GET['no'];
$query_info = "select * from board where no = '$no'";
$result_set = mysqli_query($con, $query_info);
$row = mysqli_fetch_assoc($result_set);
$division = $row['division'];
$title = $row['title'];
$writer = $row['writer'];
$write_day = $row['write_day'];
$image_URL = $row['image_url'];
$look_up = $row['look_up'];
$comment = $row['comment'];

if(!isset($_COOKIE['notice_look'. $no])){
  $query_look = "UPDATE board SET look_up = '$look_up'+1 where no = '$no';";
  if(mysqli_query($con, $query_look)){
    setcookie('notice_look' . $no, TRUE, time()+(86400*30),'/');
    $look_up +=1;
  }else{
    alert(mysqli_error($con));
  }
}

$query = "select count(*) from board";
$result = mysqli_query($con,$query);
$row1 = mysqli_fetch_assoc($result);
$no_count= $row1['count(*)'];

if($no!=1){
  $no_pre = $no-1;
}
if($no!=$no_count){
  $no_next = $no+1;
}

// 이전글
$query_pre = "select * from board where no = '$no_pre'";
$result_pre = mysqli_query($con,$query_pre);
$row_pre = mysqli_fetch_assoc($result_pre);
$pre_title = $row_pre['title'];

// 다음글
$query_next = "select * from board where no = '$no_next'";
$result_next = mysqli_query($con,$query_next);
$row_next = mysqli_fetch_assoc($result_next);
$next_title = $row_next['title'];
mysqli_close($con);
 ?>

 <!DOCTYPE html>
 <html lang="ko">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
     <title>공지&이벤트</title>
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

    <div class="container">

      <hr>
      <div class="row">
        <div class="col-md-4">
          <h5><?php echo $division; ?> | <strong><?php echo $title; ?></strong></h5>
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <h6>작성자 <?php echo $writer; ?>  | 작성일자 <?php echo $write_day; ?>  | 조회 <?php echo $look_up; ?></h6>
        </div>

        <hr>
      </div>
      <div class="row">
        <div class="col">

          <hr>
        </div>
      </div>
    <?php
    if($image_URL!=""){
      ?><img class="img-fluid" src="<?php echo $image_URL; ?>" width="500" height="500"><?php
    }
     ?>

    <br>
    <br>
    <pre><?php echo $comment; ?></pre>
    <hr>

  <?php if($no!=1){
    ?>
    <div class="row">
      <div class="col-md-1">
        <h5 class="text-secondary">이전글</h5>
      </div>
      <div class="col">
        <a href="./notice_show.php?no=<?php echo $no-1; ?>"><h5><?php echo $pre_title; ?></h5></a>
      </div>
    </div>
    <hr><?php
  } ?>

<?php if($no!=$no_count){
  ?>
  <div class="row">
    <div class="col-md-1">
      <h5 class="text-secondary">다음글</h5>
    </div>
    <div class="col">
      <a href="./notice_show.php?no=<?php echo $no+1; ?>"><h5><?php echo $next_title; ?></h5></a>
    </div>
  </div>
  <hr><?php
} ?>

<input type="button" class="btn btn-success" onclick="javascript:location.href='notice.php?division=all'" value="목록"/>

<?php
session_start();
if(isset($_SESSION['admin'])){
?>
<input type="button" class="btn btn-secondary" id="edit" name="edit" value="편집"/>
<input type="button" class="btn btn-danger" id="delete" name="delete" value="삭제"/>
<?php
}
 ?>

    </div>
    <footer>
      <?php include "footer.php" ?>
    </footer>

    <script>
      // 편집
      $("#edit").click(function(){
        location.href='notice_edit.php?no=<?php echo $no; ?>';
      });

      // 삭제
      $("#delete").click(function(){
        var check_delete = confirm("정말로 삭제하시겠습니까?");
        if (check_delete) {
          location.href='notice_delete.php?no=<?php echo $no; ?>';
        }else{
          return check_delete;
        }
      });
    </script>
  </body>
  </html>
