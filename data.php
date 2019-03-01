<?php

require_once('functions.php');


$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM categories";
$categories_array = fetch_data($connect, $sql);

$sql = "SELECT lots.id, date_create, title, image, start_price, date_finish, name FROM lots JOIN categories ON lots.category_id = categories.id ORDER BY lots.date_create DESC";
$lots_array = fetch_data($connect, $sql);


// массив категорий
//$categories_array = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

// массив объявлений
/*$lots_array = [
	[
		'name_lot' => '2014 Rossignol District Snowboard',
		'category_lot' => $categories_array[0],
		'price_lot' => 10999,
		'url_lot' => 'img/lot-1.jpg'
	],

	[
		'name_lot' => 'DC Ply Mens 2016/2017 Snowboard',
		'category_lot' => $categories_array[0],
		'price_lot' => 159999,
		'url_lot' => 'img/lot-2.jpg'
	],

	[
		'name_lot' => 'Крепления Union Contact Pro 2015 года размер L/XL',
		'category_lot' => $categories_array[1],
		'price_lot' => 8000,
		'url_lot' => 'img/lot-3.jpg'
	],

	[
		'name_lot' => 'Ботинки для сноуборда DC Mutiny Charocal',
		'category_lot' => $categories_array[2],
		'price_lot' => 10999,
		'url_lot' => 'img/lot-4.jpg'
	],

	[
		'name_lot' => 'Куртка для сноуборда DC Mutiny Charocal',
		'category_lot' => $categories_array[3],
		'price_lot' => 7500,
		'url_lot' => 'img/lot-5.jpg'
	],

	[
		'name_lot' => 'Маска Oakley Canopy',
		'category_lot' => $categories_array[5],
		'price_lot' => 5400,
		'url_lot' => 'img/lot-6.jpg'
	]

];*/