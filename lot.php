<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$navigation = include_template('navigation.php', [
    'categories_array' => $categories_array,
]);

if(isset($_GET['lot_id'])) {
    $lot_id = intval($_GET['lot_id']);
	$sql = "SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . $lot_id;
	$lots_array = fetch_data($connect, $sql);



    if(empty($lots_array)) {
		$page_content = include_template('404.php', [
            'navigation' => $navigation,
		]);

        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'navigation' => $navigation,
            'title' => 'Просмотр лота',
            'user_name' => "",
            'user' => ""
        ]);

    } else if (empty($_SESSION)) {
        $page_content = include_template('lot.php', [
            'rate_done' => "",
            'count_rates' => "",
            'history' => [],
            'navigation' => $navigation,
            'lots_array' => $lots_array[0],
            'user_name' => "",
            'user' => "",
            'url' => "",
        ]);

        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'navigation' => $navigation,
            'title' => 'Просмотр лота',
            'user_name' => ""
        ]);

    } else if (!empty($_SESSION)) {
        $sql = "SELECT amount FROM rates WHERE lot_id = " . $lot_id . " ORDER BY date_add DESC LIMIT 1";
        $current_price = fetch_data($connect, $sql);

        $price = $current_price[0]['amount'] ?? $lots_array[0]['start_price'];

        $sql = "SELECT lot_id, name, amount, date_add, rates.user_id FROM rates JOIN users ON rates.user_id = users.id WHERE rates.lot_id = " . $lot_id . " ORDER BY date_add DESC";
        $history = fetch_data($connect, $sql);
        $res = mysqli_query($connect, $sql);
        $count_rates = mysqli_num_rows($res);

        $sql = "SELECT lot_id, date_add, user_id FROM rates WHERE lot_id = " . $lot_id . " ORDER BY date_add DESC LIMIT 1";
        $last_rate = fetch_data($connect, $sql);

        if ($last_rate) {
            $rate_done = $last_rate[0]['user_id'] === $user[0]['id'] ? 0 : 1;
        } else {
            $rate_done = 1;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rate = $_POST;
            $errors = [];

            if (!$rate['cost']) {
                $errors['cost'] = "Введите вашу ставку";
            } else if (!filter_var($rate['cost'], FILTER_VALIDATE_INT) || $rate['cost'] < 0) {
                $errors['cost'] = "Введите целое число больше нуля";
            } else if (filter_var($rate['cost'], FILTER_VALIDATE_INT) && $rate['cost'] < ($price + $lots_array[0]['step'])) {
                $errors['cost'] = "Ваша ставка должна быть не меньше минимальной";
            }

            if (empty($errors)) {
                $sql = 'INSERT INTO rates (date_add, amount, user_id, lot_id) VALUES (NOW(), ?, ?, ?)';
                $stmt = db_get_prepare_stmt($connect, $sql, [$rate['cost'], $user[0]['id'], $lot_id]);
                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    header("Location: lot.php?lot_id=" . $lot_id);
                }
            }

            $page_content = include_template('lot.php', [
                'rate_done' => $rate_done,
                'count_rates' => $count_rates,
                'history' => $history,
                'navigation' => $navigation,
                'lots_array' => $lots_array[0],
                'current_price' => $price,
                'rate' => $rate,
                'errors' => $errors,
                'url' => "lot.php?lot_id=" . $lot_id,
                'user_name' => $user[0]['name'],
                'user' => $user[0]['id']
            ]);

/*
            $layout_content = include_template('layout.php', [
                'content' => $page_content,
                'navigation' => $navigation,
                'title' => 'Просмотр лота',
                'user_name' => $user[0]['name']
            ]);*/

        }

        $page_content = include_template('lot.php', [
            'rate_done' => $rate_done,
            'count_rates' => $count_rates,
            'history' => $history,
            'navigation' => $navigation,
			'lots_array' => $lots_array[0],
            'current_price' => $price,
            'url' => "",
            'user_name' => $user[0]['name'],
            'user' => $user[0]['id']
		]);


        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'navigation' => $navigation,
            'title' => 'Просмотр лота',
            'user_name' => $user[0]['name']
        ]);
	}

} else {
    $page_content = include_template('404.php', [
        'navigation' => $navigation,
    ]);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'navigation' => $navigation,
        'title' => 'Просмотр лота',
        'user_name' => "",
        'user' => ""
    ]);

}

print($layout_content);