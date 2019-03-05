<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');


if(isset($_GET['lot_id'])) {
	$sql = "SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . intval($_GET['lot_id']);
	$lots_array = fetch_data($connect, $sql);

    $sql = "SELECT amount FROM rates WHERE lot_id = " . intval($_GET['lot_id']) . " ORDER BY date_add DESC LIMIT 1";
    $current_price = fetch_data($connect, $sql);

    $price = $current_price[0]['amount'] ?? $lots_array[0]['start_price'];

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
            'content' => $page_content,
            'categories_array' => $categories_array,
            'title' => 'Просмотр лота',
            'user_name' => ""
        ]);
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rate = $_POST;
        $errors = [];

        if (!$rate['cost']) {
            $errors['cost'] = "Введите вашу ставку";
        } else if (!filter_var($rate['cost'], FILTER_VALIDATE_INT) || $rate['cost'] < 0) {
            $errors['cost'] = "Введите целое число больше нуля";
        } else if (filter_var($rate['cost'], FILTER_VALIDATE_INT) && $rate['cost'] < ($price + $lots_array[0]['step'])) {
            $errors['cost'] = "Ваша ставка должна быть не меньше минимальной";
        }
        print('<pre>');
        print_r('ставка: '. $rate['cost'] . '<br>');
        print_r($errors);
        print('</pre>');

        $page_content = include_template('lot.php', [
            'categories_array' => $categories_array,
            'lots_array' => $lots_array[0],
            'current_price' => $price,
            'rate' => $rate,
            'errors' => $errors,
            'user_name' => $user[0]['name']
        ]);


        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'categories_array' => $categories_array,
            'title' => 'Просмотр лота',
            'user_name' => $user[0]['name']
        ]);

    } else {
        $page_content = include_template('lot.php', [
			'categories_array' => $categories_array,
			'lots_array' => $lots_array[0],
            'current_price' => $price,
            'user_name' => $user[0]['name']
		]);


        $layout_content = include_template('layout.php', [
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
        'content' => $page_content,
        'categories_array' => $categories_array,
        'title' => 'Просмотр лота',
        'user_name' => ""
    ]);

}

print($layout_content);