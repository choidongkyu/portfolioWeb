//선택된 과목 정규식으로 파싱
const subject = getParameterByName("subject");

async function main() {
    // 포트폴리오 작품 선택시 홈 로고 변경되어야함 기본 홈화면은 이미지 그려줌
    const subjectLogo = document.getElementById("subject_logo");
    subjectLogo.innerText = subject + " 작품";
    //서버에 subject에 맞게 data 요청
    const ajax_url = "/backend/portfolio.php";
    const ajax_type = "GET";
    const ajax_data = {
        subject: subject,
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    var result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    //subject에 맞게 html 내용 변경
    const leftImage = document.getElementById("left_img");
    leftImage.src = result.image;
    //제목 변경
    const title = document.getElementById("title");
    title.innerText = result.title;

    //콘텐츠 설명 변경
    const contents = document.getElementById("contents");
    contents.innerText = result.contents;

    //개발환경 내용 변경
    const devEnv = document.getElementById("dev_env");
    devEnv.style.display = "inline";
    devEnv.style.fontWeight = 100;
    devEnv.style.fontSize = "14px";
    devEnv.innerText = result.devEnv;

    //개발언어 내용 변경
    const devLang = document.getElementById("dev_lang");
    devLang.style.display = "inline";
    devLang.style.fontWeight = 100;
    devLang.style.fontSize = "14px";
    devLang.innerText = result.devLang;

    //개발서버 내용 변경
    const devServer = document.getElementById("dev_server");
    devServer.style.display = "inline";
    devServer.style.fontWeight = 100;
    devServer.style.fontSize = "14px";
    devServer.innerText = result.devServer;

    //보조 내용 변경
    const subContents = document.getElementById("sub_contents");
    subContents.innerText = result.subContents;

    //server에 있는 video 수대로 html 동적 생성
    if (result.video) {
        result.video.forEach(video => {
            const videoDiv = document.createElement("div");
            videoDiv.innerHTML = '<video class="video-fluid" src=/backend/video/' + video.name + ' width="500" height="500" controls>';
            videoDiv.setAttribute("class", "col-md-6");
            const videoContainer = document.getElementById("video_container");
            videoContainer.appendChild(videoDiv);
        });
    }

    //관리자가 아닌경우 동영상 업로드를 못하도록 막음
    let user = await getUser();
    if (user != "super") {
        $("#upfile").hide();
        $("#i_upload_btn").hide();
    }

}


// 업로드 할 수 있는 파일 확장자를 제한하는 메소드
function extensionCheck() {
    var extArray = new Array('mp4', 'wmv', 'avi');
    var path = document.getElementById("upfile").value;

    if (path == "") {
        swal("파일을 선택해 주세요.");
        return false;
    }

    var pos = path.indexOf(".");

    if (pos < 0) {
        swal("확장자가 없는파일 입니다.");
        return false;
    }

    var ext = path.slice(path.indexOf(".") + 1).toLowerCase();
    var checkExt = false;

    for (var i = 0; i < extArray.length; i++) {
        if (ext == extArray[i]) {
            checkExt = true;
            break;
        }
    }
    if (checkExt == false) {
        swal("업로드 할 수 없는 파일 확장자 입니다.");
        return false;
    }
    return true;
}

function uploadFile() {
    //허용하지 않는 확장자일 경우 return
    if (!extensionCheck()) {
        return;
    }
    var file = document.getElementById('upfile');

    var filedata = new FormData(); // FormData 인스턴스 생성

    filedata.append('upfile', file.files[0]);
    console.log(typeof(file.files[0]));

    var _xml = new XMLHttpRequest();
    _xml.open('POST', '/backend/upload.php?subject=' + subject, true);
    _xml.responseType = 'json';
    _xml.onload = function () {
        console.log(JSON.stringify(_xml.response));
        if (_xml.response["retCode"] == 200) {
            alert('동영상이 업로드 되었습니다.');
            location.reload();
        } else {
            alert('업로드 실패');
        }
    };
    _xml.send(filedata);
};

main();