<?php
header("Access-Control-Allow-Origin: *"); //외부에서 접속 가능하도록 구현
header('content-type: video/webm');
foreach(array('video', 'audio') as $type) {
    if (isset($_FILES["${type}-blob"])) {

        $fileName = $_POST["${type}-filename"];
        $uploadDirectory = './record/'.$fileName;

        if (!move_uploaded_file($_FILES["${type}-blob"]["tmp_name"], $uploadDirectory)) {
            $result["retCode"] = 202;//파일 업로드가 정상적으로 이루어지지 않앗을때
            echo json_encode($result);
        } else {
            $result["retCode"] = 200;//정상적으로 완료된 경우
            echo json_encode($result);
        }
    }
}
?>