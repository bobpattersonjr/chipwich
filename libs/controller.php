<?php

class controller {

    function __construct() {
        session::init();
        $this->view = new view();
        $this->_get = $_GET;
        $this->_post = $_POST;
    }

}