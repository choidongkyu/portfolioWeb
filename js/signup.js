//가입하기 버튼을 눌렀을 경우
$("#i_sign_up_submit_btn_renew").click(() => {
    //아이디 중복확인 및 password, email 확인이 정상적으로 되었을 경우
    if (idConformanceTest() && emailConformanceTest() && pwConformanceTest() && pwSameConformanceTest()) {
        const id = $("#i_sign_up_id").val();
        const email = $("#i_sign_up_email").val();
        const pw = $("#i_sign_up_pw").val();
        const data = {
            id: id,
            email: email,
            pw: pw
        };
        signUpRequest(data);
    }
})

async function signUpRequest(ajax_data) {
    const ajax_url = "/backend/signup.php";
    const ajax_type = "POST";

    //비동기 처리 위해 await 사용, 데이터 수신
    const result = await nv_ajax(ajax_url, ajax_type, ajax_data);
    if (result["retCode"] == 200) {
        swal({
            text: "회원가입에 성공하였습니다.",
            confirmButtonText: "확인"
        }).then((value) => {
            if(value) {
                location.href = "login.html"
            }
        })
    } else {
        swal("회원가입이 실패하였습니다. 네트워크를 확인해 주세요.");
    }
}

$("#i_sign_up_id").bind("focusout", () => idConformanceTest());

async function idConformanceTest() {
    //id 입력칸에 입력된 값을 id변수에 담는다.
    const id = $("#i_sign_up_id").val();

    // 닉네임을 입력하지 않았을 경우 닉네임을 입력해달라는 안내 메세지를 화면에 보여줌
    if (!id || id == " ") {
        $("#i_input_err_id").css("color", "red");
        $("#i_input_err_id").text("id를 입력해주세요");
        return false;
    }

    // 공백이 있을 경우 에러메시지 화면에 보여줌
    if (id.search(/\s/) != -1) {
        $("#i_input_err_id").css("color", "red");
        $("#i_input_err_id").text("id는 공백 없이 입력해주세요.");
        return false;
    }

    //id 중복체크 로직
    const ajax_url = "/backend/signup.php";
    const ajax_type = "GET";
    const ajax_data = {
        id: id,
    };
    //비동기 처리 위해 await 사용, 데이터 수신
    var result = await nv_ajax(ajax_url, ajax_type, ajax_data);

    //중복된 id가 있을 경우
    if(result["retCode"] == -1) {
        $("#i_input_err_id").css("color", "red");
        $("#i_input_err_id").text("중복되는 아이디 입니다.");
        return false;
    }
    //모든 체크가 끝난 경우
    else {
        $("#i_input_err_id").text("");
        return true;
    }
}

$("#i_sign_up_email").bind("focusout", () => emailConformanceTest());

function emailConformanceTest() {
    const email = $("#i_sign_up_email").val(); //이메일 입력 칸에 작성한 값을 email이라는 변수에 담는다

    //이메일 정규식(이메일 형식으로 입력했는지)을 확인 할 수 있는 코드
    //아래 형식에 입력값을 넣어 테스트 했을 때 입력값이 이메일 형식이라면 true를 반환한다.
    const re = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

    // 이메일을 입력하지 않았을 경우에 이메일을 입력해달라는 안내 메시지를 띄운다.
    if (!email) {
        $("#i_input_err_email").css("color", "red");
        $("#i_input_err_email").text("이메일을 입력해 주세요. ");
        return false;
    }

    // 이메일 정규식 형식이 올바르지 않을 경우 이메일 형식이 올바르지 않다는 안내 메시지를 띄운다.
    if (!re.test(email)) {
        $("#i_input_err_email").css("color", "red");
        $("#i_input_err_email").text("이메일 형식이 올바르지 않습니다.");
        return false;

        //이메일 입력칸이 공란이 아니고, 이메일 형식에 맞게 입력했을 경우,
    } else {
        $("#i_input_err_email").text("");
        return true;
    }
}



$("#i_sign_up_pw").bind("focusout", () => pwConformanceTest());

function pwConformanceTest() {
    //비밀번호 값을 pw변수에 담음
    const pw = $("#i_sign_up_pw").val();
    //비밀번호를 입력하지 않았을 경우
    if (!pw) {
        $("#i_input_err_pw").css("color", "red");
        $("#i_input_err_pw").text("비밀번호를 입력해 주세요");
        return false;
    } else {
        $("#i_input_err_pw").text("");
        return true;
    }
}

$("#i_sign_up_pw_check").bind("focusout", () => pwSameConformanceTest());

function pwSameConformanceTest() {
    var pw = $("#i_sign_up_pw").val();
    const checkPw = $("#i_sign_up_pw_check").val();
    if (!checkPw) {
        $("#i_input_err_pw_check").css("color", "red");
        $("#i_input_err_pw_check").text("비밀번호 확인란을 입력해 주세요");
        return false;
    }

    if (checkPw != pw) {
        $("#i_input_err_pw_check").css("color", "red");
        $("#i_input_err_pw_check").text("비밀번호가 일치하지 않습니다.");
        return false;
    } else {
        $("#i_input_err_pw_check").text("");
        return true;
    }
}