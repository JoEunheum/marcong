<?php
session_start();
$servername = "localhost";
$username = "heumheum2";
$password = "password";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$idnumber = $_GET['id'];
$query_week = "SELECT DAYNAME(CURDATE()+1);";
$result_week = mysqli_query($con, $query_week);
$row_week = mysqli_fetch_assoc($result_week);
$week=$row_week['DAYNAME(CURDATE()+1)'];
if($week=='Monday'){
  $week="월";
}else if($week=='Tuesday'){
  $week="화";
}else if($week=='Wednesday'){
  $week="수";
}else if($week=='Thursday'){
  $week="목";
}else if($week=='Friday'){
  $week="금";
}else if($week=='Saturday'){
  $week="토";
}else{
  $week="일";
}

if(isset($_SESSION['email'])){
  $email = $_SESSION['email'];
  $query_wish_sel = "SELECT * FROM personal_wish WHERE item_id = '$idnumber' AND email = '$email';";
  $result_wish_sel=mysqli_query($con,$query_wish_sel);
  $row_wish = mysqli_fetch_assoc($result_wish_sel);
  $wish_count = count($row_wish);

  if(!$wish_count){
    $query_wish = "INSERT INTO personal_wish(item_id, email,like_check) VALUES('$idnumber','$email','N');";
    mysqli_query($con,$query_wish);
    $like_check = 'N';
  }else{
      $like_check = $row_wish['like_check'];
  }
}

$query_info = "SELECT name, subname, introduce, address, today, workday, homepage, office_number FROM office_info WHERE idnumber = '$idnumber';";
$result_set = mysqli_query($con, $query_info);
$row = mysqli_fetch_assoc($result_set);
$title = $row['name'];
$subname = $row['subname'];
$introduce = $row['introduce'];
$address = $row['address'];
$today = $row['today'];
$workday = $row['workday'];
$homepage = $row['homepage'];
$offi_number = $row['office_number'];
$sub_number_h = substr($offi_number,0,3);
$sub_number_m = substr($offi_number,3,4);
$sub_number_f = substr($offi_number,7,4);
$office_number = $sub_number_h.' - '.$sub_number_m.' - '.$sub_number_f;

$query_item = "SELECT * FROM office_item WHERE idnumber = '$idnumber';";
$result_item = mysqli_query($con, $query_item);
$row_item = mysqli_fetch_assoc($result_item);
$grade = $row_item['grade'];
$office_like = $row_item['office_like'];
$look_up = $row_item['look_up'];

if($grade >= 0.0 && $grade < 1.9){
  $grade_tag = '별로에요';
}else if($grade >= 2.0 && $grade < 2.9){
  $grade_tag = '잘모르겠어요';
}else if($grade >= 3.0 && $grade < 3.9){
  $grade_tag = '그럭저럭';
}else if($grade >= 4.0 && $grade < 4.9){
  $grade_tag = '가볼만해요';
}else{
  $grade_tag = '인생마카롱';
}

if(!isset($_COOKIE['look_up'. $idnumber])){
  $query_look = "UPDATE office_item SET look_up = '$look_up'+1 WHERE idnumber = '$idnumber';";
  if(mysqli_query($con, $query_look)){
    setcookie('look_up' . $idnumber, TRUE, time()+(86400*30),'/');
    $look_up +=1;
  }else{
    alert(mysqli_error($con));
  }
}

$query_menu = "SELECT menu, price, number_create, number_sales FROM office_menu WHERE idnumber ='$idnumber';";
$result_set = mysqli_query($con, $query_menu);
$i=0;
while($row1 = mysqli_fetch_assoc($result_set)){
  $menu[$i] = $row1['menu'];
  $number[$i] = $row1['number_create'] - $row1['number_sales'];
  $price[$i] = $row1['price'];
  $menu2[$i] = $row1['menu'].' --- '.$row1['price'].' 원';
  $i++;
}
$len = sizeof($menu);
$query_picture = "SELECT image FROM office_picture WHERE idnumber = '$idnumber';";
$result_set = mysqli_query($con, $query_picture);
$in=0;
while($row2 = mysqli_fetch_assoc($result_set)){
  $image[$in] = $row2['image'];
  $in++;
}
$size = sizeof($image);


