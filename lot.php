<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(isset($_GET['lot_id'])) {
	$sql = "SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . intval($_GET['lot_id']);
	$lots_array = fetch_data($connect, $sql);

	if(empty($lots_array)) {
		/*http_response_code(404);
		exit();*/
		$page_content = include_template('404.php', [
			'categories_array' => $categories_array
		]);
	} else {
		$page_content = include_template('lot.php', [
			'categories_array' => $categories_array,
			'lots_array' => $lots_array[0]
		]);
	}
}

$layout_content = include_template('layout.php', [
	'is_auth' => $is_auth,
	'content' => $page_content,
	'categories_array' => $categories_array,
	'title' => 'Просмотр лота',
	'user_name' => $user[0]['name']
]);

print($layout_content);