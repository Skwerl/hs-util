<?php

function XMLaddManyChildren($obj,$arr) {
	foreach ($arr as $key => $array) {
		$child = $obj->addChild($key);
		foreach ($array as $ak => $av) {
			$child->addAttribute($ak, $av);
		}
	}
}

function XMLaddManyAttributes($obj,$arr) {
	foreach($arr as $key => $value) {
		$obj->addAttribute($key, $value);
	}
}

function XMLaddListSection($parent,$caption,$arr) {
	$obj = $parent->addChild('section');
	$obj->addChild('caption',$caption);
	$list = $obj->addChild('list');
	foreach ($arr as $key => $value) {
		$item = $list->addChild('item');
		$item->addChild('content',$value);
	}
}

function XMLaddParagraphSection($parent,$caption,$str) {
	$obj = $parent->addChild('section');
	$obj->addChild('caption',$caption);
	$paragraph = $obj->addChild('paragraph');
	$paragraph->addChild('content',$str);
}

?>