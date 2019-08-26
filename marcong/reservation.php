<?php
session_start();
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];

$query_person = "SELECT phone_number FROM personal_info WHERE email = '$email';";
$result_person = mysqli_query($con, $query_person);
$row_person = mysqli_fetch_assoc($result_person);
$phone_number = $row_person['phone_number'];

$email_array = explode('@', $email);

$number_h = substr($phone_number, 0, 3);
$number_m = substr($phone_number, 3, 4);
$number_f = substr($phone_number, 7, 4);

$idnumber = $_POST['idnumber'];
$menulist = $_POST['menulist'];
$item_count = $_POST['selt'];
$total_price = $_POST['total'];

$query_menu = "SELECT menu, price FROM office_menu WHERE idnumber = '$idnumber';";
$result_menu = mysqli_query($con, $query_menu);
$i=0;
while($row_menu = mysqli_fetch_assoc($result_menu)){
  $menu[$i] = $row_menu['menu'];
  $price[$i] = number_format($row_menu['price']);
  $i++;
}
$query_info = "SELECT info.name, pic.image FROM office_info AS info JOIN office_picture AS pic ON info.idnumber = pic.idnumber WHERE info.idnumber = '$idnumber';";
$result_info = mysqli_query($con,$query_info);
$row_info = mysqli_fetch_assoc($result_info);
$title = $row_info['name'];
$image = $row_info['image'];


