<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
  <title>회원가입</title>
  <!-- <link rel="stylesheet"type="text/css" href="login.css"> -->
  <!-- 부트스트랩 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  <script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=08d65c3f64046fc30f8aefe7e6b9eb49&libraries=services"></script>
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
      <script>
        function signCheck(radio_val){
          document.getElementById("personal").style.display=(radio_val.value == "personal"?"block":"none");
          document.getElementById("office").style.display=(radio_val.value == "office"?"block":"none");
        }
      </script>
      <div class="row">
        <div class="col text-center">
          <input type="radio" name="selectRadio" value="personal" onclick="signCheck(this)" checked>개인
          <input class="ml-5" type="radio" name="selectRadio" value="office" onclick="signCheck(this)">업체
        </div>
      </div>
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
        <form id="personal_form" method="post" class="form-singup form-horizontal" action="signup_person_db.php">
        <br>
        <div class="row">
          <div class="col"></div>
          <div class="col-md-5">

            <div class="form-group" id="divName">
              <input type="text" class="form-control onlyHangul" id="name" name="name" data-rule-required="true" placeholder="이름" maxlength="15">
            </div>

            <div class="form-group" id="divId">
                  <input type="email" class="form-control" id="id" data-rule-required="true" name="email" placeholder="이메일" maxlength="30">
              </div>

              <div class="form-group" id="divPassword">
                <input type="password" class="form-control" id="password" name="excludeHangul" data-rule-required="true" placeholder="비밀번호" maxlength="30">
              </div>

              <div class="form-group" id="divPasswordCheck">
                <input type="password" class="form-control" id="passwordCheck" data-rule-required="true" placeholder="비밀번호 확인" maxlength="30" name="password">
              </div>

              <div class="form-group" id="divBirthDay">
                <div class="d-inline-flex">
                  <div>
                    <input type="text" class="form-control onlyNumber" id="year" name="year" data-rule-required="true" placeholder="연도 (ex-1995)" maxlength="4">
                  </div>

                  <div>
                    <select class="form-control onlyNumber custom-select" id="month" name="month" style="width:100px;">
                      <option selected>월</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                    </select>
                  </div>

                  <div>
                    <select class="form-control onlyNumber custom-select" id="day" name="day" style="width:100px;">
                      <option selected>일</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                    </select>
                  </div>

      </div>
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

    <script type="text/javascript" src="signup_person.js">
    </script>
      </div>

      <div id="office" style="display:none;">
        <div class="row">
          <div class="col"></div>
          <div class="col-md-5">
            <br>
            <form id="office_form" method="post" action="./signup_office_db.php">

              <div class="form-group" id="divTitle">
                <input id="title" name="title" type="text" placeholder="상호명" class="form-control"/>
              </div>

              <div class="form-group" id="divEmail">
                    <input type="email" class="form-control" id="email" data-rule-required="true" name="email" placeholder="이메일" maxlength="30">
                </div>

                <div class="form-group" id="divPW">
                  <input type="password" class="form-control" id="pw" name="excludeHangul" data-rule-required="true" placeholder="비밀번호" maxlength="30">
                </div>

                <div class="form-group" id="divPWCheck">
                  <input type="password" class="form-control" id="pwCheck" data-rule-required="true" placeholder="비밀번호 확인" maxlength="30" name="password">
                </div>

                <div class="form-group" id="divOfficeNumber">
                  <input type="tel" class="form-control onlyNumber" id="officeNumber" data-rule-required="true" placeholder="업체번호 (- 없이 숫자만 입력)" maxlength="11" name="number">
                </div>

              <div class="form-group">
                <input id="subname" name="subname" type="text" placeholder="간단한 소개" class="form-control" maxlength="23"/>
              </div>

              <div class="form-group">
                <textarea id="introduce" name="introduce" rows="8" placeholder="자세한 소개를 입력" class="form-control"></textarea>
              </div>

              <div class="form-group text-center">
                <h6><영업요일 및 시간 ></h6>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="월">월
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="화">화
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="수">수
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="목">목
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="금">금
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="토">토
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" name="day_week[]" class="form-check-input" value="일">일
                  </label>
                </div>
              </div>

              <div class="form-group form-inline">
                <h6 class="ml-3">시작시간
                <input type="time" id="opentime"class="mr-4 form-control" name="opentime">
                마감시간
                <input type="time" id="closetime" class="form-control" name="closetime">
                </h6>

              </div>

              <div class="form-group">
                <input id="homepage" name="homepage" type="text" placeholder="가게를 알릴 수 있는 링크를 적어주세요." class="form-control"/>
              </div>

              <div class="from-group">
                <div class="input-group">
                <input readonly id="address" name="address" type="text" class="form-control"/>
                <div class="input-group-append">
                  <input type="button" class="btn btn-success" onclick="sample5_execDaumPostcode()" value="주소 검색">
                </div>
              </div>
              <div class="mx-auto form-control" id="map" style="height:300px;margin-top:10px;display:none">
              </div>
              </div>

              <hr>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="officeCheck" name="agelimit" required>
                  <label class="text-primary custom-control-label" for="officeCheck">14세 이상입니다. (필수)</label>
                  <p class="text-secondary"><small>* 회원가입에 필요한 최소한의 정보만 입력 받음으로써 고객님의 개인정보 수집을 최소화하고 편리한 회원가입을 제공합니다.</small></p>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="form-control custom-control-input" id="useofficeCheck" name="uselimit" required>
                    <label class="custom-control-label " for="useofficeCheck">이용약관</label>
                    <button type="button" class="pull-right btn btn-primary" data-toggle="collapse" data-target="#useofficehompage">내용보기</button>
                  <div id="useofficehompage" class="collapse">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="form-control custom-control-input" id="usedataofficeCheck" name="usedatalimit" required>
                    <label class="custom-control-label " for="usedataofficeCheck">개인정보 수집 및 이용안내</label>
                    <button type="button" class="pull-right btn btn-primary" data-toggle="collapse" data-target="#dataofficehompage">내용보기</button>
                  <div id="dataofficehompage" class="collapse">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>
              </div>
              <br>
              <hr>

              <div class="form-group">
                <br>
                <input id="upload" type="submit" value="Sign Up" class="form-control btn btn-primary"/>
              </div>
     </form>
          </div>
            <div class="col"></div>
        </div>
        <script type="text/javascript" src="signup_office.js">
        </script>
        <script>
            var mapContainer = document.getElementById('map'), // 지도를 표시할 div
                mapOption = {
                    center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
                    level: 5 // 지도의 확대 레벨
                };

            //지도를 미리 생성
            var map = new daum.maps.Map(mapContainer, mapOption);
            //주소-좌표 변환 객체를 생성
            var geocoder = new daum.maps.services.Geocoder();
            //마커를 미리 생성
            var marker = new daum.maps.Marker({
                position: new daum.maps.LatLng(37.537187, 127.005476),
                map: map
            });


            function sample5_execDaumPostcode() {
                new daum.Postcode({
                    oncomplete: function(data) {
                        var addr = data.address; // 최종 주소 변수

                        // 주소 정보를 해당 필드에 넣는다.
                        document.getElementById("address").value = addr;
                        // 주소로 상세 정보를 검색
                        geocoder.addressSearch(data.address, function(results, status) {
                            // 정상적으로 검색이 완료됐으면
                            if (status === daum.maps.services.Status.OK) {

                                var result = results[0]; //첫번째 결과의 값을 활용

                                // 해당 주소에 대한 좌표를 받아서
                                var coords = new daum.maps.LatLng(result.y, result.x);
                                // 지도를 보여준다.
                                mapContainer.style.display = "block";
                                map.relayout();
                                // 지도 중심을 변경한다.
                                map.setCenter(coords);
                                // 마커를 결과값으로 받은 위치로 옮긴다.
                                marker.setPosition(coords)
                            }
                        });
                    }
                }).open();
            }
        </script>
      </div>
    </div><!--container END -->

<footer>
  <?php include "footer.php" ?>
</footer>
</body>
</html>
