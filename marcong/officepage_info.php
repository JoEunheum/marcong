<?php
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <title>업체페이지</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
      <script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=08d65c3f64046fc30f8aefe7e6b9eb49&libraries=services"></script>
 </head>
 <body>
   <header>
     <?php include "top.php" ?>
   </header>
   <div class="pull-right sticky-top">
     <?php include "sidemenu.php" ?>
   </div>

   <div id="div_edit" class="container" style="height:500px;">
     <h3>업체정보수정</h3>
     <hr>


     <div class="row">
       <div class="col-sm-2">
         <ul class="list-group list-group-flush sticky-top">
           <a href="./officepage_info.php" style="border: 0 none;" class="active list-group-item list-group-item-action"><h5>업체정보수정</h5></a>
           <a href="./officepage_menu.php" style="border: 0 none;" class="list-group-item list-group-item-action">마카롱</a>
           <a href="./officepage_lookup.php" style="border: 0 none;" class="list-group-item list-group-item-action">예약확인</a>
         </ul>
       </div>
       <div class="col-sm-1">
       </div>
       <div id="em" class="col">
           <div class="card text-center">
             <div class="card-body">
               <br>
              <p>정보 수정을 위해 비밀번호를 입력해주시기 바랍니다.</p>
              <br>
              <div class="input-group">
                <input id="pw" type="password" class="form-control text-center" name="pw"/>
                <div class="input-group-append">
                  <button id="pw_bt" type="button" class="btn btn-success"name="button">입력
                  </button>
                </div>
              </div>
              <br>
             </div>
           </div>
       </div>
       <div class="col-sm-2">
       </div>

     </div>
   </div>

   <footer>
     <?php include "footer.php" ?>
   </footer>

   <script>
   $('#pw_bt').click(function(){
     var pw = $('#pw').val();
     $.ajax({
       type:"POST",
        url: "./officepage_pw.php",
        data : {password : pw},
        dataType:"text",
        success : function(data){
          if(Number(data)!=0){
            $('#em').empty();
            $('#div_edit').css("height","1400px");
            $('#em').prepend(data);
          }else{
            alert("잘못 입력하였습니다.");
          }
        },
        error : function(data){
          alert('error');
        }
     });
   });


   </script>
 </body>
 </html>
