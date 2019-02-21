<?php

require_once('functions.php');

$user_id = 2;
$safe_id = intval($user_id);

//$connect = mysqli_connect("localhost", "root", "", "yeticave");

$connect = mysqli_init();
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($connect, "localhost", "root", "", "yeticave");


mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM categories";
$categories_array = fetch_data($connect, $sql);

$sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name FROM lots JOIN categories ON lots.category_id = categories.id ORDER BY lots.date_create ASC";
$lots_array = fetch_data($connect, $sql);

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

		//print('Последний id: ' . $last_id);

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
	'is_auth' => $is_auth,
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Главная',
	'user_name' => $user[0]['name']
]);

print($layout_content);