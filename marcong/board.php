<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>FAQ</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
  .accordion {
/* background-color: #eee;
color: #444; */
background-color: #FFF;
font-weight: bold;
cursor: pointer;
padding: 18px;
width: 100%;
border: none;
text-align: left;
outline: none;
font-size: 15px;
transition: 0.4s;
}

.active, .accordion:hover {
background-color: #ccc;
}

.accordion:after {
content: '\002B';
color: #FF4500;
font-weight: bold;
float: right;
margin-left: 5px;
}

.active:after {
content: "\2212";
}

.panel {
padding: 0 18px;
background-color: white;
max-height: 0;
overflow: hidden;
transition: max-height 0.2s ease-out;
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

    <div class="container" style="height : 700px;">
      <h3>자주 묻는 질문</h3>
      <hr>
      <button class="accordion">Q. 말콩은 어떤 서비스인가요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 마카롱 예약을 도와주는 서비스입니다.</p>
      </div>

      <button class="accordion">Q. 구글이나 카카오로그인 할때 다른 계정으로 로그인 하고 싶어요.</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 인터넷 옵션에서 쿠키 삭제를 하시면 다른계정으로 로그인 하실 수 있습니다.</p>
      </div>

      <button class="accordion">Q. 주문 취소했는데 언제 환불이 되나요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 주문취소로 인한 환불처리는 취소완료 후 환불처리가 진행되며, 결제수단별 환불소요 기간은 아래와 같습니다.
        </P>

        <p style="text-indent : 30px;">결제수단이 신용카드인 경우 취소완료일부터 1~2일 후 카드 승인취소가 이루어지며 환불 금액은 신용카드 특성상 다음달 환불됩니다.
        </p>

        <p style="text-indent : 30px;">결제수단이 실시간계좌이체나 무통장입금의 경우 취소완료시 본인의 환불계좌로 입금됩니다.
        </p>
      </div>

      <button class="accordion">Q. 특정한 날 예약이 가능한가요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 저희 말콩은 다음날 예약만 가능합니다. 따라서 특정한 날 예약이 어렵습니다.</p>
      </div>
      <button class="accordion">Q. 배송은 왜 안하나요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 마카롱의 품질을 위해 배송은 서비스 하지 않습니다.</p>
      </div>
      <button class="accordion">Q. 마카롱 유통기한은 얼마나 되나요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 권장 유통기한은 실온/냉장 보관시 수령후 4일이내. 수령즉시 냉동 보관시 3개월 입니다.</p>
        <p style="text-indent : 30px;"> 냉동보관시 실온에 20분 이상 녹인 후, 드시면 냉동전 상태의 깊은 맛을 그대로 느끼실 수 있습니다.</p>
      </div>
      <button class="accordion">Q. 마이페이지는 뭔가요?</button>
      <div class="panel">
        <p style="text-indent : 15px">A. 마이페이지는 나의 정보 수정 및 관심상품과 마카롱예약을 확인 할 수 있습니다.</p>
      </div>
      <button class="accordion">Q. 마이페이지에서 관심상품이 뭔가요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 마음에 드는 마카롱 업체를 카드로 저장하여 관리할 수 있는 메뉴입니다.</p>
        <p style="text-indent : 30px;">좋아하는 업체를 좋아요를 눌러 편하게 찾을 수 있습니다.</p>
      </div>
      <button class="accordion">Q. 회원탈퇴를 하고 싶어요.</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 회원 탈퇴는 말콩 웹페이지 (localhost/marcong/main.php)에서 가능합니다.</p>
        <p style="text-indent : 30px;">가입하신 계정으로 로그인하신 후 마이페이지 > 탈퇴하기 메뉴를 이용하세요. </p>
      </div>
      <button class="accordion">Q. 서비스를 이용하면서 궁금한 점은 어디에 물어보나요?</button>
      <div class="panel">
        <p style="text-indent : 15px;">A. 070-2222-1111로 연락주시면 친절히 답해드리겠습니다. ^^</p>
      </div>

    </div>

    <footer>  <?php include "footer.php" ?></footer>

    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight){
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
    }
    </script>
  </body>

  </html>
