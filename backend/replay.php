<?php 
    if(isset($_GET["replay"])) {
        $data["video"] = glob('record/*');
        //$data["video"] = glob('video/'.$_GET["subject"].'/*');
        //json 형태로 인코딩 후 클라이언트에 data 전달
        echo json_encode($data);
    }
?>