let start = 0;

//url로 pagenumber가 넘어 왔다면
if (getParameterByName("start")) {
    start = parseInt(getParameterByName("start")); //문자열을 정수형으로 변환
}

async function getNext(start) {
    //게시글 목록 가져옴
    //서버에 게시글 등록 요청
    const ajax_url = "/backend/board.php";
    const ajax_type = "GET";
    const ajax_data = {
        request: "get_next",
        start: start
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    //요청한 페이지 수가 존재한다면 true 반환
    if (result['next_page'] == true) {
        return true;
    } else { //요청한 페이지가 존재하지 않는다면 false 반환
        return false;
    }
}


async function getList(start) {
    //게시글 목록 가져옴
    //서버에 게시글 등록 요청
    const ajax_url = "/backend/board.php";
    const ajax_type = "GET";
    const ajax_data = {
        request: "get_list",
        start: start
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    //server에 있는 게시글 수대로 html 동적 생성
    if (result.user) {
        result.user.forEach(user => {
            const board_id_td = document.createElement("td");
            board_id_td.innerHTML = user.board_id;

            const board_title_td = document.createElement("td");
            board_title_td.innerHTML = '<a href="view.html?board_id=' + user.board_id + '">' + user.board_title + '</a>'

            const board_user_td = document.createElement("td");
            board_user_td.innerHTML = user.board_user_id;

            const board_date_td = document.createElement("td");
            board_date_td.innerHTML = user.board_date;

            const tr = document.createElement("tr");
            tr.appendChild(board_id_td);
            tr.appendChild(board_title_td);
            tr.appendChild(board_user_td);
            tr.appendChild(board_date_td);

            const tbody = document.getElementById("i_tbody");
            tbody.appendChild(tr);
        });
    }
}

//리스트를 얻어온후 html에 뿌려줌
getList(start);