<?php

class auth{
    public static function logged_in(){
        $logged_in = session::get('logged_in');
        return $logged_in ? true : false;
    }

    public static function admin(){
        $admin = session::get('admin');
        return $admin ? true : false;
    }

    public static function gen_hash($password){
        // Create a 256 bit (64 characters) long random salt
        // Let's add 'something random' and the username
        // to the salt as well for added security
        $salt = hash('sha256', uniqid(mt_rand(), true) . 'bob is the best');

        // Prefix the password with the salt
        $hash = $salt . $password;

        // Hash the salted password a bunch of times
        for ( $i = 0; $i < 10; $i ++ ) {
            $hash = hash('sha256', $hash);
        }

        // Prefix the hash with the salt so we can find it back later
        return $salt . $hash;
    }

    public static function check_hash($provided_hash, $password){
        $salt = substr($provided_hash, 0, 64);

        $hash = $salt . $password;

        // Hash the password as we did before
        for ( $i = 0; $i < 10; $i ++ ) {
            $hash = hash('sha256', $hash);
        }

        $hash = $salt . $hash;

        if ( $hash == $provided_hash )
            return true;
        else
            return false;
    }
    
}