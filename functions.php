<?php

function include_template($name, $data) {
	$name = 'templates/' . $name;
	$result = '';

	if (!is_readable($name)) {
		return $result;
	}

	ob_start();
	extract($data);
	require $name;

	$result = ob_get_clean();

	return $result;
};

$is_auth = rand(0, 1);

/**
 * функция форматирования цены
 * @param $number
 */

function price_format ($number) {
	$number = ceil($number);
	if ($number >= 1000) {
		$number = number_format($number, 0, '.', ' ' );
	}
	$number .= ' <b class="rub">р</b>';
	return $number;
}