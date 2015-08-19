<?php

class Autoloader {

	public static function load($targetClass) {
		$backtrace = debug_backtrace();
		$backtraceIndex = isset($backtrace[2]) ? 2 : 1;
		$partsFileCalledFrom = explode(DIRECTORY_SEPARATOR, dirname($backtrace[1]['file']));
		$partsClassCalledFrom = array();
		if (isset($backtrace[$backtraceIndex]['class'])) {
			$partsClassCalledFrom = explode('\\', $backtrace[$backtraceIndex]['class']);
		}
		$partsTargetClass = explode('\\', $targetClass);
		$partsAppDir = self::cutArrayEnd($partsFileCalledFrom, $partsClassCalledFrom);

		$partsAppDir = self::cutArrayEnd($partsAppDir, $partsTargetClass);

		$path = implode(DIRECTORY_SEPARATOR, array_merge($partsAppDir, $partsTargetClass)).'.php';

		if (file_exists($path)) {
			require_once $path;
			if (!class_exists($targetClass)) {
				throw new \Exception('Class \''.$targetClass.'\' does not exist!'.print_r(debug_backtrace(),1));
			}
		} else {
			throw new \Exception('File \''.$path.'\' does not exist!'.print_r(debug_backtrace(),1));
		}
	}

	private static function cutArrayEnd($arrayCut, $arrayEnd) {
		$arrayFinal = $arrayCut;
		for ($i = 0; $i < count($arrayCut); $i++) {
			if (isset($arrayEnd[0]) && $arrayEnd[0] === $arrayCut[$i] && !empty($arrayEnd[0])) {
				$arrayFinal = array_splice($arrayCut, 0, $i);
			}
		}
		return $arrayFinal;
	}
}