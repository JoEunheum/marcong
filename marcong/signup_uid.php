<?php
session_start();
$email = $_SESSION['uid_email'];
 ?>
 <!DOCTYPE html>
 <html lang="ko">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
   <title>회원가입</title>
   <!-- 부트스트랩 -->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <style>
   .border {
     display: inline-block;
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

   <!-- 모달창 -->
   <div class="container">
       <h3>회원가입</h3>
       <hr>
       <div class="modal fade" id="defaultModal">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                     <h4 class="modal-title">알림</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                   </div>
                   <div class="modal-body">
                       <p class="modal-contents"></p>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
                   </div>
               </div><!-- /.modal-content -->
           </div><!-- /.modal-dialog -->
       </div><!-- /.modal -->
       <!--// 모달창 -->

       <div id="personal">
         <form id="personal_form" method="post" class="form-singup form-horizontal" action="signup_uid_db.php">
         <br>
         <div class="row">
           <div class="col"></div>
           <div class="col-md-5">

             <div class="form-group" id="divName">
               <input type="text" class="form-control onlyHangul" id="name" name="name" data-rule-required="true" placeholder="이름" maxlength="15">
             </div>
             <?php
             if(isset($_SESSION['g_uid'])){
               $g_uid = $_SESSION['g_uid'];
               ?>
               <input type="hidden" name="g_uid" value="<?php echo $g_uid; ?>">
               <?php
             }else{
               $uid = $_SESSION['uid'];
               ?>
               <input type="hidden" name="uid" value="<?php echo $uid; ?>">
               <?php
             }
              ?>

             <div class="form-group" id="divId">
                   <input readonly type="email" class="form-control" id="id" data-rule-required="true" name="email" placeholder="이메일" maxlength="30" value="<?php echo $email; ?>">
               </div>

               <div class="form-group" id="divPhoneNumber">
                 <input type="tel" class="form-control onlyNumber" id="phoneNumber" data-rule-required="true" placeholder="휴대폰번호 (- 없이 숫자만 입력)" maxlength="11" name="number">
               </div>
               <hr>
               <div class="form-group">
                 <div class="custom-control custom-checkbox">
                   <input type="checkbox" class="custom-control-input" id="ageCheck" name="agelimit" required>
                   <label class="text-primary custom-control-label" for="ageCheck">14세 이상입니다. (필수)</label>
                   <p class="text-secondary"><small>* 회원가입에 필요한 최소한의 정보만 입력 받음으로써 고객님의 개인정보 수집을 최소화하고 편리한 회원가입을 제공합니다.</small></p>
                 </div>
               </div>

               <div class="form-group">
                 <div class="custom-control custom-checkbox">
                   <input type="checkbox" class="form-control custom-control-input" id="useCheck" name="uselimit" required>
                   <label class="custom-control-label " for="useCheck">이용약관</label>
                   <button type="button" class="pull-right btn btn-primary" data-toggle="collapse" data-target="#usehompage">내용보기</button>
                   <div id="usehompage" class="collapse">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                     sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                     quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                   </div>
                 </div>
               </div>

               <div class="form-group">
                 <div class="custom-control custom-checkbox">
                   <input type="checkbox" class="form-control custom-control-input" id="usedataCheck" name="usedatalimit" required>
                   <label class="custom-control-label " for="usedataCheck">개인정보 수집 및 이용안내</label>
                   <button type="button" class="pull-right btn btn-primary" data-toggle="collapse" data-target="#datahompage">내용보기</button>
                   <div id="datahompage" class="collapse">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                     sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                     quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                   </div>
                 </div>
               </div>
               <br>
               <hr>

               <div class="form-group">
                 <button type="submit" class="form-control btn btn-primary">Sign Up</button>
               </div>
             </form>
           </div>
       <div class="col"></div>
     </div>

     <script>
     $(function() {
       var modalContents = $(".modal-contents");
       var modal = $("#defaultModal");

       $('.onlyAlphabetAndNumber').keyup(function(event) {
         if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
           var inputVal = $(this).val();
           $(this).val($(this).val().replace(/[^_a-z0-9]/gi, '')); //_(underscore), 영어, 숫자만 가능
         }
       });

       $(".onlyHangul").keyup(function(event) {
         if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
           var inputVal = $(this).val();
           $(this).val(inputVal.replace(/[a-z0-9]/gi, ''));
         }
       });

       $(".onlyNumber").keyup(function(event) {
         if (!(event.keyCode >= 37 && event.keyCode <= 40)) {
           var inputVal = $(this).val();
           $(this).val(inputVal.replace(/[^0-9]/gi, ''));
         }
       });

       $("#personal_form").submit(function(event) {
         if ($('#name').val() == "") {
           modalContents.text("이름을 입력하여 주시기 바랍니다.");
           modal.modal('show');
           $('#name').focus();
           return false;
         }
         if ($('#phoneNumber').val() == "") {
           modalContents.text("휴대폰 번호를 입력하여 주시기 바랍니다.");
           modal.modal('show');
           $('#phoneNumber').focus();
           return false;
         }
       });
     });

     </script>
       </div>
     </div>

       </div>
     </div><!--container END -->

 <footer>
   <?php include "footer.php" ?>
 </footer>
 </body>
 </html>
