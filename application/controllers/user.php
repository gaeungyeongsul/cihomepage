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
        $this -> load -> view('joinForm');
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
        $user_id = $this -> input -> post('user_id',true);
        $user_password = $this -> input -> post('user_password',true);
        $user_password2 = $this -> input -> post('user_password2',true);
        $user_nickname = $this -> input -> post('user_nickname',true);
        $user_gender = $this -> input -> post('user_gender',true);//0 false

        if($user_password === $user_password2)
            $result = $this->user_model->joinUser($user_id,$user_password,$user_nickname,$user_gender);

        if($result == true){
            $this -> load -> view('header');
            $this -> load -> view('main');
            $this -> load -> view('footer');
        }else{
            echo "<script> alert('회원가입에 실패하였습니다.');</script>";
            $this->joinForm();
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
                    //'email' => $result -> email,
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
}