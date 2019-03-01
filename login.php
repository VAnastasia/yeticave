<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$page_content = include_template('login.php', [
	'categories_array' => $categories_array,
	'lots_array' => $lots_array
]);

$layout_content = include_template('layout.php', [
	'is_auth' => $is_auth,
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Вход',
	'user_name' => $user[0]['name']
]);

print($layout_content);