<?php
    //파일 업로드 요청된 경우
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
        if($db) {
            //파일 업로드시 임시 경로에 정상적으로 파일이 있을 경우
            if(file_exists($_FILES['upfile']['tmp_name']) && is_uploaded_file($_FILES['upfile']['tmp_name'])) {
                //파일 이름
                $name = $_FILES['upfile']['name'];
                //파일 이름 공백제거
                $name = preg_replace("/\s+/", "", $name);
                //과목 이름
                $subject = $_GET["subject"];
                //파일 사이즈
                $size = filesize($_FILES['upfile']['tmp_name']);
                //업로드된 날짜
                $date = date("YmdHis");
                //지정한 경로에 동영상 업로드
                move_uploaded_file($_FILES['upfile']['tmp_name'], "./video/".$name);

                //database 쿼리 시작       
                $sql = "insert into t_video (name, subject, size, date) values ('$name', '$subject', '$size', '$date')";
                $res = $db->query($sql);
                //정상적으로 데이터베이스가 생성 될 경우
                if($res) {
                    $result["retCode"] = 200;
                    echo json_encode($result);
                }
                else {//정상적으로 데이터베이스가 생성되지 않을 경우
                    $result["retCode"] = 202;
                    echo json_encode($result);
                }
            }
        }
        mysqli_close($db);
    }
?>