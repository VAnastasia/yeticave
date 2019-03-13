<?php

require_once 'vendor/autoload.php';
require_once('init.php');
require_once('functions.php');
require_once('data.php');

$sql = "SELECT DISTINCT lots.id, lots.title, lots.image FROM lots JOIN rates ON lots.id = rates.lot_id WHERE rates.user_id = " . $safe_id . " AND DAY(date_finish) = DAY(NOW()) AND lots.win_id IS NULL";
$my_lots = fetch_data($connect, $sql);

$lots = [];
$lot = [];

foreach ($my_lots as $my_lot) {
    $sql = "SELECT rates.user_id FROM rates WHERE rates.lot_id = " . $my_lot['id'] . " ORDER BY rates.date_add DESC LIMIT 1";
    $last_rate = fetch_data($connect, $sql);

    $sql = "SELECT amount, user_id, date_add FROM rates WHERE rates.lot_id = " . $my_lot['id'] . " AND rates.user_id = " . $safe_id . " ORDER BY rates.date_add DESC LIMIT 1";
    $my_rate = fetch_data($connect, $sql);

    $sql = "SELECT name, date_finish FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = " . $my_lot['id'];
    $lot_category = fetch_data($connect, $sql);

    $sql = "SELECT contact FROM users WHERE id = " . $last_rate[0]['user_id'];
    $lot_contacts = fetch_data($connect, $sql);

    $lot['id'] = $my_lot['id'];
    $lot['image'] = $my_lot['image'];
    $lot['link'] = "lot.php?lot_id=" . $my_lot['id'];
    $lot['title'] = $my_lot['title'];
    $lot['last_rate'] = $last_rate[0]['user_id'];
    $lot['my_rate'] = $my_rate[0]['amount'];
    $lot['date_add'] = $my_rate[0]['date_add'];
    $lot['date_finish'] = $lot_category[0]['date_finish'];
    $lot['category'] = $lot_category[0]['name'];
    $lot['contacts'] = $lot_contacts[0]['contact'];
    $lot['winner'] = $last_rate[0]['user_id'];
    if ((strtotime($lot['date_finish']) < strtotime('now')) && ($lot['last_rate'] !== $safe_id)) {
        $lot['rate_state'] = "rates__item--end";
        $lot['timer'] = "timer--end";
    } else if ((strtotime($lot['date_finish']) < strtotime('now')) && ($lot['last_rate'] === $safe_id)) {
        $lot['rate_state'] = "rates__item--win";
        $lot['timer'] = "timer--win";
    } else {
        $lot['rate_state'] = "";
        $lot['timer'] = "";
    }

    if ($lot['winner'] === $safe_id) {
        $sql = 'UPDATE lots SET win_id = (?) WHERE id = ' . $lot['id'];
        $stmt = db_get_prepare_stmt($connect, $sql, [$lot['winner']]);
        $res = mysqli_stmt_execute($stmt);

        $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
        $transport->setUsername("keks@phpdemo.ru");
        $transport->setPassword("htmlacademy");

        $mailer = new Swift_Mailer($transport);

        $msg_content = include_template('email.php', ['lot' => $lot, 'user' => $user[0]]);

        $message = new Swift_Message();
        $message->setSubject("Ваша ставка победила");
        $message->setTo([$user[0]['email'] => $user[0]['name']]);
        $message->setBody($msg_content, 'text/html');
        $message->setFrom('keks@phpdemo.ru', 'Yeticave');
        $result = $mailer->send($message);

    }
}
