<?php

require_once('functions.php');

session_start();

$user_id = $_SESSION['user']['id'] ?? null;
$safe_id = intval($user_id);

$connect = mysqli_init();
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($connect, "localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");