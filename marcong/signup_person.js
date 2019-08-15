$(function() {
  //모달을 전역변수로 선언
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

  //------- 검사하여 상태를 class에 적용
  $('#name').keyup(function(event) {

    var divName = $('#divName');

    if ($.trim($('#name').val()) == "") {
      divName.removeClass("has-success");
      divName.addClass("has-error");
    } else {
      divName.removeClass("has-error");
      divName.addClass("has-success");
    }
  });

  $('#id').keyup(function(event) {

    var divId = $('#divId');

    if ($('#id').val() == "") {
      divId.removeClass("has-success");
      divId.addClass("has-error");
    } else {
      divId.removeClass("has-error");
      divId.addClass("has-success");
    }
  });

  $('#password').keyup(function(event) {

    var divPassword = $('#divPassword');

    if ($('#password').val() == "") {
      divPassword.removeClass("has-success");
      divPassword.addClass("has-error");
    } else {
      divPassword.removeClass("has-error");
      divPassword.addClass("has-success");
    }
  });

  $('#passwordCheck').keyup(function(event) {

    var passwordCheck = $('#passwordCheck').val();
    var password = $('#password').val();
    var divPasswordCheck = $('#divPasswordCheck');

    if ((passwordCheck == "") || (password != passwordCheck)) {
      divPasswordCheck.removeClass("has-success");
      divPasswordCheck.addClass("has-error");
    } else {
      divPasswordCheck.removeClass("has-error");
      divPasswordCheck.addClass("has-success");
    }
  });

  $('#year').keyup(function(event) {

    var divBirthDay = $('#divBirthDay');

    if ($('#year').val() == "" || $('#month').val()=="월" || $('#day').val()=="일") {
      divBirthDay.removeClass("has-success");
      divBirthDay.addClass("has-error");
    } else {
      divBirthDay.removeClass("has-error");
      divBirthDay.addClass("has-success");
    }
  });

  $('#phoneNumber').keyup(function(event) {

    var divPhoneNumber = $('#divPhoneNumber');

    if ($.trim($('#phoneNumber').val()) == "") {
      divPhoneNumber.removeClass("has-success");
      divPhoneNumber.addClass("has-error");
    } else {
      divPhoneNumber.removeClass("has-error");
      divPhoneNumber.addClass("has-success");
    }
  });


  //------- validation 검사
  $("#personal_form").submit(function(event) {

    var divName = $('#divName');
    var divId = $('#divId');
    var divPassword = $('#divPassword');
    var divPasswordCheck = $('#divPasswordCheck');
    var divBirthDay = $('#divBirthDay');
    var divPhoneNumber = $('#divPhoneNumber');

    //이름
    if ($('#name').val() == "") {
      modalContents.text("이름을 입력하여 주시기 바랍니다.");
      modal.modal('show');

      divName.removeClass("has-success");
      divName.addClass("has-error");
      $('#name').focus();
      return false;
    } else {
      divName.removeClass("has-error");
      divName.addClass("has-success");
    }

    //아이디 검사
    if ($('#id').val() == "") {
      modalContents.text("이메일을 입력하여 주시기 바랍니다.");
      modal.modal('show');

      divId.removeClass("has-success");
      divId.addClass("has-error");
      $('#id').focus();
      return false;
    } else {
      divId.removeClass("has-error");
      divId.addClass("has-success");
    }

    //패스워드 검사
    if ($('#password').val() == "") {
      modalContents.text("패스워드를 입력하여 주시기 바랍니다.");
      modal.modal('show');

      divPassword.removeClass("has-success");
      divPassword.addClass("has-error");
      $('#password').focus();
      return false;
    } else {
      divPassword.removeClass("has-error");
      divPassword.addClass("has-success");
    }

    //패스워드 확인
    if ($('#passwordCheck').val() == "") {
      modalContents.text("패스워드 확인을 입력하여 주시기 바랍니다.");
      modal.modal('show');

      divPasswordCheck.removeClass("has-success");
      divPasswordCheck.addClass("has-error");
      $('#passwordCheck').focus();
      return false;
    } else {
      divPasswordCheck.removeClass("has-error");
      divPasswordCheck.addClass("has-success");
    }

    //패스워드 비교
    if ($('#password').val() != $('#passwordCheck').val() || $('#passwordCheck').val() == "") {
      modalContents.text("패스워드가 일치하지 않습니다.");
      modal.modal('show');

      divPasswordCheck.removeClass("has-success");
      divPasswordCheck.addClass("has-error");
      $('#passwordCheck').focus();
      return false;
    } else {
      divPasswordCheck.removeClass("has-error");
      divPasswordCheck.addClass("has-success");
    }

    if($('#year').val()=="" || $('#month').val()=="월" || $('#day').val()=="일"){
      modalContents.text("생년월일을 입력해주시기 바랍니다.");
      modal.modal('show');

      divBirthDay.removeClass("has-success");
      divBirthDay.addClass("has-error");
      $('#year').focus();
      return false;
    }else {
      divBirthDay.removeClass("has-error");
      divBirthDay.addClass("has-success");
    }

    //휴대폰 번호
    if ($('#phoneNumber').val() == "") {
      modalContents.text("휴대폰 번호를 입력하여 주시기 바랍니다.");
      modal.modal('show');

      divPhoneNumber.removeClass("has-success");
      divPhoneNumber.addClass("has-error");
      $('#phoneNumber').focus();
      return false;
    } else {
      divPhoneNumber.removeClass("has-error");
      divPhoneNumber.addClass("has-success");
    }

  });
});
