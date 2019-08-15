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

$query_in = "SELECT * FROM personal_info WHERE email = '$email';";
$result_in = mysqli_query($con, $query_in);
$row_in = mysqli_fetch_assoc($result_in);

$name = $row_in['name'];
$birthday = $row_in['date_of_birth'];
$phone_number = $row_in['phone_number'];
mysqli_close($con);

$strday = explode('-', $birthday);
 ?>

<form id="mypage_form" method="post">
       <table class="table table-bordered">
         <tbody>
             <div class="form-group">
               <tr>
                   <th width="15%">이름: </th>
                   <td><input readonly id="title" name="title" type="text" placeholder="이름을 입력하세요. " value="<?php echo $name; ?>" class="form-control onlyHangul"/></td>
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
                   <th>비밀번호<br>확인:</th>
                   <td><input type="password" class="mt-1 form-control" id="pwCheck"  placeholder="비밀번호 확인" maxlength="30" name="password"></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>휴대폰<br>번호:</th>
                   <td><input type="tel" class="mt-1 form-control onlyNumber" id="phoneNumber" data-rule-required="true" placeholder="휴대폰번호 (- 없이 숫자만 입력)" maxlength="11" name="number" value="<?php echo $phone_number; ?>"></td>
               </tr>
             </div>

             <div class="form-group">
               <tr>
                   <th>생년월일: </th>
                   <td>
                     <div class="form-group" id="divBirthDay">
                       <div class="d-inline-flex">
                         <div>
                           <input type="text" class="form-control onlyNumber" id="year" name="year" data-rule-required="true" placeholder="연도 (ex-1995)" maxlength="4" value="<?php echo $strday[0]; ?>">
                         </div>

                         <div>
                           <select class="form-control onlyNumber custom-select" id="month" name="month" style="width:100px;">
                             <option>월</option>
                             <option value="01">01</option>
                             <option value="02">02</option>
                             <option value="03">03</option>
                             <option value="04">04</option>
                             <option value="05">05</option>
                             <option value="06">06</option>
                             <option value="07">07</option>
                             <option value="08">08</option>
                             <option value="09">09</option>
                             <option value="10">10</option>
                             <option value="11">11</option>
                             <option value="12">12</option>
                           </select>
                         </div>

                         <div>
                           <select class="form-control onlyNumber custom-select" id="day" name="day" style="width:100px;">
                             <option>일</option>
                             <option value="01">01</option>
                             <option value="02">02</option>
                             <option value="03">03</option>
                             <option value="04">04</option>
                             <option value="05">05</option>
                             <option value="06">06</option>
                             <option value="07">07</option>
                             <option value="08">08</option>
                             <option value="09">09</option>
                             <option value="10">10</option>
                             <option value="11">11</option>
                             <option value="12">12</option>
                             <option value="13">13</option>
                             <option value="14">14</option>
                             <option value="15">15</option>
                             <option value="16">16</option>
                             <option value="17">17</option>
                             <option value="18">18</option>
                             <option value="19">19</option>
                             <option value="20">20</option>
                             <option value="21">21</option>
                             <option value="22">22</option>
                             <option value="23">23</option>
                             <option value="24">24</option>
                             <option value="25">25</option>
                             <option value="26">26</option>
                             <option value="27">27</option>
                             <option value="28">28</option>
                             <option value="29">29</option>
                             <option value="30">30</option>
                             <option value="31">31</option>
                           </select>
                         </div>
                       </div>
                     </div>
                   </td>
               </tr>

               <script>
                 var birthmonth = "<?php echo  $strday[1]; ?>";
                 var birthday = "<?php echo $strday[2]; ?>";
                 $('#month').val(birthmonth).prop("selected", true);
                 $('#day').val(birthday).prop("selected", true);
               </script>

                 <tr>
                     <td colspan="2">
                         <input id="upload" type="submit" value="변경" class="pull-right btn btn-success" formaction="./mypage_in_db.php"/>
                     </td>
                 </tr>
         </tbody>
       </table>
</form>

<script type="text/javascript" src="mypage_in.js">
</script>
