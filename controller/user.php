<?php

class user_controller extends controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index($user_id) {
        if($user_id)
            $this->view->user = new user($user_id);

        if($this->view->user === false || !$user_id || !$this->view->user->_id ){
            bootstrap::error();
            exit;
        }
        $this->view->photos = $this->view->user->photos();

        $this->view->title = $this->view->user->user_name().' | '.SITE_NAME;
        $this->view->render('user/index');
    }

}