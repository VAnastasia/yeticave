<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if (empty($_SESSION)) {
    http_response_code(403);
    exit();
}

$sql = "SELECT DISTINCT lots.id, lots.title, lots.image FROM lots JOIN rates ON lots.id = rates.lot_id WHERE rates.user_id = " . $safe_id;
$my_lots = fetch_data($connect, $sql);
/*
print('<pre>');
print_r($my_lots);
print('</pre>');*/

$lots = [];
$lot = [];

foreach ($my_lots as $my_lot) {
    $sql = "SELECT rates.user_id FROM rates WHERE rates.lot_id = " . $my_lot['id'] . " ORDER BY rates.date_add DESC LIMIT 1";
    $last_rate = fetch_data($connect, $sql);

    $sql = "SELECT amount, user_id, date_add FROM rates WHERE rates.lot_id = " . $my_lot['id'] . " AND rates.user_id = " . $safe_id . " ORDER BY rates.date_add DESC LIMIT 1";
    $my_rate = fetch_data($connect, $sql);

    $sql = "SELECT name, date_finish FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . $my_lot['id'];
    $lot_category = fetch_data($connect, $sql);


    $lot['id'] = $my_lot['id'];
    $lot['image'] = $my_lot['image'];
    $lot['link'] = "lot.php?lot_id=" . $my_lot['id'];
    $lot['title'] = $my_lot['title'];
    $lot['last_rate'] = $last_rate[0]['user_id'];
    $lot['my_rate'] = $my_rate[0]['amount'];
    $lot['date_add'] = $my_rate[0]['date_add'];
    $lot['date_finish'] = $lot_category[0]['date_finish'];
    $lot['category'] = $lot_category[0]['name'];
    $lots[] = $lot;

}

print('<pre>');
print_r($lots);
print('</pre>');

$page_content = include_template('my-lots.php', [
    'lots' => $lots,
    'categories_array' => $categories_array,
    'lots_array' => $lots_array
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories_array' => $categories_array,
    'title' => 'Мои лоты',
    'user_name' => $user[0]['name']
]);

print($layout_content);