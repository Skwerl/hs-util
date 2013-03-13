<?php

function XMLaddManyChildren($obj,$arr) {
	foreach ($arr as $key => $array) {
		$child = $obj->addChild($key);
		foreach ($array as $ak => $av) {
			$child->addAttribute($ak, $av);
		}
	}
	return $obj;
}

function XMLaddManyAttributes($obj,$arr) {
	foreach($arr as $key => $value) {
		$obj->addAttribute($key, $value);
	}
	return $obj;
}

function XMLaddManyNodes($obj,$arr) {
	foreach($arr as $key => $value) {
		$obj->addChild($key, $value);
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
	return $obj;
}

function XMLaddParagraphSection($parent,$caption,$str) {
	$obj = $parent->addChild('section');
	$obj->addChild('caption',$caption);
	$paragraph = $obj->addChild('paragraph');
	$paragraph->addChild('content',$str);
	return $obj;
}

function XMLaddTableSection($parent,$schema,$data) {
	$rowID = 1;
	$obj = XMLaddManyAttributes($parent->addChild('table'), array(
		'border' => '1',
		'width' => '100%'
	));
	$tableHeader = $obj->addChild('thead')->addChild('tr');
	$group = array_shift(array_keys($schema));
	$schema = array_shift($schema);
	$fieldIDs = array();
	foreach ($schema as $key => $fieldID) {
		$tableHeader->addChild('th', $key);
		$fieldIDs[] = $fieldID;
	}
	$tableBody = $obj->addChild('tbody');
	foreach ($data as $array) {
		$label = array_shift($schema);
		$row = $tableBody->addChild('tr');
		$row->addAttribute('ID', $group.'_'.$rowID);
		$fieldIndex = 0;
		foreach ($array as $item) {
			if (!is_array($item)) {
				$row->addChild('td', $item)->addAttribute('ID', $fieldIDs[$fieldIndex].'_'.$rowID);
				$fieldIndex++;
			}
		}
		$rowID++;
	}
	return $obj;
}

?>