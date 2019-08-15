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
        <option value="notice">공지</option>
        <option value="event">이벤트</option>
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
        $password = "dms1gma2#$";
        $dbname = "heumDB";

        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $division_after = $_GET['division'];

        ?><script>
          $('#division').val('<?php echo $division_after; ?>')
        </script> <?php

        if($division_after!='all'){
          if($division_after=='notice'){
            $division_after = '공지';
          }else{
            $division_after = '이벤트';
          }
          $query = "SELECT no,division,title,writer,write_day,look_up FROM board WHERE division = '$division_after' ORDER BY no DESC;";
          $result_set = mysqli_query($con, $query);
          $i=0;
          while($row = mysqli_fetch_assoc($result_set)){
            $no[$i] = $row['no'];
            $division[$i] = $row['division'];
            $title[$i] = $row['title'];
            $writer[$i] = $row['writer'];
            $write_day[$i] = $row['write_day'];
            $look_up[$i] = $row['look_up'];
            $i++;
          }
          $len = sizeof($no);
          for($j=$len;$j>0;$j--){
            $tmpno[$len-$j]=$j;
          }
          mysqli_close($con);

        }else{
          $query = "select no,division,title,writer,write_day,look_up from board ORDER BY no DESC;";
          $result_set = mysqli_query($con, $query);
          $i=0;
          while($row = mysqli_fetch_assoc($result_set)){
            $no[$i] = $row['no'];
            $division[$i] = $row['division'];
            $title[$i] = $row['title'];
            $writer[$i] = $row['writer'];
            $write_day[$i] = $row['write_day'];
            $look_up[$i] = $row['look_up'];
            $i++;
          }
          $len = sizeof($no);

          for($j=$len ; $j>0; $j--){
            $tmpno[$len-$j]=$j;
          }
          mysqli_close($con);
        }
        ?>

        <tbody>
          <?php for ($i=0; $i < $len; $i++) {
            ?>
            <tr>
              <th><?php echo $tmpno[$i]; ?></th>
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
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">4</a></li>
          <li class="page-item"><a class="page-link" href="#">5</a></li>
        </ul>
    </div>

    <footer>  <?php include "footer.php" ?></footer>

    <script>
      $('#division').change(function(){
        var value = $(this).val();
        location.replace("./notice.php?division="+value);
      });
    </script>

  </body>

  </html>
