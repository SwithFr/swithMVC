<?php

namespace Core\Helpers;


class Text {

	public static function resize($text,$limit){
		return substr($text, 0, $limit)."...";
	}

} 