<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Map extends CI_Controller{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this -> load -> view('header');
        $this -> load -> view('map');
        $this -> load -> view('footer');
    }

    public function search()
    {
        try {
            $place_name = "제주 ".$this -> input -> get('place_name', true);
            if(!$place_name) {
                throw new exception('place_name 값이 없습니다.');
            }else{
                //네이버 검색
                $client_id = 'fEbkWGOsjGqz6lleU7mI';
                $client_secret = "oMltSlKqv3";
                $method = $_SERVER['REQUEST_METHOD'];
                $encText = urlencode($place_name);
                // $url = "https://openapi.naver.com/v1/search/blog.xml?query=".$encText; // json 결과
                $url = "https://openapi.naver.com/v1/search/blog.xml?query=".$encText; // xml 결과
                $is_post = false;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, $is_post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = array();
                $headers[] = "X-Naver-Client-Id: ".$client_id;
                $headers[] = "X-Naver-Client-Secret: ".$client_secret;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec ($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if($status_code == 200) {
                    $result = new SimpleXMLElement($response);
                    for($i = 0; $i <10 ; $i++){
                        $str_date = $result->channel->item[$i]->postdate;
                        $date = date("Y-m-d", strtotime( $str_date ) );
                        $result_object = (object) array(
                            'link' => $result->channel->item[$i]->link,
                            'title' => $result->channel->item[$i]->title,
                            'bloggername' => $result->channel->item[$i]->bloggername,
                            'postdate' => $date
                        );
                        $searchlist[$i] = $result_object;
                    }
                } else {
                    $searchlist['msg'] = "Error 내용:".$response;
                }
            }
            echo json_encode($searchlist);
        } catch(exception $e) {
            $searchlist['success']	= false;
            $searchlist['msg'] = $e->getMessage();
            $searchlist['code'] = $e->getCode();
            echo json_encode($searchlist);
        }
    }
}