mysqli_close($con);
 ?>
 <!DOCTYPE html>
 <html lang="ko">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
     <title>예약</title>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

       <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>
       <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

    </head>
    <body>
      <header>
        <?php include "top.php" ?>
      </header>

      <div class="pull-right sticky-top">
        <?php include "sidemenu.php" ?>
      </div>

      <div class="container">
        <h3>예약&결제</h3>
        <hr>

        <table class="table table-bordered">
          <thead class="thead-light text-center">
            <tr>
              <th>업체</th>
              <th>예약 상품</th>
              <th>수량</th>
              <th>가격</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr>

              <td class="align-middle">
                <img src="<?php echo $image; ?>" style="width:100px; height:100px; cursor:pointer;" onclick="javascript:location.href= './store_item.php?id=<?php echo $idnumber; ?>' ">
                <p><?php echo $title; ?></p>
              </td>

              <td class="align-middle">
                <?php
                for ($i=0; $i < count($menulist); $i++) {
                  ?>
                  <input readonly class="text-center" type="text" name="menu[]" value="<?php echo $menu[$i]; ?>" style="width:150px; border:0 none;">
                  <input id="<?php echo $i ?>"readonly class="text-center" type="text" name="price[]" value="<?php echo $price[$i]; ?> 원" style="width:150px; border:0 none;">
                  <br>
                  <?php
                }
                 ?>
              </td>

              <td width="10%" class="align-middle">
                <?php
                for ($i=0; $i < count($menulist); $i++) {
                  ?>
                  <input readonly class="text-center" type="text" name="item_count[]" value="<?php echo $item_count[$i]; ?> 개" style="width:150px; border:0 none;">
                  <br>
                  <?php
                }
                 ?>
              </td>

              <td class="align-middle">
                <input id="total_price"readonly class="font-weight-bold text-center" type="text" name="total" value="<?php echo $total_price; ?> 원" style="width:150px; border:0 none;">
              </td>

            </tr>
          </tbody>

        </table>

        <br>

        <h4>예약자 정보</h4>
        <table class="table">
          <tbody>

            <tr>
              <td width="5%" class="bg-light align-middle">
                <h6 class="text-right">이 름</h6>
              </td>

              <td width="30%" class="align-middle">
                <input readonly type="text" name="person_name" value="<?php echo $name; ?>" style="width:150px; border:0 none;">
              </td>

              <td width="10%" class="bg-light align-middle">
                <h6 class="text-right">연락처</h6>
              </td>

              <td width="55%" class="align-middle">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <select class="" name="number_h" id="number_h">
                      <option value="choice">선택</option>
                      <option value="010">010</option>
                      <option value="011">011</option>
                      <option value="016">016</option>
                      <option value="017">017</option>
                      <option value="018">018</option>
                      <option value="019">019</option>
                    </select>
                  </div>
                  <h3> - </h3>
                  <input type="text" id="number_m" name="number_m" value="<?php echo $number_m; ?>" style="width:80px;">
                  <h3> - </h3>
                  <input type="text" id="number_f" name="number_f" value="<?php echo $number_f; ?>" style="width:80px;">
                </div>
              </td>
            </tr>

            <tr>
              <td class="bg-light align-middle">
                <h6 class="text-right">E-mail</h6>
              </td>

              <td colspan="4">
                <div class="input-group">
                  <input id="email_head" type="email" name="email_array[]" value="<?php echo $email_array[0]; ?>" style="width:200px;">
                  @
                  <div class="input-group-append">
                    <select id="email_f">
                      <option value="choice">선택</option>
                      <option value="naver.com">naver.com</option>
                      <option value="hotmail.com">hotmail.com</option>
                      <option value="hanmail.net">hanmail.net</option>
                      <option value="yahoo.co.kr">yahoo.co.kr</option>
                      <option value="nate.com">nate.com</option>
                      <option value="gmail.com">gmail.com</option>
                      <option value="direct">직접입력</option>
                    </select>
                  </div>
                  <input type="hidden" id="email_foot" name="email_array[]" style="width:200px;" value="<?php echo $email_array[1]; ?>">
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <hr>
        <h4 class="text-right">결제금액 : <input readonly class="text-right text-danger font-weight-bold" id="total" type="text" name="" value="<?php echo $total_price; ?>" style="width:150px; border:0 none;"> 원</h4>
        <hr>
        <div class="row">
          <div class="col">
          </div>

          <div class="col text-center">
            <form method="post" action="payment.php">
              <input type="hidden" name="reservation_number" id="reservation_number" value="">
              <input type="hidden" name="price_total" id="price_total" value="<?php echo $total_price; ?>">
              <button type="button" id="reservation_ok" class="btn btn-primary" name="button">결제하기</button>
              <button type="button" id="reservation_cencel" class="btn btn-secondary" name="button">예약취소</button>
            </form>
          </div>

          <div class="col">
          </div>
        </div>
      </div>
      <footer>
        <?php include "footer.php" ?>
      </footer>


      <script>
      function guid() {
        function s4() {
          return ((1 + Math.random()) * 10000 | 0);
        }
        return s4() + s4() + '-' + s4() + s4();
      }

      $("#reservation_ok").click(function(){
        var number_h = $("#number_h").val();
        var number_m = $("#number_m").val();
        var number_f = $("#number_f").val();
        var reservation_number = guid();
        $("#reservation_number").val(reservation_number);

        if (number_h == "choice" || number_m == "" || number_f == "") {
          alert("번호를 입력해주세요.");
          return false;
        }
        var email_head = $("#email_head").val();
        var email_foot = $("#email_foot").val();
        if(email_head == "" || email_foot == "" || email_foot == "choice"){
          alert("이메일을 입력해주세요.");
          return false;
        }
        var ok_check = confirm("결제하시겠습니까?");
        if(ok_check){
          var IMP = window.IMP; // 생략가능
          // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용
          IMP.init('imp73544034');
          IMP.request_pay({
            pg : 'kakaopay', // version 1.1.0부터 지원.
            pay_method : 'card',
            merchant_uid : reservation_number,
            name : '<?php echo $title; ?> 예약 결제',
            amount : '<?php echo $total_price; ?>',
            buyer_email : email_head+'@'+email_foot,
            buyer_name : '<?php echo $name; ?>',
            buyer_tel : number_h+'-'+number_m+'-'+number_f
            // buyer_addr : '서울특별시 강남구 삼성동',
            // buyer_postcode : '123-456',
          }, function(rsp) {
            if ( rsp.success ) {
              var menuString = JSON.stringify(<?php echo json_encode($menulist); ?>);
              var countString = JSON.stringify(<?php echo json_encode($item_count); ?>);
              $.ajax({
                  type:"POST",
                  url:"./reservation_db.php",
                  data : {email : email_head+"@"+email_foot, idnumber : <?php echo $idnumber; ?>, reservation_day : "<?php echo date('Y-m-d'); ?>", title : "<?php echo $title; ?>", total : rsp.paid_amount, phone_number : number_h+"-"+number_m+"-"+number_f,  menu : menuString, count : countString, reservation_number : rsp.merchant_uid, name : "<?php echo $name; ?>"},
                  success : function(data){
                    alert(data);
                    $("form").submit();
                  },
                  error : function(data){
                    alert('error');
                    return false;
                  }
                });
              // var msg = '결제가 완료되었습니다.';
              // msg += '고유ID : ' + rsp.imp_uid;
              // msg += '상점 거래ID : ' + rsp.merchant_uid;
              // msg += '결제 금액 : ' + rsp.paid_amount;
              // msg += '카드 승인번호 : ' + rsp.apply_num;
            } else {
              alert(rsp.error_msg);
              return false;
            }
          });
        }else{
          return ok_check;
        }
      });
      </script>

      <script>
        $("#reservation_cencel").click(function(){
          var cencel_check = confirm('예약을 취소하시겠습니까?');
          if(cencel_check){
            history.back();
          }else{
            return false;
          }
        });

          // var total_val = $("#total").val();
          // total_val = Number(total_val).toLocaleString('ko');
          // $("#total").val(total_val);
          // $("#total_price").val(total_val+" 원");

          var number_h = "<?php echo $number_h; ?>";
          $('#number_h').val(number_h).prop("selected", true);

          var email_f = "<?php echo $email_array[1]; ?>";
          $('#email_f').val(email_f).prop("selected",true);

          $('#email_foot').attr("type", "hidden");

          $(function(){
            $('#email_f').on('change',function(){
              $('#email_foot').val(this.value);
              if(this.value=="direct"){
                $('#email_foot').val("");
                $('#email_foot').attr("type", "text");
              }else{
                $('#email_foot').attr("type", "hidden");
              }
            });
          });
      </script>

    </body>
    </html>
