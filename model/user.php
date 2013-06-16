<?php

class user extends model{
    protected $table = 'user';

    public $_fields = array('first_name' => null,
                            'last_name' => null,
                            'birthday' => null,
                            'sex' => null,
                            'email' => null,
                            'password' => null,
                            'signup' => null,
                            'last' => null,
                            'added' => null,
                            'modified' => null,
                            'admin' => 0,
                            'status' => 0);

    public function __construct($id=null){
        parent::__construct($id);
    }

    public function age(){
        return getYearsSinceDate($this->birthday);
    }

    public function age_bucket(){
        return bucket_ages($this->birthday);
    }

    public function photos(){
        $photos = array();
        $result = $GLOBALS['db']->select_values('SELECT img FROM img_user WHERE user = :user', array(':user' => $this->_id));
        if($result){
            foreach ($result as $img_id) {
                $photos[] = new img($img_id);
            }
        }
        return $photos;
    }

    public function url(){
        return URL.'user/'.$this->_id;
    }

    public function user_name(){
        return ucwords($this->first_name.' '.$this->last_name[0].'.');
    }

}