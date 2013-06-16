<?php

class view {

    function __construct() {

    }

    public function render($name, $noInclude = false){

        if ($noInclude == true) {
            require 'view/' . $name . '.php';   
        }else {
            require 'view/header.php';
            if(is_array($name)){
                foreach ($name as $section) {
                    require 'view/' . $section . '.php';
                }
            }else{
                require 'view/' . $name . '.php';
            }
            require 'view/footer.php';  
        }
    }

    public function json($array){
        die( json_encode( $array ) );
    }

}