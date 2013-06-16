<?php

class image_controller extends controller {

    public function __construct() {
    }
    
    public function index($filename = false) {
        $parsed = img::parse_cdn_filename($filename);

        $img = img::by_filename($parsed['filename']);

        $raw = $img->get_resize($parsed);

        Header('Content-Type: image/png');
        echo $raw;
    }

}