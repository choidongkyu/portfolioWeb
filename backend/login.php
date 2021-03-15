<?php
    session_start();
    error_reporting(1);
    ini_set("display_errors", 1);
    //로그인 요청이 온 경우
    if(isset($_POST["id"])) {
        $id = $_POST["id"];
        $pw = $_POST["pw"];
        //중복검사를 위한 데이터 조회
        $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
        if($db) {
            $sql = "select * from t_user where id='$id' and password='$pw'";
            $res = $db->query($sql);
            $data = mysqli_fetch_assoc($res);

            //데이터베이스에 해당 로그인 정보가 있다면 세션 등록
            if($data) {
                $_SESSION['username'] = $data["id"];
                $result["retCode"] = 0;
                echo json_encode($result);
            }else { //로그인 정보가 올바르지 않을 경우
                $result["retCode"] = -1;
                echo json_encode($result);
            }
        }
        mysqli_close($db);
    }
?>
