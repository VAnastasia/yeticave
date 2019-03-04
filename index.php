<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$page_error = include_template('404.php', [
	'categories_array' => $categories_array
]);

$page_content = include_template('index.php', [
	'categories_array' => $categories_array,
	'lots_array' => $lots_array
]);

if (empty($_SESSION)) {
    $layout_content = include_template('layout.php', [
        'is_auth' => "",
        'content' => $page_content,
        'categories_array' => $categories_array,
        'title' => 'Главная',
        'user_name' => ""
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'is_auth' => $is_auth,
        'content' => $page_content,
        'categories_array' => $categories_array,
        'title' => 'Главная',
        'user_name' => $user[0]['name']
    ]);

}

print($layout_content);



