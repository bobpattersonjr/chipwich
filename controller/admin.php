<?php

class admin_controller extends controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        if(!auth::logged_in() || !auth::admin()){
            bootstrap::error();
            exit;
        }
        $this->view->title = "admin";
        $this->view->page = "start";
        $this->view->render(array('admin/header','admin/index'));
    }

    
    public function imgs() {
        if(!auth::logged_in() || !auth::admin()){
            bootstrap::error();
            exit;
        }
        $this->view->title = "admin photos";
        $this->view->page = "images";
        $this->view->imgs = img::need_approval();
        $this->view->js = array('admin/imgs.js');
        $this->view->render(array('admin/header','admin/imgs'));
    }

    public function users() {
        if(!auth::logged_in() || !auth::admin()){
            bootstrap::error();
            exit;
        }

        if(isset($_POST['filter']))
            $filter = $_POST['filter'];
        else
            $filter = null;

        $this->view->title = "admin users";
        $this->view->page = "users";
        $this->view->users_filterd = user::filter($filter);
        $this->view->js = array('admin/users.js');
        $this->view->render(array('admin/header','admin/users'));
    }

    public function remove_img($img){
        if(!auth::logged_in() || !auth::admin()){
            bootstrap::error();
            exit;
        }
        $img = new img($img);
        $img->delete();
        $this->view->json(array('success'=>true));
    }

    public function approve_img($img){
        if(!auth::logged_in() || !auth::admin()){
            bootstrap::error();
            exit;
        }
        $img = new img($img);
        $img->approved = 1;
        $img->save();
        $this->view->json(array('success'=>true));
    }

    public function primary_img($img){
        if(!auth::logged_in() || !auth::admin()){
            bootstrap::error();
            exit;
        }
        $img = new img($img);
        $img->approved = 1;
        if($img->bar){
            img_bar_primary::delete_img($img);
            $img_bar_primary = new img_bar_primary();
            $img_bar_primary->img = $img->_id;
            $img_bar_primary->bar = $img->bar->_id;
            $img_bar_primary->save();
        }
        $img->save();
        $this->view->json(array('success'=>true));
    }

    public function edit($object){
        $o = new $object($_POST['pk']);
        $name = $_POST['name'];
        $o->$name = $_POST['value'];
        $o->save();
    }

}