<?php

class account_controller extends controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        if(!auth::logged_in()){
            bootstrap::error();
            exit;
        }
        $this->view->title = "My Account";
        $user = new user(session::get('userid'));
        $this->view->photos = $user->photos();
        $this->view->user = $user;
        $this->view->js = array('account/index.js');
        $this->view->render('account/index');
    }
    
    public function create() {
        if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['password'])) {

            $result = $GLOBALS['db']->select_first_value('SELECT id FROM user WHERE email = :email', array(':email' => $_POST['email']));

            if($result) {
                $this->view->json(array('success'=>false, 'dupe'=>true));
                return;
            }

            $user = new user();
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->email = $_POST['email'];
            $user->birthday = strtotime($_POST['dob']);
            $user->sex = $_POST['gender'];
            $user->password = auth::gen_hash($_POST['password']);
            $user->signup = time();
            $user->last = time();
            $user->added = time();
            $user->modified = time();
            $user->save();
            session::set('logged_in', true);
            session::set('userid', $user->_id);
            session::set('admin', $user->admin >= 1 ? true : false);
            $this->view->json(array('success'=>true));
            return;
        }
        $this->view->json(array('success'=>false));
    }

    public function login() {
        if (isset($_POST['email'], $_POST['password'])) {
            $result = $GLOBALS['db']->select_first('SELECT id,password FROM user WHERE email = :email', array(':email' => $_POST['email']));
            if ($result) {
                if (auth::check_hash($result['password'], $_POST['password'])) {
                    $user = new user($result['id']);
                    session::set('logged_in', true);
                    session::set('userid', $user->_id);
                    session::set('admin', $user->admin >= 1 ? true : false);
                    $user->last = time();
                    $user->save();
                    $this->view->json(array('success'=>true));
                    return;
                }
                session::destroy();
                $this->view->json(array('success'=>false));
                return;
            } else {
                session::destroy();
                $this->view->json(array('success'=>false));
                return;
            }
        }
        $this->view->json(array('success'=>false));
    }

    public function logout() {
        session::destroy();
        header('location: '.URL);
        exit;
    }

    public function upload_image($bar_id=null) {
        $image = $_FILES['qqfile']['tmp_name'];
        //variable to store the max file size (in MB)
        //we will use 10MB but you can change this for your own requirements
        $maxFileSize = 10;
        //first check to make sure a file was posted
        if (empty($_FILES['qqfile']['tmp_name'])) {
            echo "An image was not posted to this script ";
            die();
        } else if (round($_FILES['qqfile']['size'] / 1048576, 2) > $maxFileSize) {
            echo "Your file exceeds the maximum file limit of {$maxFileSize} MB";
            die();
        } else {
            $fp   = fopen($_FILES['qqfile']['tmp_name'], 'r');
            $data = fread($fp, filesize($_FILES['qqfile']['tmp_name']));
            fclose($fp);

            $img = new img();
            $img->filename = md5($data).'.png';
            $img->to_s3_raw(img::raw_to_png($data));
            $img->save();

            $img_user = new img_user();
            $user = new user(session::get('userid'));
            $img_user->img = $img->_id;
            $img_user->user = $user->_id;
            $img_user->save();

            header("Content-Type: text/plain");
            $this->view->json(array('success'=>true));
        }
    }

    public function send_welcome_email() {
        if (!auth::logged_in()) {
            bootstrap::error();
            exit;
        }

        // buffer all upcoming output
        ob_start();

        $user = new user(session::get('userid'));

        // get the size of the output
        $size = ob_get_length();

        // send headers to tell the browser to close the connection
        header("Content-Length: $size");
        header('Connection: close');

        // flush all output
        ob_end_flush();
        ob_flush();
        flush();

        // close current session
        if (session_id()) session_write_close();

        /******** background process starts here ********/

        // error_log('testing '.session::get('userid'));
        // $user = new user(session::get('userid'));

        // $this->view->json(array('success'=>true));

        signup_email($user->email, $user->first_name);
        
    }
}
