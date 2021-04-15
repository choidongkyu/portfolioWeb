<?php
    header("Access-Control-Allow-Origin: *"); //외부에서 접속 가능하도록 구현
    class Board {
        private $db;
        //객체가 생성될때 db연결
        public function __construct(){
            $this->db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
        }

        //날짜를 얻는 메소드
        public function getDate(){
            //mysql에서 날짜를 얻는 메소드
            $sql = "SELECT NOW()";
            $res = $this->db->query($sql);
            $data = mysqli_fetch_row($res);
            return $data[0];
        }

        //게시글 번호를 지정하는 메소드
        public function getNext(){
            //모든 id를 내림차순으로 정렬
            $sql = "select board_id from t_spon order by board_id desc";
            $res = $this->db->query($sql);
            //내림차순으로 정렬된 맨 첫번째 data는 가장 최근의 데이타이므로 +1 하여 리턴
            $data = mysqli_fetch_row($res);
            if($data){
                return $data[0] + 1;
            }
            return 1;
        }

        //게시글 작성 메소드
        public function write($board_title, $board_user_id, $board_content){
            $board_id = $this->getNext();
            $board_date = $this->getDate();

            $sql = "insert into t_spon (board_id, board_title, board_user_id, board_date, board_content, board_available) 
                        value ('$board_id', '$board_title', '$board_user_id', '$board_date', '$board_content', 1)";
            $res = $this->db->query($sql);
            return $res;
        }

        //게시글 리스트를 받아오는 메소드
        public function getList($start){
            $list_number = 5; // 한 페이지에 존재하는 게시판 수
            $sql = "select * from t_spon order by board_id desc limit $start, $list_number";
            $res = $this->db->query($sql);
            while($row = mysqli_fetch_assoc($res)) {
                $list["user"][] = $row;
            }
            return $list;
        }

        //다음 페이지가 있는지 확인하는 메소드
        public function nextPage($pageNumber) {
            $limit_num = $this->getNext() - ($pageNumber-1) * 10;
            //board id 기준으로 내림차순으로 정렬 후 최대 10개만 리스트 가져옴
            $sql = "select * from t_spon where board_id < '$limit_num' and board_available = 1";
            $res = $this->db->query($sql);
            //결과가 하나라도 존재 한다면
            if($row = mysqli_fetch_assoc($res)) {
                return true;
            }
            //하나도 존재하지 않는다면
            return false;
        }

        public function getBoard($board_id) {
            $sql = "select * from t_spon where board_id='$board_id'";
            $res = $this->db->query($sql);
            //결과가 하나라도 존재 한다면
            $row = mysqli_fetch_assoc($res);
            echo json_encode($row);
        }

        public function update($board_id, $board_title, $board_content) {
            $sql = "update t_spon set board_title = '$board_title', board_content = '$board_content' where board_id='$board_id'";
            $res = $this->db->query($sql);
            return $res;
        }

        public function delete($board_id) {
            $sql = "delete from t_spon where board_id=$board_id";
            $res = $this->db->query($sql);
            return $res;
        }
    }

    // $board = new Board();
    // echo $board->getList(0);



    
    if(isset($_POST['request'])) {
        //게시글 작성 요청을 받은 경우
        if($_POST['request'] == "post_write") {
            $board_title = $_POST['board_title'];
            $board_user_id = $_POST['board_user'];
            $board_content = $_POST['board_content'];
            //게시글 담당 객체 생성
            $board = new Board();
            //게시글 작성
            $res = $board->write($board_title, $board_user_id, $board_content);
            if($res) {
                $result['retCode'] = 0; //성공적으로 작성된 경우
            }else {
                $result['retCode'] = -1; // 작성이 실패한 경우
            }
            echo json_encode($result);
        }

        //게시글 수정을 요청받았을 경우
        if($_POST['request'] == "post_update") {
            $board_title = $_POST['board_title'];
            $board_id = $_POST['board_id'];
            $board_content = $_POST['board_content'];
            $board = new Board();
            $res = $board->update($board_id, $board_title, $board_content);
            if($res) {
                $result['retCode'] = 0; //성공적으로 수정된 경우
            }else {
                $result['retCode'] = -1; // 작성이 실패한 경우
            }
            echo json_encode($result);
        }

        //게시글 삭제 요청받았을 경우
        if($_POST['request'] == "post_delete") {
            $board_id = $_POST['board_id'];
            $board = new Board();
            $res = $board->delete($board_id);
            if($res) {
                $result['retCode'] = 0; //성공적으로 수정된 경우
            }else {
                $result['retCode'] = -1; // 작성이 실패한 경우
            }
            echo json_encode($result);
        }

    }

    if(isset($_GET['request'])) {
        //리스트 요청을 햇을 경우
        if($_GET['request'] == "get_list") {
            $start = $_GET['start'];
            $board = new Board();
            $list = $board->getList($start);
            echo json_encode($list);
        }

        //다음페이지가 존재하는지 클라이언트가 요청한 경우
        if($_GET['request'] == "get_next") {
            $board = new Board();
            $page_number = $_GET['page_number'];
            
            //다음 페이지가 존재하는 경우
            if($board->nextPage($page_number)) {
                $result["next_page"] = true;
            }else {
                $result["next_page"] = false;
            }
            echo json_encode($result);
        }

        if($_GET['request'] == "get_board") {
            $board = new Board();
            $board_id = $_GET['board_id'];
            $board->getBoard($board_id);
        }
    }
?>