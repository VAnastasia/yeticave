<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $search = trim($search);

    if ($search) {
        $sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name, description FROM lots JOIN categories ON lots.category_id = categories.id WHERE MATCH (title, description) AGAINST('" . $search . "' IN BOOLEAN MODE)";
        $lots_array = fetch_data($connect, $sql);
    }

    $navigation = include_template('navigation.php', [
        'categories_array' => $categories_array,
    ]);

    $page_content = include_template('search.php', [
        'search' => $search,
        'navigation' => $navigation,
        'categories_array' => $categories_array,
        'lots_array' => $lots_array,
        'pages' => "",
        'cur_page' => 0
    ]);

    if (!empty($lots_array)) {
        $cur_page = $_GET['page'] ?? 1;
        $page_items = 3;

        $result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM lots WHERE MATCH (title, description) AGAINST('" . $search . "' IN BOOLEAN MODE)");
        $items_count = mysqli_fetch_assoc($result)['cnt'];

        $pages_count = ceil($items_count / $page_items);
        $offset = ($cur_page - 1) * $page_items;

        $pages = range(1, $pages_count);

        $sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name, description FROM lots JOIN categories ON lots.category_id = categories.id WHERE MATCH (title, description) AGAINST('" . $search . "' IN BOOLEAN MODE) LIMIT " . $page_items . " OFFSET " . $offset;
        $lots_array = fetch_data($connect, $sql);

        $page_content = include_template('search.php', [
            'search' => $search,
            'navigation' => $navigation,
            'categories_array' => $categories_array,
            'lots_array' => $lots_array,
            'pages' => $pages,
            'cur_page' => $cur_page

        ]);
    }


    if (empty($_SESSION)) {
        $layout_content = include_template('layout.php', [
            'navigation' => $navigation,
            'content' => $page_content,
            'title' => 'Поиск',
            'user_name' => ""
        ]);
    } else {
        $layout_content = include_template('layout.php', [
            'navigation' => $navigation,
            'content' => $page_content,
            'title' => 'Поиск',
            'user_name' => $user[0]['name'],
            'avatar' => $user[0]['avatar']
        ]);

    }
}

print($layout_content);