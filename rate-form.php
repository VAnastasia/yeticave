<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

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
}