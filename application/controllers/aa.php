<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Aa extends CI_Controller {
	function __construct()
	{//생성자 - 초기화
		parent::__construct();
		$this -> load -> database();
		$this -> load -> view('header');
		$this -> load -> model('board_model');
	}

	public function index($id)
	{
		$this -> load -> view('get', array('id'=>$id));
		$this -> load -> view('footer');

	}

	public function bb($id)
	{
		$this -> load -> database();
		$data = $this -> board_model -> gets();
		/*
		foreach ($data as $entry){
			//var_dump($entry->board_title);//(->result, object형식으로 옴)
			//var_dump($entry['board_title']);//((->result_array, array형식으로 옴)
		}
		*/
		$this -> load -> view('get', array('id'=>$id, "boards" => $data));
		$this -> load -> view('footer');
	}
	public function cc($board_no)
	{
		$board = $this -> board_model -> get(number_format($board_no));
		$this -> load -> view('cget', array('board'=>$board));
		$this -> load -> view('footer');
	}
	/*
	public function _remap($method)
	{
		if ($method == 'b')
		{
			$this->bb();
		}
		else
		{
			$this->index();
		}
	}
	*/
	public function _remap($method, $params = array())
	{
		if ($method == 'b')
		{
			$method = 'bb';
		}
	//	$method = 'process_'.$method;

		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		show_404();
	}

}

?>
