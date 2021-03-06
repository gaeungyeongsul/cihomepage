<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Board extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this -> load -> model('board_model');
    }

    public function index()
    {
        $this->readBoardList();
    }

    public function readBoardList()
    {
        $page = $this->input->get('page', true);
        $numb = $this->input->get('numb', true);
        $data = array(
            'page' => $page,
            'numb' => $numb,
            'type' => $this->input->get('type', true),
            'keyword'=> $this->input->get('keyword', true)
        );
        $search = $this->boardParam($data);
        $search['skip'] = $this->getSkip($search['page'],$search['numb']);
        $board_list = $this->board_model->boardList($search);
        $page_list = $this->pageList($search);

        $this->load->view('header');
        $this->load->view('board_list', array('board_list'=>$board_list, 'page_list'=>$page_list, 'search'=>$search));
        $this->load->view('footer');
    }

    public function readBoardOne(){
        $board_no = $this->input->get('board_no', true);
        $page = $this->input->get('page', true);
        $numb = $this->input->get('numb', true);
        $data = array(
            'page' => $page,
            'numb' => $numb,
            'type' => $this->input->get('type', true),
            'keyword'=> $this->input->get('keyword', true)
        );
        $search = $this->boardParam($data);
        $this->board_model->updateViews($board_no);
        $board = $this->board_model->getBoardOne($board_no);

        $search['skip'] = $this->getSkip($search['page'],$search['numb']);
        $board_list = $this->board_model->boardList($search);
        $page_list = $this->pageList($search);

        $this->load->view('header');
        $this->load->view('boardOne', array('board'=>$board, 'search'=>$search, 'board_list'=>$board_list, 'page_list'=>$page_list));
        $this->load->view('footer');

    }

    public function writeForm()
    {
        if (@$this->session->userdata('logged_in') == TRUE) {
            $this->load->view('header');
            $this->load->view('writeBoardForm');
            $this->load->view('footer');
        }
    }

    public function write()
    {
        if (@$this->session->userdata('logged_in') == TRUE) {
            $user_id = $this->session->userdata('user_id');
            $this->load->model('user_model');
            $user = $this->user_model->getNick_by_id($user_id);
            $param = array(
                'board_content' => $this->input->post('contents'),
                'board_title' => $this->input->post('title',true),
                'board_user_id' => $user_id,
                'board_user_nickname' => $user->user_nickname
            );
            $last_board_no = $this->board_model->insertBoard($param);
            header('Location: /board/readBoardOne?board_no='.$last_board_no);
            exit;
        }
    }

    public function modifyBoardForm()
    {
        $board_no = $this->input->post('board_no', true);
        $board = $this->board_model->getBoardOne($board_no);

        if (@$this->session->userdata('logged_in') == TRUE) {
            if($this->session->userdata('user_id') == $board->board_user_id){
                $this->load->view('header');
                $this->load->view('modifyBoardForm', array('board'=> $board));
                $this->load->view('footer');
            }
        }

    }

    public function modifyBoard()
    {
        $board_user_id = $this->input->post('board_user_id');
        if (@$this->session->userdata('logged_in') == TRUE) {
            if($this->session->userdata('user_id') == $board_user_id) {
                $param = array(
                    'board_no' => $this->input->post('board_no'),
                    'board_content' => $this->input->post('contents'),
                    'board_title' => $this->input->post('title', true)
                );
                $result = $this->board_model->modifyBoard($param);
                header('Location: /board/readBoardOne?board_no=' . $param['board_no']);
                exit;
            }
        }

    }

    public function uploadImg()
    {
        $config['upload_path'] = './static/img/board_img';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        if ( ! ($this->upload->do_upload('file')))
        {
            $error_message = $this->upload->display_errors();
            echo $error_message;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $save_url = $data['upload_data']['file_name'];
            echo $save_url;
        }
    }

    public function deleteBoard()
    {
        $board_no = $this->input->post('board_no', true);
        $board_user_id = $this->input->post('board_user_id', true);
        if (@$this->session->userdata('logged_in') == TRUE) {
            if ($this->session->userdata('user_id') == $board_user_id) {
                echo $this->board_model->deleteBoard($board_no);
            }
        }
    }

    public function pageList($search)
    {
        $end = $this->getEndPage($search['page'], $search['numb']);
        $last = $this->board_model->getLastPage($search);
        if($end > $last){
            $end = $last;
        }else {
            $end = $end;
        }
        $prev = $search['start'] - 1;
        $next = $end + 1;
        $page_array = array(
            'end' => $end,
            'last' => $last,
            'start' => $search['start'],
            'current' => $search['current'],
            'prev' => $prev,
            'next' => $next
        );
        return $page_array;
    }



    public function boardParam($data)
    {
        if(!isset($data['page'])){
            $data['page'] = 1;
        }
        if(! isset($data['numb'])){
            $data['numb'] = 10;
        }
        if(! isset($data['type'])){
           $data['type'] = 0;
        }
        if(isset($data['keyword'])){
            $check_keyword = $data['keyword'];
        }else {
            $check_keyword = '';
        }
        if(is_numeric($data['numb']) && is_numeric($data['page'])){
            $search = array(
                "keyword" => $check_keyword,
                "type" => $data['type'],
                "page" => $data['page'],
                "current" => $data['page'],
                "start" => $this->getStartPage($data['page'], $data['numb']),
                "numb" => $data['numb']
            );
            if($data['type'] == 1) {
                $search['title'] = $check_keyword;
            }else if($data['type'] == 2) {
                $search['content'] = $check_keyword;
            }else if($data['type'] == 3) {
                $search['title'] = $check_keyword;
                $search['content'] = $check_keyword;
            }else if($data['type'] == 4){
                $search['nickname'] = $check_keyword;
            }
            return $search;
        }
    }

    function getStartPage($page, $numb)
    {
        return floor(($page - 1) / $numb) * $numb + 1;
    }

    function getSkip($page, $numb){
        return floor(($page - 1) * $numb);
    }

    function getEndPage($page, $numb){
        return (floor(($page - 1) / $numb) + 1) * 10;
    }

    function getLastPage($search){
        $getCountSql = "select count(*) as count from board where 1 = 0";
        if(isset($search['title'])){
            $getCountSql .= ' or board_title like \'%'.$search['title'].'%\'';
        }
        if(isset($search['content'])){
            $getCountSql .= ' or board_content like \'%'.$search['content'].'%\'';
        }
        if(isset($search['nickname'])){
            $getCountSql .= ' or board_user_nickname like \'%'.$search['nickname'].'%\'';
        }
        if($search['type']==0){
            $getCountSql .= ' or 1 = 1';
        }
        $result = mysqli_query($search['connect'],$getCountSql);
        $data = mysqli_fetch_assoc($result);
        $count = $data['count'];
        return ($count - 1 ) / $search['numb'] + 1;
    }

}
