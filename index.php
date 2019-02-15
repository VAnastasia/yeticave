<?php

require_once('functions.php');
//require_once('data.php');

$user_id = 2;
$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM categories";
$categories_array = fetch_data($connect, $sql);

$sql = "SELECT * FROM lots JOIN categories ON lots.category_id = categories.id ORDER BY lots.date_create ASC";
$lots_array = fetch_data($connect, $sql);

$page_content = include_template('index.php', [
	'categories_array' => $categories_array,
	'lots_array' => $lots_array
]);

$layout_content = include_template('layout.php', [
  'is_auth' => $is_auth,
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Главная',
	'user_name' => $user[0]['name']
]);

print($layout_content);



