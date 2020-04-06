$(function() {

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
  $("#off_form").submit(function(event) {
    //이름
    if ($('#title').val() == "") {
      alert("상호명을 입력하여 주시기 바랍니다.");
      $('#title').focus();
      return false;
    }

    //패스워드 확인
    if ($('#pw').val() != "" && $('#pwCheck').val() == "") {
      alert("패스워드 확인을 입력하여 주시기 바랍니다.");
      $('#pwCheck').focus();
      return false;
    }

    //패스워드 비교
    if ($('#pw').val() != $('#pwCheck').val()) {
      alert("패스워드가 일치하지 않습니다.");
      $('#pwCheck').focus();
      return false;
    }

    //휴대폰 번호
    if ($('#officeNumber').val() == "") {
      alert("업체 번호를 입력하여 주시기 바랍니다.");
      $('#officeNumber').focus();
      return false;
    }

if($('#subname').val()==""){
  alert("간단한 소개를 적어주세요.");
  $('#subname').focus();
  return false;
}


var day_week = $("input:checkbox[name='day_week[]']").is(":checked");
if(!day_week){
    alert("영업요일을 선택해주세요.");
    return false;
}

var opentime = $('#opentime').val();
var closetime = $('#closetime').val();

if(opentime=="" ||closetime==""){
      alert("영업시간을 선택해주세요.");
      return false;
}
if(opentime>closetime){
  alert("시간설정을 다시해주세요.");
  return false;
}

var address = $("#address").val();
if(!address){
  alert("주소를 입력해주세요.");
  return false;
}

  });
});
