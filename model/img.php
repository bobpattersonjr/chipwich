<?php

if (!class_exists('S3')) require_once 'extra/S3.php';
if (!class_exists('ContentAwareImage')) require_once 'extra/ContentAwareImage.php';


class img extends model{
    protected $table = 'img';

    public $_fields = array('filename' => null,
                            'approved' => 0,
                            'added' => null,
                            'modified' => null,);


    public function __construct($id=null){
        parent::__construct($id);
    }

    public function delete(){
        $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);

        $s3->deleteObject(BUCKET_NAME, $this->filename);

        img_user::delete_img($this);
        img_user_primary::delete_img($this);

        parent::delete();
    }

    public function to_s3_raw($raw){
        $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);

        $s3->putObject($raw, BUCKET_NAME, $this->filename, S3::ACL_PUBLIC_READ, array(), array("Content-Type" => 'image/png'));
    }

    public static function raw_to_png($raw){
        $imagick = new Imagick();
        $imagick->readImageBlob($raw);
        $imagick->setImageFormat( 'png' );
        return $imagick->getImageBlob();
    }

    public static function need_approval(){
        $photos = array();
        $result = $GLOBALS['db']->select_values('SELECT id FROM img WHERE approved = 0 Limit 100');
        if($result){
            foreach ($result as $img_id) {
                $photos[] = new img($img_id);
            }
        }
        return $photos;
    }

    public function user(){
        $result = $GLOBALS['db']->select_first_value('SELECT user FROM img_user WHERE img = :id', array(':id' => $this->_id));
        if($result){
            $user = new user($result);
            return $user;
        }
        return null;
    }

    public function url($x=false, $y=false){
        if(!$x || !$y)
            return S3URL.$this->filename;
        list($filename_base, $ext) = explode('.', $this->filename);
        return CDNURL."{$filename_base}.{$x}_{$y}.{$ext}";
    }

    public static function parse_cdn_filename($filename){
        list($filename_base, $dimensions_raw, $ext) = explode('.', $filename);
        list($x, $y) = explode('_', $dimensions_raw);

        return array(
            'filename'      => $filename_base.'.'.$ext,
            'filename_base' => $filename_base,
            'ext'           => $ext,
            'x'             => $x,
            'y'             => $y
            );
    }

    public static function by_filename($filename){
        $result = $GLOBALS['db']->select_first_value('SELECT id FROM img WHERE filename = :filename', array(':filename' => $filename));

        if($result){
            $img = new img($result);
            return $img;
        }
        return false;
    }

    public function get_resize($params){
        $s3 = new S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);

        $s3_data = $s3->getObject(BUCKET_NAME, $this->filename);

        $content_image = new ContentAwareImage();
        $imagick = $content_image->crop($s3_data->body, (int)$params['x'], (int)$params['y']);
        $imagick->setImageFormat( $params['ext'] );
        return $imagick->getImageBlob();
    }
}