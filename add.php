<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if (empty($_SESSION)) {
    http_response_code(403);
    exit();
}

$page_content = include_template('add.php', [
	'lots_array' => $lots_array,
	'categories_array' => $categories_array
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$lot = $_POST;

	$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];

	$errors = [];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Заполните это поле';
		}
	}

	$count = 0;
	foreach ($lots_array as $value) {
		if ($value['name'] === $lot['category']) {
			$count++;
		}
	}
	if (!$count) {
		$errors['category'] = "Выберите категорию";
	}

	$path = "";
	$lot['file'] = $path;

	if (isset($_FILES['file']['name'])) {

		$tmp_name = $_FILES['file']['tmp_name'];
		$path = $_FILES['file']['name'];

		if (!empty($tmp_name)) {
			$file_type = mime_content_type($tmp_name);

			if ($file_type == "image/jpeg" || $file_type == "image/png") {
				move_uploaded_file($tmp_name, __DIR__ . '/img/' . $path);
				$lot['file'] = '/img/' . $path;

			} else {
				$errors['file'] = 'Загрузите картинку в формате JPEG или PNG';
			}
		}
	}

	if (empty($lot['file'])) {
		unset($errors['file']);
	}


	if (!filter_var($lot['lot-rate'], FILTER_VALIDATE_FLOAT) || $lot['lot-rate'] < 0) {
		$errors['lot-rate'] = "Введите число больше нуля";
	}

	if (!filter_var($lot['lot-step'], FILTER_VALIDATE_INT) || $lot['lot-step'] < 0) {
		$errors['lot-step'] = "Введите целое число больше нуля";
	}

	if (strtotime($lot['lot-date']) < strtotime('tomorrow')) {
		$errors['lot-date'] = "Введите дату больше текущей";
	}

	if (empty($errors)) {
		$sql = 'SELECT * FROM categories WHERE name LIKE "' . $lot['category'] . '"';
		$category_id = fetch_data($connect, $sql);
		$lot['category_id'] = $category_id[0]['id'];

		$sql = 'INSERT INTO lots (date_create, title, description, image, start_price, date_finish, step, author_id, category_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
		$stmt = db_get_prepare_stmt($connect, $sql, [ $lot['lot-name'], $lot['message'], $lot['file'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step'], $safe_id, $lot['category_id'] ]);
		$res = mysqli_stmt_execute($stmt);

		$last_id = mysqli_insert_id($connect);

		if ($res) {
			header("Location: /lot.php?lot_id=" . $last_id);
		}

		$page_content = include_template('add.php', [
			'lot' => $lot,
			'categories_array' => $categories_array
		]);

	} else {
		$page_content = include_template('add.php', [
			'lot' => $lot,
			'errors' => $errors,
			'categories_array' => $categories_array
		]);
	}
}

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Добавление лота',
	'user_name' => $user[0]['name']
]);

print($layout_content);