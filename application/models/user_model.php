<?php
class User_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function gets(){
        return $this -> db -> query('select * from user') -> result();
//        return $this -> db -> query('select * from board') -> result_array();

    }

    public function get($board_no){
        return $this -> db -> get_where('board', array('board_no'=>$board_no)) -> row(); //active 레코드
        //query('select * from board where board_no ='.$board_no) -> result();
        //row : 한건의 데이터만 가져오면 이터레이션 할필요 없음
    }

    public function getUser_by_id($user_id){
        $check_user_id = $this->db->escape($user_id);
        $user = $this -> db -> get_where('user', array('user_id' => $check_user_id))->row();
        return $user;
    }

    public function getUser_by_nick($user_nickname){
        $check_user_nickname = $this->db->escape($user_nickname);
        $user = $this -> db -> get_where('user', array('user_nickname' => $check_user_nickname))->row();
        return $user;
    }

    public function joinUser($user_id, $user_password, $user_nickname, $user_gender){
        $cost = array('cost'=>12);
        $pass = password_hash($user_password, PASSWORD_BCRYPT, $cost);
        $this->db->set('user_join_date', 'NOW()', false);
        $data = array(
            'user_no' => 0,
            'user_id' => $this->db->escape($user_id),
            'user_password' => $pass,
            'user_nickname' => $this->db->escape($user_nickname),
            'user_gender' => $user_gender,
            'user_level' => 0
        );
        return $this->db->insert('user', $data);
    }
    function myErrorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }
    }
}
