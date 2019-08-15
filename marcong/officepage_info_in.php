<?php
session_start();

$email = $_SESSION['email'];

$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$query_in = "SELECT * FROM office_info WHERE email = '$email';";
$result_in = mysqli_query($con, $query_in);
$row_in = mysqli_fetch_assoc($result_in);

$office_number = $row_in['office_number'];
$title = $row_in['name'];
$subname = $row_in['subname'];
$introduce = $row_in['introduce'];
$address = $row_in['address'];
$today = $row_in['today'];
$workday = $row_in['workday'];
$homepage = $row_in['homepage'];
mysqli_close($con);

$strday = explode(' ~ ', $today);
 ?>

<form id="off_form" method="post">
       <table class="table table-bordered">
         <tbody>
             <div class="form-group">
               <tr>
                   <th>상호명: </th>
                   <td><input id="title" name="title" type="text" placeholder="상호명을 입력하세요. " value="<?php echo $title; ?>" class="form-control"/></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>이메일: </th>
                   <td><input readonly type="email" class="form-control" id="email" data-rule-required="true" name="email" value="<?php echo $email; ?>" maxlength="30"></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>비밀번호: </th>
                   <td><input type="password" class="form-control" id="pw" name="excludeHangul" placeholder="비밀번호 변경 (선택) " maxlength="30"></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>비밀번호
                     <p>확인:</p></th>
                   <td><input type="password" class="mt-3 form-control" id="pwCheck"  placeholder="비밀번호 확인" maxlength="30" name="password"></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>업체번호: </th>
                   <td><input type="tel" class="form-control onlyNumber" id="officeNumber" data-rule-required="true" placeholder="업체번호 (- 없이 숫자만 입력)" maxlength="11" name="number" value="<?php echo $office_number; ?>"></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>간단한 소개: </th>
                   <td><input id="subname" name="subname" type="text" value="<?php echo $subname; ?>" placeholder="간단한 소개를 입력하세요. " class="form-control"/></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>소개: </th>
                   <td><textarea id="introduce" name="introduce" rows="8" placeholder="내용을 입력하세요. " class="form-control"><?php echo $introduce; ?></textarea></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>영업요일:</th>
                   <td>
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
                   </td>
               </tr>
             </div>

             <script>
               $('input:checkbox[name="day_week[]"]').each(function(){
                 var value=$(this).val();
                 var workday = "<?php echo $workday; ?>";
                 if(workday.match(value)){
                   this.checked=true;
                 }
               });
             </script>

             <div class="form-group">
               <tr>
                   <th>영업시간: </th>
                   <td>

                     <div class="form-group form-inline">
                     <h6 class="ml-3">시작시간
                     <input type="time" id="opentime"class="mr-4 form-control" name="opentime" value="<?php echo $strday[0]; ?>">
                     마감시간
                     <input type="time" id="closetime" class="form-control" name="closetime" value="<?php echo $strday[1]; ?>">
                     </h6>
                   </div>

                 </td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>홈페이지: </th>
                   <td><input id="homepage" name="homepage" type="text" placeholder="가게를 알릴 수 있는 링크를 적어주세요." class="form-control" value="<?php echo $homepage; ?>"/></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>주소: </th>
                   <td>
                     <div class="input-group">
                     <input readonly id="address" name="address" type="text" class="form-control" value="<?php echo $address; ?>"/>
                     <div class="input-group-append">
                       <input type="button" class="btn btn-primary" onclick="sample5_execDaumPostcode()" value="주소 검색">
                     </div>
                   </div>
                   <div class="mx-auto form-control" id="map" style="height:300px;margin-top:10px;display:none">
                   </div>
                   </td>
               </tr>
             </div>

                 <tr>
                     <td colspan="2">
                         <input id="upload" type="submit" value="편집" class="pull-right btn btn-success" formaction="./officepage_info_in_db.php"/>
                     </td>
                 </tr>
         </tbody>
       </table>
</form>

<script type="text/javascript" src="officepage_info_in.js">
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
