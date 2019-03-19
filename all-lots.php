<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$page_error = include_template('404.php', [
    'categories_array' => $categories_array
]);

$navigation = include_template('navigation.php', [
    'categories_array' => $categories_array
]);

$page_content = include_template('all-lots.php', [
    'navigation' => $navigation,
    'categories_array' => $categories_array,
    'lots_array' => $lots_array
]);

if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    $sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name FROM lots JOIN categories ON lots.category_id = categories.id WHERE categories.id = " . $category_id . " ORDER BY lots.date_create DESC";
    $lots_array = fetch_data($connect, $sql);

    $sql = "SELECT * FROM categories WHERE id = " . $category_id;
    $categories_array = fetch_data($connect, $sql);

    $page_content = include_template('all-lots.php', [
        'navigation' => $navigation,
        'categories_array' => $categories_array,
        'lots_array' => $lots_array,
        'pages' => "",
        'cur_page' => 0

    ]);

    if (!empty($lots_array)) {
        $cur_page = $_GET['page'] ?? 1;
        $page_items = 3;

        $result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM lots WHERE category_id = " . $category_id);
        $items_count = mysqli_fetch_assoc($result)['cnt'];

        $pages_count = ceil($items_count / $page_items);
        $offset = ($cur_page - 1) * $page_items;

        $pages = range(1, $pages_count);

        $sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name FROM lots JOIN categories ON lots.category_id = categories.id WHERE categories.id = " . $category_id . " ORDER BY lots.date_create DESC LIMIT " . $page_items . " OFFSET " . $offset;
        $lots_array = fetch_data($connect, $sql);

        $page_content = include_template('all-lots.php', [
            'navigation' => $navigation,
            'categories_array' => $categories_array,
            'lots_array' => $lots_array,
            'pages' => $pages,
            'cur_page' => $cur_page

        ]);

    }

    if (empty($categories_array)) {
        $page_content = $page_error;
    }

}

if (empty($_SESSION)) {
    $layout_content = include_template('layout.php', [
        'navigation' => $navigation,
        'content' => $page_content,
        'title' => 'Все лоты',
        'user_name' => ""
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'navigation' => $navigation,
        'content' => $page_content,
        'title' => 'Все лоты',
        'user_name' => $user[0]['name'],
        'avatar' => $user[0]['avatar']
    ]);

}

print($layout_content);