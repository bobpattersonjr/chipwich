<?php

class index_controller extends controller {

    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->view->title = SITE_NAME;
        $this->view->render('index/index');
    }

    
    function about(){
        $this->view->title = SITE_NAME." | About";
        $this->view->render('index/about');
    }

}