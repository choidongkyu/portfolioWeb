<?php 
    $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
    $sql = "select count(*) from t_board";
    $res = $db->query($sql);
    $tmp = mysqli_fetch_array($res);
    $total = $tmp[0];
    if(isset($_GET["start"])) {
        $start = $_GET["start"];
    }else {
        $start = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>포트폴리오</title>
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <header class="header_area">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="home_logo" href="index.html">
                        <img src='image/portfolio.png' />
                    </a>
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav justify-content-end">
                            <li class="nav-item active"><a class="nav-link" href="index.html">Home</a></li>
                            <li class="nav-item"><a class="nav-link" id="i_braodcast" href="http://localhost:5000/viewer.html">방송보기</a></li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">포트폴리오</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="portfolio.html?subject=java">Java</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="portfolio.html?subject=android">Android</a></li>
                                    <li class="nav-item"><a class="nav-link" href="portfolio.html?subject=php">PHP</a>
                                    <li class="nav-item"><a class="nav-link" href="replay.html">방송 다시보기</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="board.php">자유게시판</a></li>
                            <li class="nav-item"><a class="nav-link" id="i_manage" href="https://github.com/choidongkyu">MY GITHUB</a>
                            <li class="nav-item"><a class="nav-link" id="i_login_menu" href="login.html">로그인</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <section class="section_gap">
        <div class="container">
            <div class="row">
                <table class="table table-striped" id="i_table">
                    <thread>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>작성일</th>
                        </tr>
                    </thread>
                    <tbody id="i_tbody">
                    </tbody>
                </table>
                <div class="align-self-end ml-auto">
                    <a href="board_write.html" class="btn btn-primary">글쓰기</a>
                </div>
            </div>
        </div>


        <div id="w3-bar">
            <a href="board.php?start=0" class="w3-button">&laquo;</a>
            <?php
                $pages = $total / 5;
                if($pages != 0 && $total % 5 == 0) {
                    $pages = $pages-1;
                }
                for($i=0; $i<=$pages; $i++) {
                    $config = 5 * $i;
                    $page_num = $i+1;
                    if($i == ($start/5)) {
                        echo "<a href=\"board.php?start=$config\" id=\"self-page\">$page_num</a>";
                    }else {
                        echo "<a href=\"board.php?start=$config\" class=\"w3-button\">$page_num</a>";
                    }
                    //echo "<a href=\"board.php?start=$config\" class=\"w3-button\">$page_num</a>";
                }
                
            
            $end = (ceil($total / 5) - 1) * 5;//마지막 페이지
            echo "<a href=\"board.php?start=$end\" class=\"w3-button\">&raquo;</a>"
            ?>
        </div>
    </section>

    <script src="./js/util.js"></script>
    <script src="./js/board.js?ver=23"></script>
</body>

</html>