(async function () {
    const ajax_url = "/backend/replay.php";
    const ajax_type = "GET";
    const ajax_data = {
        replay: 'replay'
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    var result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    if (result) {
        result.video.forEach((video) => {
            const videoDiv = document.createElement("div");
            videoDiv.innerHTML = '<video class="video-fluid" src=/backend/' + video + ' width="500" height="500" controls>';
            videoDiv.setAttribute("class", "col-md-6");
            const h4tag = document.createElement("h4");
            //파일 경로에서 시간만 추출
            video = video.replace("record/","");
            video = video.replace(".mp4","");
            var date = new Date(Number(video));
            h4tag.innerHTML = date.getFullYear()+"년 "+(date.getMonth()+1)+"월 "+date.getDate()+"일 "+date.getHours()+"시 방송";
            videoDiv.appendChild(h4tag);
            const videoContainer = document.getElementById("video_container");
            videoContainer.appendChild(videoDiv);
        });
    }

    // <div class="short_info">
    // <h4><a>콘솔 게임</a></h4>
    // </div>
})();