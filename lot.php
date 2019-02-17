<?php

require_once('functions.php');

$user_id = 2;
$safe_id = intval($user_id);
$lot_id = intval(1);

$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM categories";
$categories_array = fetch_data($connect, $sql);


if(isset($_GET['lot_id'])) {
	$sql = "SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . $_GET['lot_id'];
	$lots_array = fetch_data($connect, $sql);

	if(empty($lots_array)) {
		header("HTTP/1.0 404 Not Found");
		exit();
	}
}

$page_error = include_template('404.php', [
	'categories_array' => $categories_array
]);



$page_content = include_template('lot.php', [
	'categories_array' => $categories_array,
	'lots_array' => $lots_array[0]
]);

$layout_content = include_template('layout.php', [
	'is_auth' => $is_auth,
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Главная',
	'user_name' => $user[0]['name']
]);

print($layout_content);