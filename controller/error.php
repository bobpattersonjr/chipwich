<?php

class error_controller extends controller {

    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->view->msg = 'This page doesnt exist';
        $this->view->title = "Error";
        $this->view->render('error/index');
    }

}