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
    //data setting
    $("#i_view_title_2").text(result.board_title);
    $("#i_view_user_2").text(result.board_user_id);
    $("#i_view_date_2").text(result.board_date);
    $("#i_view_content_2").text(result.board_content);

    //수정버튼 href 링크 변경
    $("#i_view_modify").attr("href", "board_update.html?board_id=" + board_id);
}

//삭제 버튼을 눌렀을 경우
$("#i_view_delete").click(async () => {
    //서버에 게시글 등록 요청
    const ajax_url = "/backend/board.php";
    const ajax_type = "POST";
    const ajax_data = {
        request: "post_delete",
        board_id: board_id
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    if (result['retCode'] == -1) {
        alert("게시글 등록이 실패 하였습니다.");
    } else {
        alert("게시글이 정상적으로 삭제되었습니다.");
        location.href = "board.php"
    }
})