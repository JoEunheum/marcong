<?php
session_cache_expire(1800); //1800 = 30분동안 세션 유지시간 (그 페이지에만 임의로)
session_start();
if(!isset($_SESSION['admin'])) {
	echo "<meta http-equiv='refresh' content='0;url=notice.php'>";
	exit;
}
 ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>글쓰기</title>
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
  <h3>글쓰기</h3>
  <hr>
  <table class="table table-bordered">
    <thead>
    </thead>
    <tbody>
      <form method="post" encType="multipart/form-data">
            <tr>
                <th>제목: </th>
                <td><input id="title" name="title" type="text" placeholder="제목을 입력하세요. " class="form-control"/></td>
            </tr>

            <tr>
              <th>분류: </th>
              <td>
                <select class="form-control custom-control-select" name = "division" id="division">
                  <option value="notice">공지</option>
                  <option value="event">이벤트</option>
              </select>
            </td>
            </tr>

            <tr>
                <th>내용: </th>
                <td><textarea id="comment" name="comment" rows="20" placeholder="내용을 입력하세요. " class="form-control"></textarea></td>
            </tr>
            <tr>
                <th>첨부파일: </th>
                <td><input type="file" class="form-control-file border" name="pic", id="pic"/></td>
            </tr>
            <tr>
                <th>이미지: </th>
                <td><img class="img-fluid mx-auto d-block" id="image" src="NO-IMAGE.png" width="500" height="500"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input id="upload" type="submit" value="등록" class="pull-right btn btn-success" formaction="./notice_db.php"/>
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
      var check_upload = confirm("글을 올리시겠습니까?");
        if(check_upload){
					return check_upload;
        }else{
          return check_upload;
        }
    });
    </script>
  </body>
  </html>
