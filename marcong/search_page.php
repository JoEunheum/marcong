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

$serch = $_GET['search'];
$serch = str_replace(' ','',$serch);

if($serch == ''){
  $count_office = 0;
  $count_menu = 0;
  $count_board = 0;
}else{
  $query_office = "SELECT idnumber, name, subname FROM office_info WHERE replace(name, ' ', '') LIKE '%$serch%' OR replace(subname, ' ', '') LIKE '%$serch%' OR replace(workday, ' ', '') LIKE '%$serch%' OR replace(address, ' ', '') LIKE '%$serch%';";
  $result_office = mysqli_query($con, $query_office);
  $count_office = mysqli_num_rows($result_office);
  echo 'office : '.$count_office.', '; //delete
  if($count_office != 0){
    $i=0;
    while($row_office = mysqli_fetch_assoc($result_office)){
      $idnumber[$i] = $row_office['idnumber'];
      $title[$i] = $row_office['name'];
      $subname[$i] = $row_office['subname'];
      $query_item = "SELECT off.grade, off.office_like, off.look_up, pic.image FROM office_item AS off LEFT OUTER JOIN office_picture as pic ON off.idnumber = pic.idnumber WHERE off.idnumber = '$idnumber[$i]';";
      $result_item = mysqli_query($con, $query_item);
      $row_item = mysqli_fetch_assoc($result_item);
      $grade[$i] = $row_item['grade'];
      $office_like[$i] = $row_item['office_like'];
      $look_up[$i] = $row_item['look_up'];
      $image[$i] = $row_item['image'];
      $query_review = "SELECT * FROM review WHERE idnumber = '$idnumber[$i]';";
      $result_review = mysqli_query($con, $query_review);
      $count_review[$i] = mysqli_num_rows($result_review);
      $i++;
    }
  }else{
    $query_menu = "SELECT idnumber FROM office_menu WHERE replace(menu, ' ', '') like '%$serch%';";
    $result_menu = mysqli_query($con, $query_menu);
    $count_menu = mysqli_num_rows($result_menu);
    echo 'menu : '.$count_menu.', '; //delete
    $i = 0;
    while($row_menu = mysqli_fetch_assoc($result_menu)){
      $idnumber[$i] = $row_menu['idnumber'];
      $query_item = "SELECT off.name, off.subname, off.grade, off.office_like, off.look_up, pic.image FROM office_item AS off LEFT OUTER JOIN office_picture as pic ON off.idnumber = pic.idnumber WHERE off.idnumber = '$idnumber[$i]';";
      $result_item = mysqli_query($con, $query_item);
      $row_item = mysqli_fetch_assoc($result_item);
      $title[$i] = $row_item['name'];
      $subname[$i] = $row_item['subname'];
      $grade[$i] = $row_item['grade'];
      $office_like[$i] = $row_item['office_like'];
      $look_up[$i] = $row_item['look_up'];
      $image[$i] = $row_item['image'];
      $query_review = "SELECT * FROM review WHERE idnumber = '$idnumber[$i]';";
      $result_review = mysqli_query($con, $query_review);
      $count_review[$i] = mysqli_num_rows($result_review);
      $i++;
    }
  }

  $query_board = "SELECT * FROM board WHERE division LIKE '%$serch%' OR replace(title, ' ', '') LIKE '%$serch%';";
  $result_board = mysqli_query($con, $query_board);
  $count_board = mysqli_num_rows($result_board);
  echo 'board : '.$count_board; //delete
  $i=0;
  while ($row_board = mysqli_fetch_assoc($result_board)) {
    $division[$i] = $row_board['division'];
    $name[$i] = $row_board['title'];

  }
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
  <title>검색</title>
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


  <div id="height_div" class="container">
    <?php
    if ($count_office == 0 && $count_menu == 0 && $count_board == 0) {
      ?>
      <hr>
      <br>
      <br>
      <h3 class="mt-5 text-center">검색결과가 없습니다.</h3>
      <br>
      <script>
        $('#height_div').css("height", "500px");
      </script>
      <?php
    }else if($count_office != 0 && $count_board ==0){
      ?>
      <h3>마카롱(<?php echo $count_office; ?>)</h3>
      <hr>
      <div class="row">
        <?php
        for ($i=0; $i < $count_office; $i++) {
          ?>
          <div id="re_set" class="col-md-3">
              <div class="card" style="width:250px;">

                  <h4 class="text-warning"><i class="fas fa-star"> <?php echo $grade[$i]; ?></i></h4>

                  <img style="cursor:pointer" onclick="ope(<?php echo $idnumber[$i]; ?>)" class="card-img-top img-thumbnail" src="<?php echo $image[$i];?>" alt="Card image">

                  <div class="card-body">
                    <a class="nounderline text-dark" href="store_item.php?id=<?php echo $idnumber[$i]; ?>"><h4 class=" card-title"><?php echo $title[$i]; ?></h4></a>
                    <p class="card-text text-secondary target"><?php echo $subname[$i]; ?></p>
                    <pre class="card-text text-secondary"><i class="fas fa-pencil-alt"> <?php echo $count_review[$i]; ?></i>  <i class="fas fa-heart"> <?php echo $office_like[$i]; ?></i>  <i class="fas fa-eye"> <?php echo $look_up[$i]; ?></i></pre>
                  </div>
                </div>
            </div>
          <?php
        }
         ?>
      </div>
      <?php

    }else if($count_menu !=0 && $count_board ==0){
      ?>
      <h3>마카롱(<?php echo $count_menu; ?>)</h3>
      <hr>
      <div class="row">
        <?php
        for ($i=0; $i < $count_menu; $i++) {
          ?>
          <div id="re_set" class="col-md-3">
              <div class="card" style="width:250px;">

                  <h4 class="text-warning"><i class="fas fa-star"> <?php echo $grade[$i]; ?></i></h4>

                  <img style="cursor:pointer" onclick="ope(<?php echo $idnumber[$i]; ?>)" class="card-img-top img-thumbnail" src="<?php echo $image[$i];?>" alt="Card image">

                  <div class="card-body">
                    <a class="nounderline text-dark" href="store_item.php?id=<?php echo $idnumber[$i]; ?>"><h4 class=" card-title"><?php echo $title[$i]; ?></h4></a>
                    <p class="card-text text-secondary target"><?php echo $subname[$i]; ?></p>
                    <pre class="card-text text-secondary"><i class="fas fa-pencil-alt"> <?php echo $count_review[$i]; ?></i>  <i class="fas fa-heart"> <?php echo $office_like[$i]; ?></i>  <i class="fas fa-eye"> <?php echo $look_up[$i]; ?></i></pre>
                  </div>
                </div>
            </div>
          <?php
        }
         ?>
      </div>
      <?php

    }else if($count_board !=0 && $count_office == 0 && $count_menu == 0){
      ?>
      <h3>공지&이벤트(<?php echo $count_board; ?>)</h3>
      <hr>

      <?php
    }
     ?>
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
