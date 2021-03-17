let board_id = 0;
//url로 board_id가 넘어 왔다면
if (getParameterByName("board_id")) {
    board_id = parseInt(getParameterByName("board_id")); //문자열을 정수형으로 변환
    getBoard(board_id);
}

//값이 제대로 넘어오지 않았다면
if (board_id == 0) {
    alert("유효하지 않은 값입니다.");
    location.href = "index.html";
}

async function getBoard(board_id) {
    //게시글 목록 가져옴
    //서버에 게시글 등록 요청
    const ajax_url = "/backend/board.php";
    const ajax_type = "GET";
    const ajax_data = {
        request: "get_board",
        board_id: board_id
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    console.log(JSON.stringify(result));
    //기존값 보여주도록 셋팅
    $("#i_text_title").val(result.board_title);
    $("#i_text_content").val(result.board_content);
}


$("#i_write_bt").click(async () => {
    const title = $("#i_text_title").val();
    const content = $("#i_text_content").val();
    //글 제목을 작성하지 않는 경우
    if (!title) {
        alert("글 제목을 작성해 주세요");
        return;
    }
    //내용을 작성하지 않는 경우
    if (!content) {
        alert("글 내용을 작성해 주세요");
        return;
    }

    //서버에 게시글 수정 요청
    const ajax_url = "/backend/board.php";
    const ajax_type = "POST";
    const ajax_data = {
        request: "post_update",
        board_title: title,
        board_id: board_id,
        board_content: content
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    if (result['retCode'] == -1) {
        alert("게시글 수정이 실패 하였습니다.");
    } else {
        alert("게시글이 정상적으로 수정되었습니다.");
        location.href = "board.html"
    }
})