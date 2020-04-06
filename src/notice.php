<?php session_start();?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>공지&이벤트</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
      <?php include "top.php" ?>
    </header>

    <div class="pull-right sticky-top">
      <?php include "sidemenu.php" ?>
    </div>

    <div class="container">
      <h3>공지&이벤트</h3>
      <hr>
      <select class="custom-control-select" name = "division" id="division">
        <option value="all">전체</option>
        <option value="공지">공지</option>
        <option value="이벤트">이벤트</option>
      </select>

      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th>번호</th>
            <th>분류</th>
            <th class="text-center">제목</th>
            <th class="text-right">작성자</th>
            <th class="text-center">작성일자</th>
            <th class="text-center">조회</th>
          </tr>
        </thead>

        <?php
        $servername = "localhost";
        $username = "heumheum2";
        $password = "password";
        $dbname = "heumDB";

        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $division_after = $_GET['division'];
        $page = ($_GET['page'])?$_GET['page']:1;
        $list = 10;
        $block = 2;

        ?><script>
          $('#division').val('<?php echo $division_after; ?>')
        </script> <?php

        if($division_after!='all'){
          $query = "SELECT no,division,title,writer,write_day,look_up FROM notice WHERE division = '$division_after' ORDER BY no DESC;";
          $result_set = mysqli_query($con, $query);
          $total_count = mysqli_num_rows($result_set);

          $pageNum = ceil($total_count/$list); // 총 페이지
          $blockNum = ceil($pageNum/$block); // 총 블록
          $nowBlock = ceil($page/$block);
          $s_page = ($nowBlock * $block) - ($block - 1);
          if ($s_page <= 1) {
            $s_page = 1;
          }
          $e_page = $nowBlock*$block;
          if ($pageNum <= $e_page) {
            $e_page = $pageNum;
          }
          $s_point = ($page-1) * $list;
          $query_division = "SELECT no,division,title,writer,write_day,look_up FROM notice WHERE division = '$division_after' ORDER BY no DESC LIMIT $s_point, $list;";
          $result_division = mysqli_query($con, $query_division);

          $i=0;
          while($row = mysqli_fetch_assoc($result_division)){
            $no[$i] = $row['no'];
            $division[$i] = $row['division'];
            $title[$i] = $row['title'];
            $writer[$i] = $row['writer'];
            $write_day[$i] = $row['write_day'];
            $look_up[$i] = $row['look_up'];
            $i++;
          }
          $len = sizeof($no);
          // for($j=$len;$j>0;$j--){
          //   $tmpno[$len-$j]=$j;
          // }
          mysqli_close($con);

        }else{
          $query = "SELECT no,division,title,writer,write_day,look_up FROM notice ORDER BY no DESC;";
          $result_set = mysqli_query($con, $query);
          $total_count = mysqli_num_rows($result_set);

          $pageNum = ceil($total_count/$list); // 총 페이지
          $blockNum = ceil($pageNum/$block); // 총 블록
          $nowBlock = ceil($page/$block);
          $s_page = ($nowBlock * $block) - ($block - 1);
          if ($s_page <= 1) {
            $s_page = 1;
          }
          $e_page = $nowBlock*$block;
          if ($pageNum <= $e_page) {
            $e_page = $pageNum;
          }
          $s_point = ($page-1) * $list;
          $query_notice = "SELECT no,division,title,writer,write_day,look_up FROM notice ORDER BY no DESC LIMIT $s_point, $list;";
          $result_notice = mysqli_query($con, $query_notice);
          $i=0;
          while($row = mysqli_fetch_assoc($result_notice)){
            $no[$i] = $row['no'];
            $division[$i] = $row['division'];
            $title[$i] = $row['title'];
            $writer[$i] = $row['writer'];
            $write_day[$i] = $row['write_day'];
            $look_up[$i] = $row['look_up'];
            $i++;
          }
          $len = sizeof($no);

          // if($total_count > $len){
          //     $plus = $total_count-$len;
          //     for($j=$len ; $j>0; $j--){
          //       $tmpno[$len-$j]=$j+$plus;
          //     }
          // }else{
          //
          // }


          mysqli_close($con);
        }
        ?>

        <tbody>
          <?php for ($i=0; $i < $len; $i++) {
            ?>
            <tr>
              <th><?php echo $no[$i]; ?></th>
              <th><?php echo $division[$i]; ?></th>
              <th class="text-center"><a href="notice_show.php?no=<?php echo $no[$i]; ?>"><?php echo $title[$i]; ?></a></th>
              <th class="text-right"><?php echo $writer[$i]; ?></th>
              <th class="text-center"><?php echo $write_day[$i]; ?></th>
              <th class="text-center"><?php echo $look_up[$i]; ?></th>
            </tr> <?php
          }mysqli_close($con);?>

        </tbody>
      </table>
      <hr>
      <?php if(isset($_SESSION['admin'])){?>
      <input type="button" class="btn btn-primary pull-right" value="글쓰기" onClick="javascript:location.href='notice_write.php'"/><?php
    }?>

    <ul class="pagination justify-content-center">
      <?php
      if($s_page != 1){
        ?>
        <li class="page-item"><a class="page-link" href="<?php $PHP_SELP?>?page=<?php echo $s_page-1; ?>&division=<?php echo $division_after; ?>">이전</a></li>
        <?php
      }
      for ($p=$s_page; $p<=$e_page; $p++) {
        ?>
        <li class="page-item"><a class="page-link" href="<?php $PHP_SELP?>?page=<?php echo $p;?>&division=<?php echo $division_after; ?>"><?php echo $p;?></a></li>
        <?php
      }
      if($e_page != $pageNum){
        ?>
        <li class="page-item"><a class="page-link" href="<?php $PHP_SELP?>?page=<?php echo $e_page+1; ?>&division=<?php echo $division_after; ?>">다음</a></li>
        <?php
      }
      ?>

    </ul>

    </div>

    <footer>  <?php include "footer.php" ?></footer>

    <script>
      $('#division').change(function(){
        var value = $(this).val();
        location.replace("./notice.php?page=1&division="+value);
      });
    </script>

  </body>

  </html>
