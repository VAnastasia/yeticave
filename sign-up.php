<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$navigation = include_template('navigation.php', [
    'categories_array' => $categories_array,
]);

$page_content = include_template('sign-up.php', [
    'navigation' => $navigation,
	'lots_array' => $lots_array
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$form = $_POST;

	$required = ['email', 'password', 'name', 'message'];

	$errors = [];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Заполните это поле';
		}
	}

	if (filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
		unset($errors['email']);
	} else {
		$errors['email'] = "Введите e-mail";
	}

	$path = "";
	$form['file'] = $path;

	if (isset($_FILES['file']['name'])) {
		$tmp_name = $_FILES['file']['tmp_name'];

		if (!empty($tmp_name)) {
			$path = $_FILES['file']['name'];

			$file_type = mime_content_type($tmp_name);

			if ($file_type == "image/jpeg" || $file_type == "image/png") {
				move_uploaded_file($tmp_name, __DIR__ . '/img/' . $path);
				$form['file'] = '/img/' . $path;

			} else {
				$errors['file'] = 'Загрузите картинку в формате JPEG или PNG';
			}
		}
	}

	if (empty($form['file'])) {
		unset($errors['file']);
	}

	if (empty($errors)) {
		$email = mysqli_real_escape_string($connect, $form['email']);
		$sql = "SELECT id FROM users WHERE email = '" . $email . "'";
		$res = mysqli_query($connect, $sql);

		if (mysqli_num_rows($res)) {
			$errors['email'] = 'Пользователь с этим email уже зарегистрирован';
		}

		$password = password_hash($form['password'], PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (date_reg, email, name, password, avatar, contact) VALUES (NOW(), ?, ?, ?, ?, ?)";
		$stmt = db_get_prepare_stmt($connect, $sql, [$form['email'], $form['name'], $password, $form['file'], $form['message']]);
		$res = mysqli_stmt_execute($stmt);

		if ($res) {
			header("Location: login.php");
			exit();
		}

		$page_content = include_template('sign-up.php', [
			'categories_array' => $categories_array,
			'lots_array' => $lots_array,
			'form' => $form
		]);
	}

	if (count($errors)) {
		$page_content = include_template('sign-up.php', [
            'navigation' => $navigation,
			'lots_array' => $lots_array,
			'errors' => $errors,
			'form' => $form
		]);
	}
}

$layout_content = include_template('layout.php', [
	'content' => $page_content,
    'navigation' => $navigation,
	'title' => 'Регистрация',
	'user_name' => ""
]);

print($layout_content);