<?php
session_cache_expire(1800); //1800 = 30분동안 세션 유지시간 (그 페이지에만 임의로)
session_start();
if(!isset($_SESSION['idnumber'])) {
	echo "<meta http-equiv='refresh' content='0;url=store.php'>";
	exit;
}
 ?>

 <!DOCTYPE html>
 <html lang="ko">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
     <title>올리기</title>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
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
       <h3>올리기</h3>
       <hr>
       <form method="post" encType="multipart/form-data">
       <table class="table table-bordered">
         <thead>
         </thead>
         <tbody>

                 <tr>
                     <th>대표메뉴: </th>
                     <td>
                       <table id="addTable"  class="table table-borderless">
     			             <tr>
     			               <td>
     											 <div class="form-group">
                            <div class="input-group">
                              <input id="menu" name="menu[]" type="text" placeholder="메뉴를 적어주세요." class="form-control"/>
        											  <input id="price" name="price[]" type="text" onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' placeholder="가격을 적어주세요." class="form-control" style="ime-mode:disabled;"/>
																<input id="number_create" type="number" name="number_create[]" placeholder="개수를 입력해주세요." class="form-control" >
                                <div class="input-group-append">
                                  <input class="btn btn-success form-control" type="button" value="추가" onClick="insRow()">
                                </div>

                            </div>

     											 </div>
     										 </td>
     			             </tr>
     			           </table>

                     </td>
                 </tr>

                 <tr>
                     <th>첨부파일: </th>
                     <td><input type="file" class="form-control-file border" name="pic[]", id="pic" multiple/></td>
                 </tr>

                 <tr>
                     <th>이미지: </th>
                     <td>
                       <div class="gallery" style="overflow-x: auto; width:80; margin:0 auto;">

                     </div>
                     </td>
                 </tr>

                 <tr>
                     <td colspan="2">
                         <input id="upload" type="submit" value="등록" class="pull-right btn btn-success" formaction="./store_db.php"/>
                         <input type="button" class="btn btn-secondary" value="목록으로 " class="pull-left" onclick="javascript:history.back();"/>
                     </td>
                 </tr>
         </tbody>
       </table>
</form>
     </div>

     <script language="javascript">
     <!--
     var oTbl;
     //Row 추가
     function insRow() {
       oTbl = document.getElementById("addTable");
       var oRow = oTbl.insertRow();
       var num = oTbl.rows.length-1;
       oRow.onmouseover=function(){oTbl.clickedRowIndex=this.rowIndex}; //clickedRowIndex - 클릭한 Row의 위치를 확인;
       var oCell = oRow.insertCell();
       //삽입될 Form Tag
       var frmTag ='<div class="form-group">'+
          '   <div class="input-group">'+
          '   <input id="menu" name="menu[]" type="text" placeholder="메뉴를 적어주세요." class="form-control"/>'+
          ' <input id="price" name="price[]" type="text" onkeydown="return onlyNumber(event)" onkeyup="removeChar(event)" placeholder="가격을 적어주세요." class="form-control" style="ime-mode:disabled;"/>'+
					'<input id="number_create" type="number" name="number_create[]" placeholder="개수를 입력해주세요." class="form-control" >'+
          '<div class="input-group-append">'+
          '<input class="btn btn-danger form-control" type="button" value="삭제" onClick="removeRow()"></div></div></div>';
       oCell.innerHTML = frmTag;
     }
     //Row 삭제
     function removeRow() {
       oTbl.deleteRow(oTbl.clickedRowIndex);
     }


     //-->
     </script>

         <script>
         $(function() {
           // Multiple images preview in browser
           var imagesPreview = function(input, placeToInsertImagePreview)
           {
             if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img id="img['+i+']"class="img-fluid" width="250" height="250">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
      };

    $('#pic').on('change', function() {
        $('div.gallery').empty();
        imagesPreview(this, 'div.gallery');
      });
    });
         </script>

         <script>

         $("#upload").click(function(){

          var menu = $("#menu").val();
          var price = $('#price').val();
					var number_create = $('#number_create').val()
          if(!menu || !price || !number_create){
            alert('메뉴와 가격, 개수를 입력해주세요.');
            return false;
          }

          var pic = $("#pic").val();
          if(!pic){
            alert('최소 한 장의 이미지를 넣어주세요.');
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

     </div>

     <footer>
       <?php include "footer.php" ?>
     </footer>
   </body>
   </html>
