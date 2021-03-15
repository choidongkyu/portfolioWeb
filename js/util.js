// 서버와 ajax로 통신하기 위한 함수
function nv_ajax(ajax_url, ajax_type, ajax_data) {
  return new Promise((res, rej) => {
    $.ajax({
      // 클라이언트가 요청을 보낼 서버의 URL 주소
      url: ajax_url,
      //http 요청 방식(GET,POST)
      method: ajax_type,
      // HTTP 요청과 함께 서버로 보낼 데이터
      data: ajax_data,
      // 서버에서 보내줄 데이터의 타입
      dataType: "JSON",
      // 통신이 성공적으로 이루어졌을때 이 메소드를 타게 된다
      success: function (data) {
        // 데이터 요청에 대한 응답값
        res(data);
        //return data;
      },
      // 통신이 실패했어도 완료되면 이 메소드를 타게됨
      error: function (request, status, error) {
        rej(new Error(error));
      },
    });
  })
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null ?
    "" :
    decodeURIComponent(results[1].replace(/\+/g, " "));
}

async function getSession() {
  //session이 존재하는지 서버에 요청
  const ajax_url = "/backend/session.php";
  const ajax_type = "GET";
  const ajax_data = {
    session: "session"
  };

  //비동기 처리 위해 await 사용, 데이터 수신
  var result = await nv_ajax(ajax_url, ajax_type, ajax_data);
  //로그인이 되있을 경우
  if (result['user'] != 'null') {
    $("#i_login_menu").text("로그아웃");
    $("#i_login_menu").attr("href", "#");
  } else { //로그인이 안되어 있을 경우
    $("#i_login_menu").text("로그인");
    $("#i_login_menu").attr("href", "login.html");
  }
}
//관리자 계정인지 확인하는 메소드
async function isAdmin() {
  //session이 존재하는지 서버에 요청
  const ajax_url = "/backend/session.php";
  const ajax_type = "GET";
  const ajax_data = {
    session: "session"
  };

  //비동기 처리 위해 await 사용, 데이터 수신
  var result = await nv_ajax(ajax_url, ajax_type, ajax_data);
  //관리자인 경우 result가 super로 옴
  if (result['user'] == "super") {
    return true;
  } else {
    return false;
  }
  //로그인이 되있을 경우
}

async function sessionOut() {
  //session 만료 요청
  const ajax_url = "/backend/session.php";
  const ajax_type = "POST";
  const ajax_data = {
    session_out: "session_out"
  };

  //비동기 처리 위해 await 사용, 데이터 수신
  var result = await nv_ajax(ajax_url, ajax_type, ajax_data);
  if (result['retCode'] == 0) { //정상적으로 세션만료 처리가 되었다면
    alert("로그아웃 되었습니다.");
    location.href = "index.html";
  }
}

$("#i_login_menu").click(() => {
  //세션값이 있어 menu가 로그아웃인 경우 해당 메뉴 클릭시 로그아웃 진행한다.
  if ($("#i_login_menu").text() == "로그아웃") {
    sessionOut();
  }
})

//모든 페이지 마다 session 값을 얻어야 하므로 util.js에서 실행 시킴
getSession();