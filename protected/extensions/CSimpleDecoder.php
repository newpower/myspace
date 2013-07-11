<?php

class CSimpleDecoder {
	
	public static function getPositions($count, $mode, $length) {
		$step = floor($length / 3.0) + $count + $mode;
		$step %= $length;
		if (($length & 1) == ($step & 1)) {
			$step -= 1;
		}
		
		$positions = array();
		$current_pos = floor(pow($count, 3) / 5.0 + pow($mode, 3));
		
		while ($count > 0) {
			$current_pos += $step;
			if ($current_pos >= $length) {
				$current_pos %= $length;
			}
			if ($current_pos != 0 && $current_pos != $length - 1 && !in_array($current_pos, $positions)) {
				$positions []= $current_pos;
				$count -= 1;
			}
		}
		return $positions;
	}
	
	public static function decode($key, $str) {
		$strArr = preg_split("/[a-f]/i", $str);
		$keyArr = str_split($key);
		
		$r = '';
		for($i = 0; $i < count($keyArr); $i++) {
			$c1 = (int)$strArr[$i];
			$c2 = ord($keyArr[$i]);
			$cr = $c1 ^ $c2;
			$r = $r . chr($cr);
		}
		
		$count = $r[ 0 ];
		$mode = $r[ strlen($r) - 1 ];
		
		$positions = self::getPositions($count, $mode, count($keyArr));
		
		$num = '';
		foreach($positions as $i) {
			$num .= $r[ $i ];
		}
		return $num;
	}
}