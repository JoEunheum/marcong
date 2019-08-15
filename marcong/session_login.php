<!-- 로그인이 필요할 때 -->
<?php
session_cache_expire(1800); //1800 = 30분동안 세션 유지시간 (그 페이지에만 임의로)
session_start();
if(!isset($_SESSION['email'])) {
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}
 ?>
