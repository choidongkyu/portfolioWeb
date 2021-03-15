<?php
    //파일 업로드 요청된 경우
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(file_exists($_FILES['upfile']['tmp_name']) && is_uploaded_file($_FILES['upfile']['tmp_name'])) {
            //중복 피하기 위해 날짜 시간을 파일명으로 지정
            $fileName = date("YmdHis");
            move_uploaded_file($_FILES['upfile']['tmp_name'], "./video/".$_GET["subject"]."/".$fileName.".mp4");
        }
    }
?>