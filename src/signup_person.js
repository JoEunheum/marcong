$(function() {
  //모달을 전역변수로 선언
  var modalContents = $(".modal-contents");
  var modal = $("#defaultModal");
  var c_modal = $("#certificationModal");

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

$("#id").keyup(function(){
  $("#email_check_val").val(0);
});

  //------- email 검사
$("#email_check").click(function(){
  //아이디 검사
  var email = $.trim($('#id').val());
  if (email == "") {
    modalContents.text("이메일을 입력하여 주시기 바랍니다.");
    modal.modal('show');
    $('#id').focus();
    return false;
  }else{
    $.ajax({
      type : "POST",
      url : "./email_check.php",
      data : {email : email},
      dataType : "text",
      success : function(data){
        if(data == 0){
          $.ajax({
            type : "POST",
            url : "./PHPMailer/certification_email.php",
            data : {email : email},
            dataType : "text",
            success : function(data){
              alert("인증번호를 보냈습니다.");
              c_modal.modal({backdrop : "static"});
              $('#certi_email').off().on("click", function(){
                if($("#certification").val() == data){
                  alert("인증되었습니다.");
                  c_modal.modal("hide");
                  $("#email_check_val").val(1);
                }else{
                  alert("인증번호가 다릅니다.");
                }
              });
            },
            error : function(data){
              alert('mailer error');
            }
          });
        }else{
          modalContents.text("이미 사용중인 이메일입니다.");
          modal.modal('show');
          $('#id').focus();
          return false;
        }
      },
      error : function(data){
        alert('error');
      }
    });
  }
});

  //------- validation 검사
  $("#personal_form").submit(function(event) {

    //이름
    if ($('#name').val() == "") {
      modalContents.text("이름을 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#name').focus();
      return false;
    }

    //패스워드 검사
    if ($('#password').val() == "") {
      modalContents.text("패스워드를 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#password').focus();
      return false;
    }

    //패스워드 확인
    if ($('#passwordCheck').val() == "") {
      modalContents.text("패스워드 확인을 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#passwordCheck').focus();
      return false;
    }

    //패스워드 비교
    if ($('#password').val() != $('#passwordCheck').val() || $('#passwordCheck').val() == "") {
      modalContents.text("패스워드가 일치하지 않습니다.");
      modal.modal('show');
      $('#passwordCheck').focus();
      return false;
    }

    if($('#year').val()=="" || $('#month').val()=="월" || $('#day').val()=="일"){
      modalContents.text("생년월일을 입력해주시기 바랍니다.");
      modal.modal('show');
      $('#year').focus();
      return false;
    }

    //휴대폰 번호
    if ($('#phoneNumber').val() == "") {
      modalContents.text("휴대폰 번호를 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#phoneNumber').focus();
      return false;
    }

    if($('#email_check_val').val() == 0){
      modalContents.text("이메일 인증 버튼을 눌러주세요.");
      modal.modal('show');
      $('#id').focus();
      return false;
    }
  });
});
