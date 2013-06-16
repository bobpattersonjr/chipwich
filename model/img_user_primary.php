<?php


class img_user_primary extends model{
    protected $table = 'img_user_primary';

    public $_fields = array('img' => null,
                            'user' => null,
                            'added' => null,
                            'modified' => null,);


    public function __construct($id=null){
        parent::__construct($id);
    }

    public static function delete_img($img){
        $result = $GLOBALS['db']->select_values('SELECT id FROM img_user_primary WHERE img = :img', array(':img' => $img->_id));
        if($result){
            foreach ($result as $img_id) {
                $img_user_primary = new img_user_primary($img_id);
                $img_user_primary->delete();
            }
            return true;
        }
        return false;
    }
}