$query_count = "SELECT * FROM review WHERE idnumber = '$idnumber';";
$result_count = mysqli_query($con, $query_count);
$total_count = mysqli_num_rows($result_count);
$list_count = 5;

$query_review = "SELECT name, grade, coment, upload_time FROM review WHERE idnumber = '$idnumber' ORDER BY upload_time DESC LIMIT 0, $list_count;";
$result_review = mysqli_query($con,$query_review);
$i=0;
while ($row_review = mysqli_fetch_assoc($result_review)) {
  $name[$i] = $row_review['name'];
  $review_grade[$i] = $row_review['grade'];
  $coment[$i] = $row_review['coment'];
  $upload = explode(' ', $row_review['upload_time']);
   $upload_time[$i] = $upload[0];
  if($review_grade[$i] >= 0.0 && $review_grade[$i] < 1.9){
    $review_grade_tag[$i] = '별로에요';
  }else if($review_grade[$i] >= 2.0 && $review_grade[$i] < 2.9){
    $review_grade_tag[$i] = '잘모르겠어요';
  }else if($review_grade[$i] >= 3.0 && $review_grade[$i] < 3.9){
    $review_grade_tag[$i] = '그럭저럭';
  }else if($review_grade[$i] >= 4.0 && $review_grade[$i] < 4.9){
    $review_grade_tag[$i] = '가볼만해요';
  }else{
    $review_grade_tag[$i] = '인생마카롱';
  }
  $i++;
}
$size_review = count($name);

mysqli_close($con);
 ?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=08d65c3f64046fc30f8aefe7e6b9eb49&libraries=services"></script>
  <link rel="stylesheet" type="text/css" href="mainslider.css">

  </script>
<style>
#circle {
background-color:white;
border:1px solid darkgray;
width:100px; height:100px;
border-radius:75px;
text-align:center;
margin:0 auto;
font-size:50px;
vertical-align:middle;
line-height:100px;
}
#circle:hover {
background-color:#FF7F00;
border:1px solid #FF7F00;
width:100px; height:100px;
border-radius:75px;
text-align:center;
margin:0 auto;
vertical-align:middle;
line-height:100px;
}

#circle:hover i{
  font-size:50px; color:#fff;
}

