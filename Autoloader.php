<?php

class Autoloader {

	const FILE_NOT_FOUND = 1;
	const CLASS_NOT_FOUND = 2;
	private static $error;

	public static function load($targetClass) {
		if (!defined('APPLICATION_PATH')) {
			throw new \Exception('APPLICATION_PATH is not set!');
		}

		$partsTargetClass = explode('\\', $targetClass);
		$path = APPLICATION_PATH.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $partsTargetClass).'.php';
		if (file_exists($path)) {
			require_once $path;
			if (!class_exists($targetClass)) {
				self::setError(self::CLASS_NOT_FOUND);
				throw new \Exception('Class \''.$targetClass.'\' does not exist!'.print_r(debug_backtrace(),1));
			}
		} else {
			self::setError(self::FILE_NOT_FOUND);
			throw new \Exception('File \''.$path.'\' does not exist!'.print_r(debug_backtrace(),1));
		}
	}

	/**
	* Gets the value of error.
	*
	* @return mixed
	*/
	public static function getError() {
		return self::$error;
	}

	/**
	* Sets the value of error.
	*
	* @param mixed $error the error
	*/
	private static function setError($error){
		self::$error = $error;
	}
}
