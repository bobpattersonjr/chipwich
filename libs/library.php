<?php


function getYearsSinceDate($date){
    $now = time();
    $then = $date;
    // get difference between years
    $years = date("Y", $now) - date("Y", $then);

    // get months of dates
    $mthen = date("n", $then);
    $mnow = date("n", $now);
    // get days of dates
    $dthen = date("j", $then);
    $dnow = date("j", $now);
    // if date not reached yet this year, we need to remove one year.
    if ($mnow < $mthen || ($mnow==$mthen && $dnow<$dthen)) {
        $years--;
    }

    return $years;
}


function bucket_ages($birthday){
    $birthday = getYearsSinceDate($birthday);
    $bucket_size = 5;

    $start_age = 25;
    $end_age = 55;

    if($birthday < $start_age)
        return '18 - ' . ($start_age - 1) . ' years old';

    $age = $start_age + $bucket_size;
    $last_age = $start_age;

    while($age < $end_age){
        if($birthday < $age){
            return $last_age .' - ' . ($age - 1) . ' years old';
        }

        $last_age = $age;
        $age += $bucket_size;
    }

    return $end_age . '+ years old';
}

function image($source,$height,$width){
    return '<img src="'.$source.'" height='.$height.' width='.$width.' class="img-rounded" />';
}

function timeago($timestamp){
    echo '<abbr class="timeago" title="'.date('c', $timestamp).'">'.date("F j, Y, g:i a", $timestamp).'</abbr>';
}


function prod(){
    if(URL == PROD){
        return true;
    }
    return false;
}

function get_address_lat_long($address){
    if (!is_string($address))die("All Addresses must be passed as a string");
    $_url = sprintf('http://maps.google.com/maps?output=js&q=%s',rawurlencode($address));
    $_result = false;
    if($_result = file_get_contents($_url)) {
        if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
        preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
        $_coords['lat'] = $_match[1];
        $_coords['long'] = $_match[2];
    }
    return $_coords;
}

function log_trace($message = '') {
    $trace = debug_backtrace();
    if ($message) {
        error_log($message);
    }
    $caller = array_shift($trace);
    $function_name = $caller['function'];
    error_log(sprintf('%s: Called from %s:%s', $function_name, $caller['file'], $caller['line']));
    foreach ($trace as $entry_id => $entry) {
        $entry['file'] = $entry['file'] ? : '-';
        $entry['line'] = $entry['line'] ? : '-';
        if (empty($entry['class'])) {
            error_log(sprintf('%s %3s. %s() %s:%s', $function_name, $entry_id + 1, $entry['function'], $entry['file'], $entry['line']));
        } else {
            error_log(sprintf('%s %3s. %s->%s() %s:%s', $function_name, $entry_id + 1, $entry['class'], $entry['function'], $entry['file'], $entry['line']));
        }
    }
}

?>