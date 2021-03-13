// 서버와 ajax로 통신하기 위한 함수
function nv_ajax(ajax_url, ajax_type, ajax_data) {
  return new Promise((res, rej) => {
    //console.log(`${requestUrl}${ajax_url}`);
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