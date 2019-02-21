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
	}

	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $data;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
	$stmt = mysqli_prepare($link, $sql);

	if ($data) {
		$types = '';
		$stmt_data = [];

		foreach ($data as $value) {
			$type = null;

			if (is_int($value)) {
				$type = 'i';
			}
			else if (is_string($value)) {
				$type = 's';
			}
			else if (is_double($value)) {
				$type = 'd';
			}

			if ($type) {
				$types .= $type;
				$stmt_data[] = $value;
			}
		}

		$values = array_merge([$stmt, $types], $stmt_data);

		$func = 'mysqli_stmt_bind_param';
		$func(...$values);
	}

	return $stmt;
}