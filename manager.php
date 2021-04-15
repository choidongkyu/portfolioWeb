<?php 
    $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
    $sql = "select count(*) from t_spon";
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
                            <li class="nav-item"><a class="nav-link" id="i_braodcast"
                                    href="http://localhost:5000/viewer.html">방송보기</a></li>
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
                            <li class="nav-item"><a class="nav-link" id="i_manage"
                                    href="https://github.com/choidongkyu">MY GITHUB</a>
                            <li class="nav-item"><a class="nav-link" id="i_login_menu" href="login.html">로그인</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content text-center">
                    <h2>후원받은 금액</h2>
                    <div class="page_link">
                        <a id="i_spon_price">0원</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="portfolio_details_inner">
                <h2 class="test-title">후원 내역</h2>
            </div>
            <div class="row">
                <table class="table table-striped" id="i_table">
                    <thread>
                        <tr>
                            <th>번호</th>
                            <th>후원 금액</th>
                            <th>후원자</th>
                            <th>날짜</th>
                        </tr>
                    </thread>
                    <tbody id="i_tbody">
                    </tbody>
                </table>
            </div>

            <div id="w3-bar">
            <a href="manager.php?start=0" class="w3-button">&laquo;</a>
            <?php
                $pages = $total / 5;
                if($pages != 0 && $total % 5 == 0) {
                    $pages = $pages-1;
                }
                for($i=0; $i<=$pages; $i++) {
                    $config = 5 * $i;
                    $page_num = $i+1;
                    if($i == ($start/5)) {
                        echo "<a href=\"manager.php?start=$config\" id=\"self-page\">$page_num</a>";
                    }else {
                        echo "<a href=\"manager.php?start=$config\" class=\"w3-button\">$page_num</a>";
                    }
                    //echo "<a href=\"board.php?start=$config\" class=\"w3-button\">$page_num</a>";
                }
                
            
            $end = (ceil($total / 5) - 1) * 5;//마지막 페이지
            echo "<a href=\"manager.php?start=$end\" class=\"w3-button\">&raquo;</a>"
            ?>
        </div>
    </section>
    <script src="./js/util.js"></script>
    <script src="./js/manager.js"></script>
</body>

</html>