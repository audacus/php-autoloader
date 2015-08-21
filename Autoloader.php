<?php

class Autoloader {

	public static function load($targetClass) {
		if (!defined('APPLICATION_PATH')) {
			throw new \Exception('APPLICATION_PATH is not set!');
		}

		$partsTargetClass = explode('\\', $targetClass);
		$path = APPLICATION_PATH.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $partsTargetClass).'.php';
		if (file_exists($path)) {
			require_once $path;
			if (!class_exists($targetClass)) {
				throw new \Exception('Class \''.$targetClass.'\' does not exist!'.print_r(debug_backtrace(),1));
			}
		} else {
			throw new \Exception('File \''.$path.'\' does not exist!'.print_r(debug_backtrace(),1));
		}
	}
}
