<?php
Class Captcha extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('captcha');
    }
    public function index()
    {
        $vals = array(
            'word'          => '',
            'img_path'      => './static/img/captcha/',
            'img_url'       => 'http://localhost/static/img/captcha/',
            'font_path'     => './path/to/fonts/texb.ttf',
            'img_width'     => '200',
            'img_height'    => 50,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size'     => 20,
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
        echo 'dd';
        echo $cap['image'];
        echo 'dd';
        echo $cap['word'];

    }
}