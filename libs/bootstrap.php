<?php

class bootstrap {

	function __construct() {
		require 'libs/library.php';

		if(CLI){
			//require 'cli_extra/something.php';
			return;
		}

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);

		//print_r($url);
		
		if (empty($url[0])) {
			require 'controller/index.php';
			$controller = new index_controller();
			$controller->index();
			return false;
		}

		if($url[0] == 'image'){
			if(!$url[1]){
				self::error();
				return;
			}

			require 'controller/image.php';
			$controller = new image_controller();
			$controller->index($url[1]);
			return;
		}

		if (in_array($url[0], array('user')) && is_numeric($url[1])) {
			$url[0] = 'user';
			$file = 'controller/' . $url[0] . '.php';
			if (file_exists($file)) {
				require $file;
			} else {
				self::error();
			}
			$controller = new user_controller;
			$controller->index($url[1]);
		}elseif(in_array($url[0], array('about','faq','privacy_policy','guidelines'))){
			require 'controller/index.php';
			$controller = new index_controller();
			if (method_exists($controller, $url[0])) {
				$controller->{$url[0]}();
			}else{
				self::error();
			}
		}else{
			$file = 'controller/' . $url[0] . '.php';
			if (file_exists($file)) {
				require $file;
			} else {
				self::error();
			}
			$controller_name = $url[0].'_controller';
			$controller = new $controller_name;

			// calling methods
			if (isset($url[2])) {
				if (method_exists($controller, $url[1])) {
					$controller->{$url[1]}($url[2]);
				} else {
					self::error();
				}
			} else {
				if (isset($url[1])) {
					if (method_exists($controller, $url[1])) {
						$controller->{$url[1]}();
					} else {
						self::error();
					}
				} else {
					$controller->index();
				}
			}
		}
	}
	
	public static function error() {
		require 'controller/error.php';
		$controller = new error_controller();
		$controller->index();
		return false;
	}

}