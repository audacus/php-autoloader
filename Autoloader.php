<?php

class Autoloader {

	public static function load($targetClass) {
		require_once 'FileNotFoundException.php';
		require_once 'ClassNotFoundException.php';

		if (!defined('APPLICATION_PATH')) {
			throw new \Exception('APPLICATION_PATH is not set!');
		}

		$partsTargetClass = explode('\\', $targetClass);
		$path = APPLICATION_PATH.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $partsTargetClass).'.php';
		if (file_exists($path)) {
			require_once $path;
			if (!class_exists($targetClass)) {
				// throw new ClassNotFoundException('Class \''.$targetClass.'\' does not exist!'.print_r(debug_backtrace(),1));
				throw new ClassNotFoundException($targetClass);
			}
		} else {
			// throw new FileNotFoundException('File \''.$path.'\' does not exist!'.print_r(debug_backtrace(),1));
			throw new FileNotFoundException($path);
		}
	}
}
