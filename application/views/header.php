<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <title>프로젝트</title>
    <link rel="stylesheet" href="/static/css/style.css">


</head>
<body>
<header>
    <div class="container">
        <div class="header_logo">
            <div class="user_nav">
                <ul>
                    <?php
                    if ( @$this -> session -> userdata('logged_in') == FALSE) {
                        ?>
                        <li><a href="/user/loginForm">로그인</a></li>
                        <li><a href="/user/joinForm">회원가입</a></li>
                        <?php
                    }else{
                        ?>
                        <li><a href="user/logout">로그아웃</a></li>
                        <li><a href="#">마이페이지</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <a href="/main"><img src="/static/img/logo.PNG"></a>
        </div>
        <div class="header_nav">
            <ul>
                <li><a href="/main">HOME</a></li>
                <li><a href="/map">지도</a></li>
                <li><a href="/board/readBoardListView.php">게시판</a></li>
            </ul>
        </div>
    </div>
</header>
