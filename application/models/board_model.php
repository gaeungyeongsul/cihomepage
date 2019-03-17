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

    public function boardList($search)
    {
        //get_where('board', array('id' => $id), $limit, $offset);
        //$this->db->where(true);

        $this->db->where('1=', 0);
        if(isset($search['title'])){
            $this->db->or_like('board_title', $search['title']);
        }
        if(isset($search['content'])){
            $this->db->or_like('board_content', $search['content']);
        }
        if(isset($search['nickname'])){
            $this->db->or_like('board_nickname', $search['nickname']);
        }
        if($search['type'] == 0){
            $this->db->or_where('1=', 1);
        }
        $this->db->order_by("board_no", "desc");
        $query = $this->db->get('board',$search['numb'], $search['skip']);
        $board_list = array();
        foreach ($query->result() as $row)
        {
            array_push($board_list, $row);
        }
        return $board_list;
    }

    function getLastPage($search){
        $this->db->where('1=', 0);
        if(isset($search['title'])){
            $this->db->or_like('board_title', $search['title']);
        }
        if(isset($search['content'])){
            $this->db->or_like('board_content', $search['content']);
        }
        if(isset($search['nickname'])){
            $this->db->or_like('board_nickname', $search['nickname']);
        }
        if($search['type'] == 0){
            $this->db->or_where('1=', 1);
        }
        $this->db->from('board');
        $total = $this->db->count_all_results();
        return floor(($total - 1 ) / $search['numb']) + 1;
    }

    public function getBoardOne($board_no)
    {
        return $this -> db -> get_where('board', array('board_no'=>$board_no)) -> row(); //active 레코드
        //query('select * from board where board_no ='.$board_no) -> result();
        //row : 한건의 데이터만 가져오면 이터레이션 할필요 없음
    }

    public function updateViews($board_no)
    {
        $this->db->where('board_no', $board_no);
        $this->db->set('board_views', '`board_views`+1', FALSE);
        return $this->db->update('board');
    }

    public function insertBoard($param)
    {
        $this->db->set('board_write_date', 'NOW()', false);
        $data = array(
            'board_no' => 0,
            'board_user_id' => $param['board_user_id'],
            'board_user_nickname' => $param['board_user_nickname'],
            'board_title' => $param['board_title'],
            'board_content' => $param['board_content'],
            'board_views' => 0
        );
        $this->db->insert('board', $data);
        return $this->db->insert_id();

    }
    public function modifyBoard($param)
    {
        $this->db->where('board_no',  $param['board_no']);
        $data = array(
            'board_title' => $param['board_title'],
            'board_content' => $param['board_content']
        );
        return $this->db->update('board', $data);
    }

    public function deleteBoard($board_no)
    {
        return $this->db->delete('board',array('board_no'=>$board_no));
    }
}
