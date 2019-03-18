<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this -> load -> model('user_model');
    }
    public function index()
    {
        $this -> load -> view('header');
        $this -> load -> view('main');
        $this -> load -> view('footer');
    }

    public function loginForm()
    {
        $this -> load -> view('header');
        $this -> load -> view('loginForm');
        $this -> load -> view('footer');
    }

    public function joinForm()
    {
        $this -> load -> view('header');
        $cap = $this->captcha();
        $this -> load -> view('joinForm', array('cap' => $cap));
        $this -> load -> view('footer');
    }

    public function selectOneUser()
    {
        $user_id = $this -> input -> get('user_id',true);
        $user_nickname = $this -> input -> get('user_nickname',true);
        if($user_id != null)
            $user = $this -> user_model -> getUser_by_id($user_id);
        else if($user_nickname != null)
            $user = $this -> user_model -> getUser_by_nick($user_nickname);
        if($user == null){
            echo false;
        }else{
            echo true;
        }
    }

    public function join()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', '아이디', 'required');
        $this->form_validation->set_rules('user_nickname', '닉네임', 'required');
        $this->form_validation->set_rules('user_password', '비밀번호', 'required|min_length[8]|max_length[15]|matches[user_password2]');
        $this->form_validation->set_rules('user_password2', '비밀번호 확인', 'required');
        $this->form_validation->set_rules('user_captcha', '캡차 확인', 'required|matches[captcha_answer]');
        $this->form_validation->set_rules('captcha_answer', '캡차', 'required');

        if($this->form_validation->run() === false) {
            echo "<script> alert('회원가입에 실패하였습니다.');</script>";
            $this->joinForm();
        }else {
            $user_id = $this -> input -> post('user_id',true);
            $user_password = $this -> input -> post('user_password',true);
            $user_password2 = $this -> input -> post('user_password2',true);
            $user_nickname = $this -> input -> post('user_nickname',true);
            $user_gender = $this -> input -> post('user_gender',true);//0 false

            $result = $this->user_model->joinUser($user_id, $user_password, $user_nickname, $user_gender);

            if ($result == true) {
                $this->load->view('header');
                $this->load->view('main');
                $this->load->view('footer');
            } else {
                echo "<script> alert('회원가입에 실패하였습니다.');</script>";
                $this->joinForm();
            }
        }
    }

    public function login()
    {
        $user_id = $this -> input -> post('user_id',true);
        $user_password = $this -> input -> post('user_password',true);
        $result = $this->user_model->getUser_by_id($user_id);
        $get_password = $result->user_password;
        if (password_verify($user_password, $get_password)) {
            $newdata = array(
                'user_id' => $result -> user_id,
                'logged_in' => TRUE
            );
            $this -> session -> set_userdata($newdata);
            echo true;
        } else {
            echo false;
        }
    }

    public function logout(){
        $this -> session -> sess_destroy();
        header('Location: /main');
        exit;
    }

    public function captcha()
    {
        $this->load->helper('captcha');
        $vals = array(
            'word'          => '',
            'img_path'      => './static/img/captcha/',
            'img_url'       => 'http://localhost/static/img/captcha/',
            'font_path'     => './path/to/fonts/texb.ttf',
            'img_width'     => '300',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size'     => 40,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        return $cap;
        //echo $cap['image'];
        //echo $cap['word'];

    }
}