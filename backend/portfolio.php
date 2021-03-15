<?php 
    if(isset($_GET["subject"])) {
        //subject별 DATA 설정
        $data["image"] = "/image/portfolio/".$_GET["subject"]."-01.png";
        if($_GET["subject"] === "java") {
            $data["title"] = "JAVA-리그오브레전드";
            $data["contents"] = "라이엇의 게임인 리그오브레전드를 오마주로 턴제 게임으로 각색하였습니다. 탑, 미드 , 바텀과 각 라인에 맞는 여러 챔피언을 선택하여서 컴퓨터와 3vs3 대전을 할 수 있도록 게임 을 만들었습니다";
            $data["devEnv"] = "inteliJ";
            $data["devLang"] = "JAVA";
            $data["devServer"] = "없음";
            $data["subContents"] = "쓰레드를 사용하여 콘솔창에서 리그오브레전드 턴제 게임 구현";
        } 
        
        elseif($_GET["subject"] === "android") {
            $data["title"] = "ANDROID-나만의 노래방";
            $data["contents"] = "집에서 노래방의 모든 곡들을 부를 수 있는 애플리케이션입니다. 총 2만개의 곡들이 서버에 저장되어 있어 금영노래방의 모든 곡들을 이용하실 수 있습니다.";
            $data["devEnv"] = "안드로이드 스튜디오, wls, express";
            $data["devLang"] = "JAVA, PYTHON, html, js, css";
            $data["devServer"] = "FIREBASE, node.js";
            $data["subContents"] = "파이썬을 활용하여 유튜브에 있는 노래방 이용가능 하도록 구현, 친구와 영상통화 및 FCM 으로 푸쉬기능 구현";
        } 
        
        else {
            $data["title"] = "포트폴리오 준비중";
            $data["contents"] = "빠른 시일내에 만들겠습니다";
            $data["devEnv"] = "";
            $data["devLang"] = "";
            $data["devServer"] = "";
            $data["subContents"] = "";
        }

        $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
        if($db) {
            $subject = $_GET["subject"];
            //database 쿼리 시작       
            $sql = "select name from t_video where subject='$subject'";
            $res = $db->query($sql);
            if($res){
                while($row = mysqli_fetch_assoc($res)) {
                    $data["video"][] = $row;
                }
            }
            
        }

        //$data["video"] = glob('video/'.$_GET["subject"].'/*');
        //json 형태로 인코딩 후 클라이언트에 data 전달
        echo json_encode($data);
    }
?>