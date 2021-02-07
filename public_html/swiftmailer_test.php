<?php
require_once '../vendor/autoload.php';

// Create the Transport
const MAIL_SMTP_HOST = 'smtp.yandex.com';
const MAIL_USER_LOGIN = 'swiftmailtest@yandex.ru';
const MAIL_USER_PASSWORD = 'hggj737Ujjkpli';
const MAIL_SMTP_PORT = 465;
const MAIL_ENCRYPTION = 'SSL';

$targetEmail = 'Ваш email адрес назначения';

$transport = (new Swift_SmtpTransport(MAIL_SMTP_HOST, MAIL_SMTP_PORT, MAIL_ENCRYPTION))
    ->setUsername(MAIL_USER_LOGIN)
    ->setPassword(MAIL_USER_PASSWORD)
;

$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message('Проверка отправки письма'))
    ->setFrom([MAIL_USER_LOGIN => 'Администратор'])
    ->setTo([$targetEmail])
    ->setBody('Здравствуйте. Это проверка отправки письма с помощью Swift Mailer');

$result = $mailer->send($message);
var_dump($result);

