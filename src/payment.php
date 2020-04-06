<?php
$reservation_number = $_POST['reservation_number'];
$price = $_POST['price_total'];
 ?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <title>예약완료</title>
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
      <h3>예약완료</h3>
      <hr>
      <br>
      <div class="row">
        <div class="col-sm-2">
        </div>

        <div class="col text-center">
          <i class="text-success far fa-check-circle display-1"></i>
          <h1 class="mt-3">예약이 성공적으로</h1><h1> 완료되었습니다.</h1>
          <br>
          <br>
           <h5>자세한 예약내역 확인은 예약조회에서 확인하실 수 있습니다.</h5>
           <br>
           <table class="table">
             <tbody>
               <tr class="text-center">
                 <td class="align-middle">
                   <br>
                   <h4>예약번호</h4>
                   <br>
                   <h4 class="text-warning"><?php echo $reservation_number; ?></h4>
                 </td>

                 <td>
                   <br>
                   <h4>예약금액</h4>
                   <br>
                   <h4 id="price"><?php echo $price; ?> 원</h4>
                 </td>

               </tr>
             </tbody>
           </table>
           <hr>
        </div>

        <div class="col-sm-2">
        </div>
      </div>

      <div class="row">
        <div class="col text-center">
          <button onclick="javascript:location.replace('./lookup.php')" type="button" class="btn btn-warning text-light font-weight-bold"name="button" style="width:300px; height:50px;">예약내역 확인하기</button>
        </div>
      </div>
    </div>
    <footer>
      <?php include "footer.php" ?>
    </footer>
  </body>
  </html>
