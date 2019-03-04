<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(isset($_GET['lot_id'])) {
	$sql = "SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . intval($_GET['lot_id']);
	$lots_array = fetch_data($connect, $sql);

    $sql = "SELECT amount FROM rates WHERE lot_id = " . $_GET['lot_id'] . " ORDER BY date_add DESC LIMIT 1";
    $current_price = fetch_data($connect, $sql);

    $price = $current_price[0]['amount'] ?? 0;

	if(empty($lots_array)) {
		$page_content = include_template('404.php', [
			'categories_array' => $categories_array
		]);
	} else if (empty($_SESSION)) {

        $page_content = include_template('lot.php', [
            'categories_array' => $categories_array,
            'lots_array' => $lots_array[0],
            'user_name' => ""
        ]);

        $layout_content = include_template('layout.php', [
            'is_auth' => "",
            'content' => $page_content,
            'categories_array' => $categories_array,
            'title' => 'Просмотр лота',
            'user_name' => ""
        ]);
    } else {

		$page_content = include_template('lot.php', [
			'categories_array' => $categories_array,
			'lots_array' => $lots_array[0],
            'current_price' => $price,
            'user_name' => $user[0]['name']
		]);


        $layout_content = include_template('layout.php', [
            'is_auth' => $is_auth,
            'content' => $page_content,
            'categories_array' => $categories_array,
            'title' => 'Просмотр лота',
            'user_name' => $user[0]['name']
        ]);
	}

} else {
    $page_content = include_template('404.php', [
        'categories_array' => $categories_array
    ]);


    $layout_content = include_template('layout.php', [
        'is_auth' => "",
        'content' => $page_content,
        'categories_array' => $categories_array,
        'title' => 'Просмотр лота',
        'user_name' => ""
    ]);

}
/*
print('<pre>');
print_r($current_price);
print('</pre>');*/

print($layout_content);