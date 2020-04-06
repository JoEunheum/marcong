$(function(){

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

  $("#mypage_form").submit(function(event){

    //이름
    if ($('#title').val() == "") {
      alert("이름을 입력하여 주시기 바랍니다.");
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
    if ($('#phoneNumber').val() == "") {
      alert("휴대폰 번호를 입력하여 주시기 바랍니다.");
      $('#phoneNumber').focus();
      return false;
    }

    if($('#year').val() == "" || $('#month').val() =="월" || $('#day').val() == "일"){
      alert("생년월일을 입력해주시기 바랍니다.");
      $('#year').focus();
      return false;
    }

  });


});
