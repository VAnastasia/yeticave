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

//функция показа оставшегося времени

function time_rest($time) {
	$time_now = date_create("now");
	$time_compare = date_create($time);
	$diff = date_diff($time_compare, $time_now);
	$time_count = date_interval_format($diff, "%d:%H:%I");
	return $time_count;
}

//функция для получения массива из БД
function fetch_data ($connect, $sql) {
	if(!$connect) {
		print('Ошибка подключения: ' . mysqli_connect_error());
		exit();
	}
	$result = mysqli_query($connect, $sql);

	if(!$result) {
		$error = mysqli_error($connect);

		print("Ошибка MySQL: " . $error);
		exit();
	}

	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $data;
}