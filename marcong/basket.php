<?php
session_start();
$servername = "localhost";
$username = "heumheum2";
$password = "password";
$dbname = "heumDB";

$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$email = $_SESSION['email'];
$date = date("Y-m-d");
$query_time = "SELECT idnumber ,basket_time, office_image, office_name FROM basket_info WHERE email = '$email';";
$result_time = mysqli_query($con, $query_time);

$i = 0;
while ($row_time = mysqli_fetch_assoc($result_time)) {
  $basket_time[$i] = $row_time['basket_time'];

  if(strpos($basket_time[$i], $date) !== false){
    echo "data : ".$date.", basket_time : ".$basket_time[$i];
    $query_info_delete = "DELETE FROM basket_info WHERE basket_time = '$basket_time[$i]';";
    mysqli_query($con, $query_info_delete);
    $query_menu_delete = "DELETE FROM basket_menu WHERE basket_time = '$basket_time[$i]';";
    mysqli_query($con, $query_menu_delete);
    ?>
    <script>
      location.reload();
    </script>
    <?php
  }else{
    $basket_idnumber[$i] = $row_time['idnumber'];
    $basket_image[$i] = $row_time['office_image'];
    $basket_name[$i] = $row_time['office_name'];
    $i++;
  }
}
$time_size = sizeof($basket_time);
 ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>장바구니</title>
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

    <div id="div_basket" class="container">
      <h3>장바구니</h3>
      <hr>
    <?php
    if($time_size == 0){
      ?>
      <br>
      <br>
      <br>
      <h3 class="mt-5 text-center">장바구니 상품이 없습니다.</h3>
      <script>
        $('#div_basket').css("height", "500px");
      </script>
      <?php
    }else{
      ?>
      <table class="table">
    <thead class="thead-light text-center">
      <tr>
        <th>번호</th>
        <th>업체</th>
        <th>장바구니 상품</th>
        <th>수량</th>
        <th>가격</th>
        <th>주문</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php
      $con = new mysqli($servername, $username, $password, $dbname);
      if ($con->connect_error) {
          die("Connection failed: " . $con->connect_error);
      }

        for ($i=0; $i < $time_size; $i++) {
        $query_bas_time = "SELECT office_menu, office_price, office_count, count_max from basket_menu JOIN basket_info ON basket_menu.basket_time = basket_info.basket_time WHERE basket_info.email = '$email' AND basket_menu.basket_time = '$basket_time[$i]';";
        if(!$result_bas_time = mysqli_query($con, $query_bas_time)){
          echo("query error:" .mysqli_error($con));
        }
        $j=0;
        unset($basket_menu, $basket_price, $basket_count);
        while($row_bas_time = mysqli_fetch_assoc($result_bas_time)){
          $basket_menu[$j] = $row_bas_time['office_menu'];
          $basket_price[$j] =$row_bas_time['office_price'];
          $basket_count[$j] = $row_bas_time['office_count'];
          $basket_max[$j] = $row_bas_time['count_max'];
          $j++;
        }
        $menu_size=sizeof($basket_menu);
        ?>
        <tr>

          <td width="5%" class="align-middle">
            <p><?php echo $i+1; ?></p>
            </td>

            <td width="5%" class="align-middle">
              <img class="ml-4 float-left" src="<?php echo $basket_image[$i]; ?>" style="width:100px; height:100px; cursor:pointer;" onclick="imgclick(<?php echo $basket_idnumber[$i]; ?>)">

              <input class="text-center" readonly type="text" name="office_name[]" value="<?php echo $basket_name[$i]; ?>" style="width:150px; border:0 none;">
            </td>

          <form action="./reservation_basket.php" method="POST">

            <input type="hidden" name="image" value="<?php echo $basket_image[$i]; ?>">
            <input type="hidden" name="idnumber" value="<?php echo $basket_idnumber[$i]; ?>">
            <input type="hidden" name="title" value="<?php echo $basket_name[$i]; ?>">
            <input type="hidden" name="basket_time" value="<?php echo $basket_time[$i]; ?>">

          <td width="30%" class="align-middle">

            <?php
            for ($k=0; $k < $menu_size; $k++) {
              ?>
              <input readonly class="text-center" type="text" name="menu[]" value="<?php echo $basket_menu[$k]; ?>" style="width:150px; border:0 none;">
              <input id="<?php echo $i ?>"readonly class="text-center" type="text" name="price[]" value="<?php echo number_format($basket_price[$k]); ?> 원" style="width:150px; border:0 none;">
              <?php
            }
             ?>
          </td>

          <td width="5%" class="align-middle">
            <?php for ($k=0; $k < $menu_size; $k++) {
              ?>
              <input id="<?php echo $basket_menu[$k]; ?>" class="counter" type="number" min="0" max="<?php echo $basket_max[$k]; ?>" name="count[]" style="width:100px;" value="<?php echo $basket_count[$k]; ?>">
              <?php
            } ?>
          </td>

          <td class="align-middle">

              <?php
              unset($sum);
              for ($k=0; $k <$menu_size ; $k++) {
                $sum[$i]+=$basket_price[$k]*$basket_count[$k];
              } ?>
              <input class="text-center" readonly id="total<?php echo $i; ?>" type="text" name="total[]" value="<?php echo number_format($sum[$i]); ?> 원" style="width:150px; border:0 none;">

          </td>

          <td class="align-middle">
            <div class="btn-group-vertical">
                <button class="btn btn-success" id="<?php echo $basket_time[$i]; ?>" type="submit" name="reservation_bt">예약하기</button>
              </form>

              <button class="btn btn-danger" id="<?php echo $basket_time[$i]; ?>" onclick="dele(this.id)" type="button" name="del">삭제하기</button>
            </div>
          </td>

        </tr>
        <?php
      }
      ?>

    </tbody>
  </table>
  <script>
    $('#div_basket').css("height", "800px");
  </script>
      <?php
    }
    ?>
    </div>

    <footer>
      <?php include "footer.php" ?>
    </footer>

<script>
  function imgclick(num){
    location.href="store_item.php?id="+num;
  }

  function dele(id){
    var dele_check = confirm('해당 상품을 장바구니에서 삭제하시겠습니까?');
    if(dele_check){
      $.ajax({
        type:"GET",
        url:"./basket_delete.php",
        data:{time_key : id},
        dataType:"text",
        success : function(data){
          alert('삭제되었습니다.');
          location.reload();
        },
        error : function(data){
          alert('error'+data);
        }
      });
  }else{
    return dele_check;
  }
}

$("table tr").on("click", function(){
  var index = this.rowIndex-1;
  $(".counter").change(function(){
    var count = $(this).val(); // value = count
    var menu = $(this).attr('id'); // id = price
    $.ajax({
      type:"POST",
      url:"./basket_cal.php",
      data : {count : count, menu : menu, email : "<?php echo $email; ?>", index : index},
      success : function(data) {
        $('#total'+index).val(data+" 원");
      },
      error : function (data) {
        alert('error');
      }
    });
  });
});



</script>

</body>
</html>