#circle:hover h6 {
    color:#FF7F00;
}
.nounderline{
  text-decoration: none !important;
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

      <hr>
      <div class="row">

        <div class="col-md-4">
          <pre><h3><?php echo $title; ?> <strong class="text-warning"><i class="fas fa-star"> <?php echo $grade; ?></i></strong></h3></pre>

          <p class="text-secondary"><?php echo $subname; ?></p>
          <pre><i class="fas fa-heart">  <input readonly id="office_like" class="font-weight-bold" type="text" style="border: none; width: 50px;" value="<?php echo $office_like; ?>"/></i>  <i class="fas fa-eye">  <input readonly id="look_up" class="font-weight-bold" type="text" style="border: none; width: 50px;" value="<?php echo $look_up;?>"/></i></pre>
        </div>

        <div class="col-md-6">
          <?php if (isset($_SESSION['idnumber'])&&$idnumber==$_SESSION['idnumber']) {
            ?>
            <input type="button" id="edit" class="btn btn-primary" value="편집">
            <input type="button" id="del" class="btn btn-danger"  value="삭제">
            <?php
          } ?>
        </div>

        <div class="col-md-2">
          <div id="circle">
            <a class="nounderline text-dark" href="https://map.kakao.com/link/search/<?php echo $address; ?>">
            <i class="fas fa-map-marker-alt"></i>
            <h6>길찾기</h6>
            </a>
          </div>
        </div>
      </div>
      <br>

      <div id="slider-wrap">
        <ul id="slider">

<!-- 사진 보여주는 곳 -->
            <?php
            for ($i=0; $i <$size ; $i++) {
              ?>  <li><img class="img-responsive" src=<?php echo $image[$i]; ?>></li><?php
            }?>
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

      <div class="row">
        <div class="col-md-9">

          <h5 class="font-weight-bold">매장소개</h5>
          <p><?php echo $introduce;?></p>
          <br>

          <h5 class="font-weight-bold">주소</h5>
          <p><?php echo $address;?></p>
          <div id="map" style="width:800px;height:400px;"></div>
          <br>
          <br>

          <h5 class="font-weight-bold text-warning">TODAY</h5>
          <p><?php echo $today;?></p>
          <br>

          <h5 class="font-weight-bold">영업날짜</h5>
          <p><?php echo $workday;?></p>
          <br>

          <h5 class="font-weight-bold">문의번호</h5>
          <p><?php echo $office_number;?></p>
          <br>

          <h5 class="font-weight-bold">대표메뉴</h5>
          <?php
          for($i=0;$i<$len;$i++){
            ?><p><?php echo $menu[$i].' '.number_format($price[$i]).' 원<br>';?></p><?php
            }?>
          <br>

        <h5 class="font-weight-bold">매장 홈페이지</h5>
        <a href="<?php echo $homepage; ?>"><?php echo $homepage; ?></a>
        <br>
        <hr>

        <pre><h5><strong>리뷰</strong> <d class="pull-right">전체 리뷰 <d class="text-warning"><?php echo $total_count; ?></d>  전체 평점 <d class="text-warning"><?php echo $grade; ?></d> <d class="text-secondary"><?php echo $grade_tag; ?></d></d></h5></pre>
        <hr style="border:0;height:3px;background:#ccc;">

        <?php
        if($total_count == 0){
          ?>
          <h4 class="text-center">리뷰가 없습니다.</h4>
          <hr>
          <?php
        }else{
          for ($i=0; $i < $size_review; $i++) {
            ?>
            <h6><?php echo $upload_time[$i]; ?> <?php echo $name[$i]; ?></h6>
            <h4 class="text-warning"><?php echo $review_grade[$i]; ?> <strong class="text-dark"><?php echo $review_grade_tag[$i]; ?></strong></h4>
            <h5 class="text-secondary"><?php echo $coment[$i]; ?></h5>
            <hr>
            <?php
          }
          ?>
          <div id="plus_div">
          </div>
          <?php
          if($list_count < $total_count){
            ?>
            <div id="reset_div">
                <input id="plus_value" type="hidden" value="<?php echo $list_count; ?>">
                <button id="plus_bt"class="btn btn-light btn-block">더보기</button>
            </div>
            <?php
          }
        }
        ?>

      </div>

      <!-- 로그인 되어야함 data-toggle="modal" data-target="#myModal"-->
        <div class="col-md-3">
          <?php
          if($idnumber != $_SESSION['idnumber']){
            ?>
            <nav class="navbar bg-light sticky-top justify-content-center">
              <button onclick="ChangeImage()" type="button" class="btn" id="like_bt" name="like_bt" ><h4>
                <?php if($like_check=='Y'){
                  ?>
                  <i class="fas fa-heart text-danger" id="like_im"></i>
                  <?php
                }else{
                  ?>
                  <i class="far fa-heart" id="like_im"></i>
                  <?php
                } ?>
                <p>좋아요</p></h4></button>

              <button type="button" class="btn-block btn btn-danger" id="reservation_bt"><h4>예약하기</h4></button>
            </nav>
            <?php
          }
           ?>


  <form name = "reserForm" method="POST">
      <!-- The Modal -->
  <div class="modal fade" id="reserModal">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
      <input readonly type="text" class="font-weight-bold" id='currentDate' style="border: 0 none; font-size:150%; width:200px;"/>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>


<input hidden type="text" name="idnumber" value="<?php echo $idnumber; ?>">
    <!-- Modal body -->
    <div class="modal-body">

<?php
for ($i=0; $i < $len; $i++) {
  ?>
  <div class="custom-control custom-checkbox mb-3">
    <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $i;?>" name="menulist[]" value="<?php echo $i; ?>">
    <label class="custom-control-label" for="customCheck<?php echo $i;?>"><?php echo $menu2[$i]; ?></label>
    <select class="custom-control-select" id="selt<?php echo $i;?>" name="selt[]" disabled>
      <option value="count" selected>수량</option>
      <!-- 수량만큼 반복 돌려서 출력 -->
      <?php
        for ($j=1; $j <= $number[$i] ; $j++) {
                  ?>
    <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
    <?php
  }?>
  </select>
</div><?php
}
    ?>
    <hr>

    <div class="d-flex justify-content-end">
      <h5>가격 :
        <input readonly id="total" class="text-right font-weight-bord"type="text" name="total" style="border: 0 none; width:100px;" value="0"/>원</h5>
    </div>

    </div>

    <!-- Modal footer -->
    <div class="modal-footer">

      <input id="basket" type="button" class="btn btn-success" value="장바구니">
      <input id="reservation"type="submit" class="btn btn-primary" value="예약" formaction="./reservation.php">
    </div>
  </div>
  </div>
  </div>
    </form>

        </div>

      </div>


    </div>
    <footer>
      <?php include "footer.php" ?>
    </footer>

    <script type="text/javascript">
    $("#plus_bt").click(function(){
      var listcount = Number($('#plus_value').val());
      $.ajax({
        type : "POST",
        url : "store_item_plus.php",
        data : {listcount : listcount, idnumber : <?php echo $idnumber; ?>},
        dataType : "text",
        success : function(data){
          listcount += 5;
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

      $('#edit').click(function(){
        location.href='store_edit.php?id=<?php echo $idnumber; ?>';
      });

      $('#del').click(function(){
        var del_check = confirm("정말 삭제하시겠습니까?");
        if(del_check){
          location.href='store_delete.php?id=<?php echo $idnumber; ?>';
        }else{
          return del_check;
        }
      });
    </script>

    <script type="text/javascript" src="mainslider.js">
    </script>

    <script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
  mapOption = {
      center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
      level: 3 // 지도의 확대 레벨
  };
// 지도를 생성합니다
var map = new kakao.maps.Map(mapContainer, mapOption);

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new kakao.maps.services.Geocoder();

// 주소로 좌표를 검색합니다
geocoder.addressSearch('<?php echo $address; ?>', function(result, status) {

  // 정상적으로 검색이 완료됐으면
   if (status === kakao.maps.services.Status.OK) {

      var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

      // 결과값으로 받은 위치를 마커로 표시합니다
      var marker = new kakao.maps.Marker({
          map: map,
          position: coords
      });

      // 인포윈도우로 장소에 대한 설명을 표시합니다
      var infowindow = new kakao.maps.InfoWindow({
          content: '<div style="width:150px;text-align:center;padding:6px 0;"><?php echo $title; ?></div>'
      });
      infowindow.open(map, marker);

      // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
      map.setCenter(coords);
  }
});
</script>

<!-- 모달 표현해주는곳 -->
<script>
// modal ({backdrop: "static"}); 나중에 배경 클릭 못하게 할 때 사용하게 될듯
$(document).ready(function(){
  $("#reservation_bt").click(function(){
    <?php
    if(!isset($_SESSION['email'])) {
    ?>
    var login_check= confirm("로그인이 필요한 서비스입니다. 로그인 하시겠습니까?");
    if(login_check){
      location.replace("./login.php?id=<?php echo $idnumber; ?>");
    }else{
      return login_check;
    }
    <?php
  }else{
    if(strpos($workday, $week) !== false) {
        ?>
        $("#reserModal").modal({backdrop: "static"});
        var now = new Date();
        var mon = (now.getMonth()+1)>9 ? ''+(now.getMonth()+1) : '0'+(now.getMonth()+1);
        var day = (now.getDate()+1)>9 ? ''+(now.getDate()+1) : '0'+(now.getDate()+1);

        var chan_val = mon + '/' + day +' 예약';
        $("#currentDate").val(chan_val);
        $("select option[value*='count']").prop('disabled',true);

        var price = new Array();
        <?php for ($i=0; $i < $len; $i++) {
          ?>price[<?php echo $i; ?>] = Number(<?php echo $price[$i]; ?>);<?php
        }?>

        var len = Number(<?php echo $len;?>);
        var total = new Array();
        for (var i = 0; i < len; i++) {
          total[i]=0;
        }
        var sum = 0;
        $('input[name="menulist[]"]').change(function(){
          if($(this).is(':checked')){
            var value = Number($(this).val());
            $('#selt'+value).prop('disabled',false);
            if($('#selt'+value+' option:selected').val()!='count'){
                total[value] = price[value]*Number($('#selt'+value+' option:selected').val());
                sum=0
                for (var i = 0; i < len; i++) {
                  sum+=total[i];
                }
                $("#total").val(sum.toLocaleString());
            }else{
              var value = Number($(this).val());
              var coco =Number($('#selt'+value).val());
              $('#selt'+value).change(function(){
                sum = 0;
                var count = Number($(this).val());
                total[value] = price[value]*count;
                for (var i = 0; i < len; i++) {
                  sum+=total[i];
                }

                $("#total").val(sum.toLocaleString());
              });
            }
          }else{
            var value = Number($(this).val());
            $('#selt'+value).prop('disabled',true);
            var b = $('#selt'+value).prop('disabled');
            if(b){
              if(total[value]!=0){
                sum-=total[value];
                total[value]=0;
              }else{
              total[value]=0;
              }
            }
            $("#total").val(sum.toLocaleString());
          }
        });
        <?php
    } else {
      ?>
      alert('<?php echo $week; ?>요일은 업체 휴일입니다.');
      return false;
      <?php
    }
  }
  ?>
  });

      $("#basket").click(function(){
        var box_length = $("input:checkbox[name='menulist[]']:checked").length;

        var box_value =new Array();
        var sel_count = new Array();
        box_value = $("input:checkbox[name='menulist[]']");
        for (var i = 0; i < box_value.length; i++) {
          if(box_value[i].checked){
          sel_count[i] =  box_value[i].value;
        }else{
          sel_count[i]=null;
        }
        }
        if(box_length==0){
          alert("메뉴 선택을 해주세요.");
          return false;
        }else{
          for (var i = 0; i < sel_count.length; i++) {
            if(sel_count[i]!=null){
              var sel_vl = $('#selt'+sel_count[i]+' option:selected').val();
              if(sel_vl=='count'){
                alert('수량을 선택해주세요.');
                return false;
                break;
              }else{
                $.ajax({
                  type:"GET",
                  url:"./basket_db.php",
                  data : {idnumber : <?php echo $idnumber; ?>, cot : sel_vl, menu_num : sel_count[i]},
                  dataType:"text",
                  success:function(data){
                  },
                  error : function(data){
                    alert('error');
                  }
                });
              }
            }
            if(i==sel_count.length-1){
              var check_basket = confirm("장바구니에 넣었습니다. 확인하시겠습니까?");
                if(check_basket){
                  location.href="./basket.php";
                }else{
                  $("#reserModal").modal("hide");
                  return check_basket;
                }
            }
          }
        }
      });

      $("#reservation").click(function(){
        var box_length = $("input:checkbox[name='menulist[]']:checked").length;

        var box_value =new Array();
        var sel_count = new Array();
        box_value = $("input:checkbox[name='menulist[]']");
        for (var i = 0; i < box_value.length; i++) {
          if(box_value[i].checked){
          sel_count[i] =  box_value[i].value;
        }else{
          sel_count[i]=null;
        }
        }

        if(box_length==0){
          alert("메뉴 선택을 해주세요.");
          return false;
        }else{
          for (var i = 0; i < sel_count.length; i++) {
            if(sel_count[i]!=null){
              var sel_vl = $('#selt'+sel_count[i]+' option:selected').val();
              if(sel_vl=='count'){
                alert('수량을 선택해주세요.');
                return false;
                break;
              }
            }
            if(i==sel_count.length-1){
              var check_submit = confirm('예약하시겠습니까?');
              return check_submit;
            }
          }
        }

      });

});

// 좋아요 눌렀을때 색깔 바꾸기
function ChangeImage() {
  <?php
  if(!isset($_SESSION['email'])) {
  ?>
  var login_check= confirm("로그인이 필요한 서비스입니다. 로그인 하시겠습니까?");
  if(login_check){
    location.replace("./login.php?id=<?php echo $idnumber; ?>");
  }else{
    return login_check;
  }
  <?php
}else{
    ?>
    var check_like = "";
    var likeClass = $('#like_im').attr('class');
    if(likeClass == 'far fa-heart'){
      check_like = "N";
    }else{
      check_like = "Y";
    }
    var office_like = Number($("#office_like").val());

    $.ajax({
      type:"POST",
      url:"./store_item_heart.php",
      data : {check : check_like, email : "<?php echo $email; ?>", idnumber : "<?php echo $idnumber; ?>", office_like : office_like},
      dataType :"text",
      success : function(data){
        if(data=='N'){
          document.getElementById('like_im').setAttribute('class','far fa-heart');
          $("#office_like").val(office_like-1);
        }else{
          document.getElementById('like_im').setAttribute('class','fas fa-heart text-danger');
          $("#office_like").val(office_like+1);
        }
      },
      error : function(data) {
        alert(data);
      }
    });
    <?php
}
   ?>
}
  </script>

  </body>
</html>
