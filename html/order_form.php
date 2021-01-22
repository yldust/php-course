<?php
/*
 * 1. Проверить, существует ли уже пользователь с таким email,
 * если нет - создать его, если да - увеличить число заказов по этому email.
 * Двух пользователей с одинаковым email быть не может.
 * 2. Сохранить данные заказа - id пользователя, сделавшего заказ, дату заказа, полный адрес клиента.
 * 3. Скрипт должен вывести пользователю:
 * Спасибо, ваш заказ будет доставлен по адресу: “тут адрес клиента”
 * Номер вашего заказа: #ID
 * Это ваш n-й заказ!
 */

require_once '../settings/site_config.php';
require_once '../classes/class.db.php';
require_once '../classes/class.dbBurgers.php';

if (isset($_POST['email']) || isset($_POST['name']) || isset($_POST['phone']) || isset($_POST['street']) ||
    isset($_POST['home'])) {

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
    $home = filter_var($_POST['home'], FILTER_SANITIZE_STRING);
    $part = filter_var($_POST['part'] ?? "", FILTER_SANITIZE_STRING);
    $appt = filter_var($_POST['appt'] ?? "", FILTER_SANITIZE_STRING);
    $floor = filter_var($_POST['floor'] ?? "", FILTER_SANITIZE_STRING);
    $comment = filter_var($_POST['comment'] ?? "", FILTER_SANITIZE_STRING);
    $change_money = isset($_POST['change_money']) ? 1 : 0;
    $payment = $_POST['payment'] ?? 0;
    $callback = isset($_POST['callback']) ? 1 : 0;

    $errors = "";

    if (!$name) {
        $errors .= 'Введите имя.<br/>';
    }

    if (!$email) {
        $errors .= 'Введите email.<br/>';
    }

    if (!$phone) {
        $errors .= 'Введите телефон.<br/>';
    }

    if (!$street) {
        $errors .= 'Введите название улицы.<br/>';
    }

    if (!$home) {
        $errors .= 'Введите номер дома.<br/>';
    }

    if (!$errors) {
        $dbBurgers = new DBBurgers();
        $user = $dbBurgers->getUserByEmail($email);

        if (!$user) {
            $userId = $dbBurgers->createUser(['name' => $name, 'email' => $email, 'phone' => $phone]);
            $ordersCount = 1;
        } else {
            $dbBurgers->incOrdersCount($user['id']);
            $userId = $user['id'];
            $ordersCount = $user['orders_count'] + 1;
        }

        if ($userId) {
            $address = $street . ', д. ' . $home . ', корпус ' . $part . ', кв ' . $appt . ', этаж ' . $floor;

            $orderData = [
                'street' => $street,
                'address' => $address,
                'comment' => $comment,
                'change_money' => $change_money,
                'payment' => $payment,
                'callback' => $callback
            ];

            $orderId = $dbBurgers->createOrder($userId, $orderData);

            echo "Спасибо, ваш заказ будет доставлен по адресу: $address<br>
                  Номер вашего заказа: #$orderId <br>
                  Это ваш $ordersCount-й заказ!";
        } else {
            echo "Произошла ошибка. Попробуйте еще раз.";
        }

    } else {
        echo $errors;
    }
}
