$(function() {
  //모달을 전역변수로 선언
  var modalContents = $(".modal-contents");
  var modal = $("#defaultModal");

  $("#subname").on('keyup',function(){
    if($(this).val().length >23){
      $(this).val($(this).val().substr(0,23));
    }
  });


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

  //------- validation 검사
  $("#office_form").submit(function(event) {
    //이름
    if ($('#title').val() == "") {
      modalContents.text("상호명을 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#title').focus();
      return false;
    }

    //아이디 검사
    if ($('#email').val() == "") {
      modalContents.text("이메일을 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#email').focus();
      return false;
    }

    //패스워드 검사
    if ($('#pw').val() == "") {
      modalContents.text("패스워드를 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#pw').focus();
      return false;
    }

    //패스워드 확인
    if ($('#pwCheck').val() == "") {
      modalContents.text("패스워드 확인을 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#pwCheck').focus();
      return false;
    }

    //패스워드 비교
    if ($('#pw').val() != $('#pwCheck').val()) {
      modalContents.text("패스워드가 일치하지 않습니다.");
      modal.modal('show');
      $('#pwCheck').focus();
      return false;
    }

    //휴대폰 번호
    if ($('#officeNumber').val() == "") {
      modalContents.text("업체 번호를 입력하여 주시기 바랍니다.");
      modal.modal('show');
      $('#officeNumber').focus();
      return false;
    }

if($('#subname').val()==""){
  modalContents.text("간단한 소개를 적어주세요.");
  modal.modal('show');
  $('#subname').focus();
  return false;
}


var day_week = $("input:checkbox[name='day_week[]']").is(":checked");
if(!day_week){
    modalContents.text("영업요일을 선택해주세요.");
    modal.modal('show');
    return false;
}

var opentime = $('#opentime').val();
var closetime = $('#closetime').val();
if(opentime=="" ||closetime==""){
      modalContents.text("영업시간을 선택해주세요.");
      modal.modal('show');
      return false;
}
if(opentime>closetime){
  modalContents.text("시간설정을 다시해주세요.");
  modal.modal('show');
  return false;
}

var address = $("#address").val();
if(!address){
  modalContents.text("주소를 입력해주세요.");
  modal.modal('show');
  return false;
}


  });
});
