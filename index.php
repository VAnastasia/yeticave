<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$page_error = include_template('404.php', [
	'categories_array' => $categories_array
]);

$navigation = include_template('navigation.php', [
    'categories_array' => $categories_array,
    ]);

if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    $sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name FROM lots JOIN categories ON lots.category_id = categories.id WHERE categories.id = " . $category_id . " ORDER BY lots.date_create DESC";
    $lots_array = fetch_data($connect, $sql);

}

$page_content = include_template('index.php', [
	'categories_array' => $categories_array,
	'lots_array' => $lots_array
]);


if (empty($_SESSION)) {
    $layout_content = include_template('layout.php', [
        'navigation' => $navigation,
        'content' => $page_content,
        'title' => 'Главная',
        'user_name' => ""
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'navigation' => $navigation,
        'content' => $page_content,
        'title' => 'Главная',
        'user_name' => $user[0]['name']
    ]);

}

print($layout_content);



