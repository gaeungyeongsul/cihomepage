<?php
class Board_model extends CI_Model{
    function __construct()
    {//생성자 - 초기화
        parent::__construct();
    }

    public function gets(){
        return $this -> db -> query('select * from board') -> result();
//        return $this -> db -> query('select * from board') -> result_array();

    }

    public function get($board_no){
        return $this -> db -> get_where('board', array('board_no'=>$board_no)) -> row(); //active 레코드
        //query('select * from board where board_no ='.$board_no) -> result();
        //row : 한건의 데이터만 가져오면 이터레이션 할필요 없음
    }
}
