<?php

require_once('functions.php');


$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM categories";
$categories_array = fetch_data($connect, $sql);

$sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name FROM lots JOIN categories ON lots.category_id = categories.id ORDER BY lots.date_create DESC";
$lots_array = fetch_data($connect, $sql);

$sql = "SELECT lot_id, SUM(amount) AS total_rate FROM rates GROUP BY lot_id";
$rates_array = fetch_data($connect, $sql);
