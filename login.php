<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];

    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Заполните это поле';
        }
    }

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Введите e-mail";
    }

    $email = mysqli_real_escape_string($connect, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
    $res = mysqli_query($connect, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (empty($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } elseif (empty($errors) && !$user) {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('login.php', [
            'form' => $form,
            'errors' => $errors
        ]);
    } else {
        header("Location: index.php");
        exit();
    }

    if (count($errors)) {
        $page_content = include_template('login.php', [
            'categories_array' => $categories_array,
            'lots_array' => $lots_array,
            'errors' => $errors,
            'form' => $form
        ]);
    }

} else {
    $page_content = include_template('login.php', [
        'categories_array' => $categories_array,
        'lots_array' => $lots_array
    ]);
}

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Вход',
	'user_name' => ""
]);

print($layout_content);