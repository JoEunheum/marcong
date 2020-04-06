<?php
session_start();
session_cache_expire(1800); //1800 = 30분동안 세션 유지시간 (그 페이지에만 임의로)
if(!isset($_SESSION['admin'])) {
	echo "<meta http-equiv='refresh' content='0;url=notice.php'>";
	exit;
}
$servername = "localhost";
$username = "heumheum2";
$password = "password";
$dbname = "heumDB";

$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$no = $_GET['no'];
$query_info = "select * from notice where no = '$no'";
$result_set = mysqli_query($con, $query_info);
$row = mysqli_fetch_assoc($result_set);
$division = $row['division'];
$title = $row['title'];
$writer = $row['writer'];
$write_day = $row['write_day'];
$image_URL = $row['image_url'];
$look_up = $row['look_up'];
$comment = $row['comment'];

 ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>편집</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
      <?php include "top.php" ?>
    </header>
<div class="container">
  <h3>편집</h3>
  <hr>
  <table class="table table-bordered">
    <thead>
    </thead>
    <tbody>
      <form method="post" encType="multipart/form-data">
            <tr>
                <th>제목: </th>
                <td><input id="title" name="title" type="text" placeholder="제목을 입력하세요. " class="form-control" value="<?php echo $title; ?>"/></td>
            </tr>

            <tr>
              <th>분류: </th>
              <td>
                <select class="form-control custom-control-select" name = "division" id="division">
                  <?php if($division=="공지"){
                    ?>
                    <option value="notice" selected>공지</option>
                    <option value="event">이벤트</option>
                    <?php
                  }else{
                    ?>
                    <option value="notice">공지</option>
                    <option value="event" selected>이벤트</option>
                    <?php
                  } ?>
              </select>
            </td>
            </tr>

            <tr>
                <th>내용: </th>
                <td><textarea id="comment" name="comment" placeholder="내용을 입력하세요. " class="form-control" rows="20"><?php echo $comment; ?></textarea></td>
            </tr>
            <tr>
                <th>첨부파일: </th>
                <td><input type="file" class="form-control-file border" name="pic", id="pic"/></td>
            </tr>
            <tr>
                <th>이미지: </th>
                <td><img class="img-fluid mx-auto d-block" id="image" src="<?php echo $image_URL; ?>" width="500" height="500"/>
                  <input type="text" name="image" id="imagename" value="<?php echo $image_URL; ?>" hidden>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input id="upload" type="submit" value="편집" class="pull-right btn btn-success" formaction="./notice_edit_db.php?no=<?php echo $no; ?>"/>
                    <input type="button" class="btn btn-secondary" value="글 목록으로... " class="pull-left" onclick="javascript:location.href='notice.php'"/>
                </td>
            </tr>
        </form>
    </tbody>
  </table>

</div>

    <footer>  <?php include "footer.php" ?></footer>

    <script>
      function readURL(input){
        if(input.files && input.files[0]){
          var reader = new FileReader();
          reader.onload = function(e){
            $('#image').attr('src', e.target.result);
            $('#imagename').attr('value',e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#pic").change(function(){
        readURL(this);
      });
    </script>

    <script>
    $("#upload").click(function(){
			var title_val = $("#title").val();
      if(!title_val){
        alert('제목을 입력해주세요.');
				return false;
      }
			var comment = $("#comment").val();
			if(!comment){
				alert('내용을 입력해주세요.');
				return false;
			}
      var check_upload = confirm("글을 편집하시겠습니까?");
        if(check_upload){
					return check_upload;
        }else{
          return check_upload;
        }
    });
    </script>
  </body>
  </html>
