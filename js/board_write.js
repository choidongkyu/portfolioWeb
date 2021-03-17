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

    //유저 아이디 얻기
    let user = await getUser();
    if(user == "null") {
        console.log("비회원");
        user = "비회원";
    }

    //서버에 게시글 등록 요청
    const ajax_url = "/backend/board.php";
    const ajax_type = "POST";
    const ajax_data = {
        request : "post_write",
        board_title : title,
        board_user : user,
        board_content : content
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    if (result['retCode'] == -1) {
        alert("게시글 등록이 실패 하였습니다.");
    } else {
        alert("게시글이 정상적으로 등록되었습니다.");
        location.href = "board.html"
    }

})