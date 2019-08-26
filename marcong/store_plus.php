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

$listcount = $_POST['listcount'];
$sort = $_POST['sort'];
$today = date('Y-m-d');


if($sort == ''){
  $query_page = "SELECT * FROM office_item ORDER BY today_update DESC LIMIT $listcount, 12;";
}else{
  $query_page = "SELECT * FROM office_item ORDER BY $sort DESC LIMIT $listcount, 12;";
}
$result_page = mysqli_query($con, $query_page);
$count_page = mysqli_num_rows($result_page);
$sum = $count_page + $listcount;

$i=0;
while($row = mysqli_fetch_assoc($result_page)){
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

$html_first = "<div class='col-md-3'>
    <div class='card' style='width:250px;'>
        <h4 class='text-warning'><i class='fas fa-star'>$grade[$i]</i></h4>

        <img style='cursor:pointer' onclick='ope($idnumber[$i])' class='card-img-top img-thumbnail' src='$image[$i]' alt='Card image'>";
        if (strpos($today_update[$i], $today) !== false) {
          $html_new = "<div class='new-icon'>new</div>";
        }
        $html_middle = $html_new."<div class='card-body'>
          <a class='nounderline text-dark' href='store_item.php?id=$idnumber[$i]'><h4 class='card-title'>$name[$i]</h4></a>
          <p class='card-text text-secondary target'>$subname[$i]</p>
          <input id = 'plus_sum' type = 'hidden' value = '$sum'>
          <pre class='card-text text-secondary'><i class='fas fa-pencil-alt'> $review[$i]</i>  <i class='fas fa-heart'> $office_like[$i]</i>  <i class='fas fa-eye'>  $look_up[$i]</i></pre>
        </div>
      </div>
  </div>";
  $j = $i+1;
  if($j%4 == 0 && $j != $count_page){
    $html_end = "</div>
    <br>
    <div class='row'>";
  }
echo $html_first.$html_middle.$html_end;
$i++;
}

mysqli_close($con);
 ?>
