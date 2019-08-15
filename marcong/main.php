<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>말콩</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet"type="text/css" href="mainslider.css">

</head>

<body>

    <header>
      <?php include "top.php" ?>
    </header>

    <div class="container-fluid">
      <div class="row">
        <div class="col">
        </div>
        <div class="col">
          <div id="slider-wrap">
            <ul id="slider">
              <li>
                <img class="img-responsive" src="./marc_img/marcong1.jpg">
              </li>

              <li>
                <div>
                  <h3>Slide #2</h3>
                  <span>Sub-title #2</span>
                </div>
                <img class="img-responsive" src="./marc_img/marcong2.jpg">
              </li>

              <li>
                <div>
                  <h3>Slide #3</h3>
                  <span>Sub-title #3</span>
                </div>
                <img class="img-responsive" src="./marc_img/marcong3.png">
              </li>

              <li>
                <div>
                  <h3>Slide #4</h3>
                  <span>Sub-title #4</span>
                </div>
                <img src="https://fakeimg.pl/350x200/0A6E0A/000?text=44444">
              </li>

              <li>
                <div>
                  <h3>Slide #5</h3>
                  <span>Sub-title #5</span>
                </div>
                <img src="https://fakeimg.pl/350x200/0064CD/000?text=55555">
              </li>
            </ul>

            <div class="slider-btns" id="next"><span>▶</span></div>
            <div class="slider-btns" id="previous"><span>◀</span></div>

            <div id="slider-pagination-wrap">
              <ul>
              </ul>
            </div>
          </div>

        </div>
        <div class="col">
          <div class="sticky-top">
            <?php include "sidemenu.php" ?>
          </div>
        </div>
      </div>

  </div>

    <!-- <article>
      <iframe name="main_area" src="" seamless="false" align="center" width="700px" height="600px" frameborder="0px" scrolling="no"></iframe>
    </article>
    <aside>
      <table hidden="440px">
        <tr>
          <p align="center">
            <br>
            <a href="http://facebook.com">페이스북</a><br><br>
            <a href="http://twiter.com">트위터</a><br><br>
            <a href="http://blog.naver.com">블로그</a><br><br>
            <a href="http://instargram.com">인스타그램</a><br><br>
          </p>
        </tr>
      </table>
    </aside>
    <footer>
      ::: Contact us : 0000@gmail.com :::
    </footer>
  </div> -->
  <footer>
    <?php include "footer.php" ?>
  </footer>
    <script type="text/javascript" src="mainslider.js">
    </script>

</body>

</html>
