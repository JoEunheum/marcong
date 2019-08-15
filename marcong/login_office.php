<?php
$servername = "localhost";
$username = "heumheum2";
$password = "dms1gma2#$";
$dbname = "heumDB";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
// // Create connection
// $con=mysqli_connect("localhost","heumheum2","dms1gma2#$","heumDB") or die("fail");
$email =$_POST['email'];
$password = md5($_POST['password']);
$id = $_POST['id'];

$query = "SELECT email, name, subname, password, idnumber FROM office_info WHERE email = '$email'";
$result = mysqli_query($con,$query);
//아이디가 있다면 비밀번호 검사
        if(mysqli_num_rows($result)==1) {
                $row=mysqli_fetch_assoc($result);
                //비밀번호가 맞다면 세션 생성
                if($row['password']==$password){
                        session_start();
                        $_SESSION['idnumber']=$row['idnumber'];
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['subname'] = $row['subname'];
                        $_SESSION['email'] = $row['email'];
                        if(isset($_SESSION['idnumber'])){
                        ?>      <script>
                                        alert("로그인 되었습니다.");
                                        <?php
                                        // 마카롱에서 왔을 때!
                                        if($id){
                                          ?>location.replace("./store_item.php?id=<?php echo $id; ?>"); <?php
                                        }else{
                                          ?>location.replace("./main.php");<?php
                                        }
                                         ?>
                                </script>
                                <?php
                        }
                        else{
                                echo "session fail";
                        }
                }else {
                  ?>
                  <script>
                  alert("아이디 혹은 비밀번호가 잘못되었습니다.");
                  history.back();
                </script>
        <?php
                }
        }else{
          ?>
          <script>
            alert("아이디 혹은 비밀번호가 잘못되었습니다.");
                history.back();
                </script>
<?php
        }
?>
