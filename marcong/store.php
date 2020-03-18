<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <title>마카롱</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
    .nounderline{
      text-decoration: none !important;
    }
    .new-icon {
    opacity: 0.9;
    transform: rotate(45deg);
    position: absolute;
    top: 5px;
    right: -28px;
    padding: 3px 0;
    width: 100px;
    text-align: center;
    color: #fff;
    font-weight: bold;
    background: #ff9501;
}

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

    <div class="container">
      <h3>마카롱</h3>
      <hr>

<div class="row">
  <div class="col">
    <?php
    if(isset($_SESSION['idnumber'])) {
      $num = $_SESSION['idnumber'];
    	?>
      <input type="button" class="btn btn-dark" value="올리기" onclick="upload(<?php echo $num;?>)">
      <?php
    }
     ?>

  </div>
  <div class="col-md-9">

  </div>
  <div class="col">
    <select class="custom-select" id="sort" name="sort">
      <option value="today_update">최신순</option>
      <option value="grade">평점순</option>
      <option value="look_up">조회순</option>
  </select>
  </div>
</div>
<br>

        <?php
        $servername = "localhost";
        $username = "heumheum2";
        $password = "password";
        $dbname = "heumDB";

        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $query_limit = "SELECT * FROM office_item;";
        $result_limit = mysqli_query($con, $query_limit);
        $total_count = mysqli_num_rows($result_limit);
        $listcount = 12;

        if(!isset($_GET['sort'])){
          $query = "SELECT * FROM office_item ORDER BY today_update DESC LIMIT 0, $listcount;";
        }else{
          $sort = $_GET['sort'];
          $query = "SELECT * FROM office_item ORDER BY $sort DESC LIMIT 0, $listcount;";
          ?>
          <script>
            $('#sort').val('<?php echo $sort; ?>');
          </script>
          <?php
        }
        $result_set = mysqli_query($con, $query);


        $i=0;
        while($row = mysqli_fetch_assoc($result_set)){
        $name[$i] = $row['name'];
        $subname[$i] =$row['subname'];
        $idnumber[$i] = $row['idnumber'];
        $grade[$i] = $row['grade'];
        $office_like[$i] = $row['office_like'];
        $look_up[$i]=$row['look_up'];
        $today_update[$i] = $row['today_update'];

        $query_picture = "SELECT image FROM office_picture WHERE idnumber = '$idnumber[$i]';";
        $result = mysqli_query($con, $query_picture);
        $row2 = mysqli_fetch_assoc($result);
        $image[$i] = $row2['image'];

        $query_review = "SELECT * FROM review WHERE idnumber = '$idnumber[$i]';";
        $result_review = mysqli_query($con, $query_review);
        $row_review = mysqli_num_rows($result_review);
        $review[$i] = $row_review;
        $i++;
      }
      $len = sizeof($name);
      $today = date('Y-m-d');
      ?>
      <div class="row">
        <?php
        for ($i=0; $i < $len; $i++) {
          ?>
          <div class="col-md-3">
              <div class="card" style="width:250px;">

                  <h4 class="text-warning"><i class="fas fa-star"> <?php echo $grade[$i]; ?></i></h4>

                  <img style="cursor:pointer" onclick="ope(<?php echo $idnumber[$i]; ?>)" class="card-img-top img-thumbnail" src="<?php echo $image[$i];?>" alt="Card image">
                  <?php
                  if (strpos($today_update[$i], $today) !== false) {
                    ?>
                    <div class="new-icon">new</div>
                    <?php
                  }
                   ?>

                  <div class="card-body">
                    <a class="nounderline text-dark" href="store_item.php?id=<?php echo $idnumber[$i]; ?>"><h4 class=" card-title"><?php echo $name[$i]; ?></h4></a>
                    <p class="card-text text-secondary target"><?php echo $subname[$i]; ?></p>
                    <pre class="card-text text-secondary"><i class="fas fa-pencil-alt"> <?php echo $review[$i]; ?></i>  <i class="fas fa-heart"> <?php echo $office_like[$i]; ?></i>  <i class="fas fa-eye"> <?php echo $look_up[$i]; ?></i></pre>
                  </div>
                </div>
            </div>
            <?php
            $j = $i+1;
            if($j%4 == 0 && $j != $len){
              ?>
            </div>
            <br>
            <div class="row">
            <?php
            }
        }
        mysqli_close($con);
        ?>
      </div>
      <br>
      <div id="plus_div" class="row">
      </div>
      <?php
      if($listcount < $total_count){
        ?>
        <div id="reset_div" class="row">
          <div class="col">
            <br>
            <input id="plus_value" type="hidden" value="<?php echo $listcount; ?>">
            <input id="sort_value" type="hidden" value="<?php echo $sort; ?>">
            <button id="plus_bt"class="btn btn-light btn-block">더보기</button>
          </div>
        </div>
        <?php
      }
      ?>

    </div>
    <footer>
      <?php include "footer.php" ?>
    </footer>

    <script>
    $("#plus_bt").click(function(){
      var listcount = Number($('#plus_value').val());
      var sort = $('#sort_value').val();
      $.ajax({
        type : "POST",
        url : "store_plus.php",
        data : {listcount : listcount, sort : sort},
        dataType : "text",
        success : function(data){
          listcount += 12;
          $('#plus_value').val(listcount);
          $('#plus_div').append(data);
          var plus_sum = $('#plus_sum').val();
          var total_count = <?php echo $total_count; ?>;
          if(total_count == plus_sum){
            $('#reset_div').empty();
          }
        },
        error : function(data){
          alert('error');
        }
      });
    });

    function upload(num){
      $.ajax({
        type:"GET",
        url: "./store_office.php",
        data : {idnumber : num},
        dataType:"text",
        success : function(data){
          if(data!=0){
            alert('한 개 이상 글을 올릴 수 없습니다.');
          }else{
            location.href='store_write.php';
          }
        },
        error : function(data){
          alert(data);
        }
      });
    }

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

      $('#sort').on("change", function(){
        var state = $(this).val();
        location.replace("store.php?sort="+state);
      });

    </script>
  </body>
  </html>
