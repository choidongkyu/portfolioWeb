$("#i_login_btn").click(async ()=> {
    const id = $("#i_login_id").val();
    const pw = $("#i_login_pw").val();
    //id를 입력하지 않았을 경우
    if(!id) {
        alert("아이디를 입력하세요");
        return;
    }

    if(!pw) {
        alert("비밀번호를 입력하세요");
        return;
    }

    //아이디 비밀번호 입력 후 서버에 검증 요청
    const ajax_url = "/backend/login.php";
    const ajax_type = "POST";
    const ajax_data = {
        id: id,
        pw: pw
    };

    //비동기 처리 위해 await 사용, 데이터 수신
    var result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    if(result['retCode'] == -1) {
        alert("로그인 정보가 올바르지 않습니다.")
    }else {
        location.href = "index.html"
    }
})