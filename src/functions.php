<?php
/*
 * Задание #3.1
 * Программно создайте массив из 50 пользователей, у каждого пользователя есть поля id, name и age:
 * id - уникальный идентификатор, равен номеру эл-та в массиве
 * name - случайное имя из 5-ти возможных (сами придумайте каких)
 * age - случайное число от 18 до 45
 * 1. Преобразуйте массив в json и сохраните в файл users.json
 * 2. Откройте файл users.json и преобразуйте данные из него обратно ассоциативный массив РНР.
 * 3. Посчитайте количество пользователей с каждым именем в массиве
 * 4. Посчитайте средний возраст пользователей
 */

function task1 ($array, $fileName)
{
    $json = json_encode($array, JSON_UNESCAPED_UNICODE);
    return file_put_contents($fileName, $json);
}

function task2 ($fileName)
{
    if (file_exists(!$fileName)) {
        return "Файл $fileName не существует";
    }

    $str = file_get_contents($fileName) ?? "";

    return json_decode($str, JSON_UNESCAPED_UNICODE);
}

function task3 ($users)
{
    $stat = [];

    foreach ($users as $user) {
        $stat[$user['name']] = ($stat[$user['name']] ?? 0) + 1;
    }

    return $stat;
}

function task4 ($users)
{
    $ageSum = 0;

    foreach ($users as $user) {
        $ageSum += $user['age'];
    }

    return $ageSum / sizeof($users);
}
