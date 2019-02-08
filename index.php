<?php

require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', [
	'categories_array' => $categories_array,
	'lots_array' => $lots_array
]);

$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Главная',
	'user_name' => $user_name
]);

print($layout_content);



