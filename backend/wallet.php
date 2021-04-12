<?php
    header("Access-Control-Allow-Origin: *"); //외부에서 접속 가능하도록 구현
    session_start();
    //외부 도메인에서 요청이 온 경우
    if(isset($_GET['callback'])){
        header('Cache-Control:no-cache');
        header('Pragma:no-cache');
        header('Content-Type:text/html; charset=utf-8');
        $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
        
        //세션이 존재한다면
        if(isset($_SESSION['username'])) {
            $id = $_SESSION['username'];//로그인된 id값
            if($id == "") { //세션값이 비어있다면 null 반환
                $result['wallet'] = 'null';    
            } else {
                if($db) { //데이터베이스가 존재한다면 해당 id의 보유금액 조회
                    $sql = "select star from t_user where id='$id'"; 
                    $res = $db->query($sql);
                    $data = mysqli_fetch_assoc($res);
                    $result['wallet'] = $data['star'];
                }
            }  
        } else {
            $result['wallet'] = 'null';
        }
        echo $_GET['callback']."(".json_encode($result).")";
        mysqli_close($db);
    }

    if(isset($_POST['wallet'])){
        header('Cache-Control:no-cache');
        header('Pragma:no-cache');
        header('Content-Type:text/html; charset=utf-8');
        $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
        $price = $_POST['wallet'];
        $id = $_POST['user'];
        
        if($db) { //데이터베이스가 존재한다면 해당 id의 보유금액 조회
            $sql = "select star from t_user where id='$id'"; 
            $res = $db->query($sql);
            $data = mysqli_fetch_assoc($res);
            $price = $data['star'] + $price;
            $sql = "update t_user set star = '$price' where id='$id'";
            $res = $db->query($sql);
            if($res) {
                $result['retCode'] = 0; //성공적으로 수정된 경우
            }else {
                $result['retCode'] = -1; // 작성이 실패한 경우
            }
            echo json_encode($result);
        } 
        mysqli_close($db);
    }
?>