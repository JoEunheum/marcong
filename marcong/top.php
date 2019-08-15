<?php session_start();?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="top.css">
      <style>
        .border {
          display:inline-block;
        }
      </style>
    </head>
    <body>
      <div class="container">
        <header>
          <div class="row">
            <div class="col-sm-8">
              <ul class="list-group list-group-flush list-group-horizontal">

                <?php
                if(!isset($_SESSION['email']) && !isset($_SESSION['idnumber'])){
                  ?>
                  <li class="list-group-item borderless"><a class="text-dark  nounderline" href="login.php">로그인</a></li>
                  <li class="list-group-item borderless"><a class="text-dark  nounderline" href="signup.php">회원가입</a></li> <?php
                }else if(isset($_SESSION['idnumber'])){
                  ?>
                  <li class="list-group-item borderless"><a class="text-dark  nounderline" href="logout.php">로그아웃</a></li>
                  <li class="list-group-item borderless"><a class="text-dark nounderline" href="officepage_info.php">업체페이지</a></li>
                  <?php
                }
                else if(isset($_SESSION['email'])){?>
                  <li class="list-group-item borderless"><a class="text-dark  nounderline" href="logout.php">로그아웃</a></li>
                  <li class="list-group-item borderless"><a class="text-dark nounderline" href="mypage.php">마이페이지</a></li>
                  <li class="list-group-item borderless"><a class="text-dark nounderline" href="lookup.php">예약조회</a></li>
                  <li class="list-group-item borderless"><a class="text-dark nounderline" href="basket.php">장바구니</a></li>
                  <li class="list-group-item borderless"><a class="text-dark nounderline" href="wishlist.php">관심상품</a></li>
                  <?php
                }?>
                <li class="list-group-item borderless"><a class="text-dark nounderline" href="board.php">Q&A</a></li>
                </ul>
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-3">
              <div class="search-container">
                <form method="get" action="search_page.php">
                  <div class="input-group-prepend">
                    <input type="text" placeholder="Search.." name="search">
                      <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
              </div>
            </div>

          </div>
          </br>
        </br>
          <div class="row">
          <div class="col-sm-5"></div>
          <div class="sol-sm-4">
              <h1 class="logo"><a class="text-dark nounderline" href="main.php">MarCong</a></h1>
          </div>
        <div class="col-sm-3"></div>
      </div>
        </header>

        <nav class="navbar navbar-expand-sm justify-content-center sticky-top naverbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="intro.php">소개</a></li>
            <li class="nav-item">
              <a class="nav-link" href="store.php">마카롱</a></li>
            <li class="nav-item">
              <a class="nav-link" href="notice.php?division=all">공지&이벤트</a></li>
          </ul>
        </nav>
      </div>

    </body>
</html>
