<?php 
    session_start();
    //세션이 존재하는지 클라이언트로부터 요청
    if(isset($_GET['session'])){
        //세션이 존재한다면
        if(isset($_SESSION['username'])) {
            $result['user'] = $_SESSION['username'];
            if($result['user'] == ""){ //세션값이 비어있다면 null 반환
                $result['user'] = 'null';   
            }
        }else {
            $result['user'] = 'null';
        }
        echo json_encode($result);
    }

    if(isset($_POST['session_out'])) {
        $_SESSION['username']=""; //세션 만료 처리
        $result['retCode'] = 0;
        echo json_encode($result);
    }

    //외부 도메인에서 요청이 온 경우
    if(isset($_GET['callback'])){ 
        header('Cache-Control:no-cache');
        header('Pragma:no-cache');
        header('Content-Type:text/html; charset=utf-8');
        
        //세션이 존재한다면
        if(isset($_SESSION['username'])) {
            $result['user'] = $_SESSION['username'];
            if($result['user'] == ""){ //세션값이 비어있다면 null 반환
                $result['user'] = 'null';    
            }
        }else {
            $result['user'] = 'null';
        }
        echo $_GET['callback']."(".json_encode($result).")";
    }

?>