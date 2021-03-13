<?php
    //파일 업로드 요청된 경우에만 파일 서버에 이동
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(file_exists($_FILES['upfile']['tmp_name']) && is_uploaded_file($_FILES['upfile']['tmp_name'])) {
            $fileName = date("YmdHis");
            move_uploaded_file($_FILES['upfile']['tmp_name'], "./video/".$_GET["subject"]."/".$fileName.".mp4");
        }
    }
?>