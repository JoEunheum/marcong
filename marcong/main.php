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

$query_item = "SELECT * FROM office_item ORDER BY grade DESC LIMIT 3;";
$result_item = mysqli_query($con, $query_item);

$i=0;
while ($row = mysqli_fetch_assoc($result_item)) {
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
$len = mysqli_num_rows($result_item);
mysqli_close($con);

 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>말콩</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet"type="text/css" href="mainslider.css">

<style>

.nounderline{
  text-decoration: none !important;
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

    <div class="container-fluid" style="height : 1000px;">
      <div class="row">
        <div class="col">
        </div>
        <div class="col">

          <div id="slider-wrap">
            <ul id="slider">
              <li>
                <img class="img-responsive" src="./marc_img/marcong1.jpg">
              </li>

              <li>
                <img class="img-responsive" src="./marc_img/marcong2.jpg">
              </li>

              <li>
                <img class="img-responsive" src="./marc_img/marcong3.png">
              </li>
            </ul>

            <div class="slider-btns" id="next"><span>▶</span></div>
            <div class="slider-btns" id="previous"><span>◀</span></div>

            <div id="slider-pagination-wrap">
              <ul>
              </ul>
            </div>
          </div>

          <br>
          <br>
          <br>
          <div class="d-flex justify-content-between">
            <h3>마카롱(평점순)</h3>
            <a class="nounderline mt-2" href="./store.php"><h6>더보기 +</h6></a>
          </div>
          <hr>
          <div class="container">
            <div class="row">
              <?php
                for ($i=0; $i < $len; $i++) {
                  ?>
                  <div id="re_set" class="col-md-4">
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
                }
               ?>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="sticky-top">
            <?php include "sidemenu.php" ?>
          </div>
        </div>
      </div>

  </div>
  <footer>
    <?php include "footer.php" ?>
  </footer>

    <script type="text/javascript" src="mainslider.js">
    </script>

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
