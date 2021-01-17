<?php
/* Задание #1
 * 1. Функция должна принимать массив строк и выводить каждую строку в отдельном параграфе (тег <p>)
 * 2. Если в функцию передан второй параметр true, то возвращать (через return)
 * результат в виде одной объединенной строки. */

function arrayToString($strArray, $return = false)
{
    if ($return === true) {
        return implode(" ", $strArray);
    } else {
        foreach ($strArray as $str) {
            echo "<p>" . $str . "</p>";
        }
    }

    return;
}

/* Задание #2
 * 1. Функция должна принимать переменное число аргументов.
 * 2. Первым аргументом обязательно должна быть строка, обозначающая арифметическое
 * действие, которое необходимо выполнить со всеми передаваемыми аргументами.
 * 3. Остальные аргументы это целые и/или вещественные числа.
 * Пример вызова: calcEverything(‘+’, 1, 2, 3, 5.2);
 * Результат: 1 + 2 + 3 + 5.2 = 11.2 */

function calc(...$args)
{
    if (sizeof($args) < 2) {
        return "Введите операнды";
    }

    $operation = $args[0];
    $result = $args[1];
    $output = "";

    switch ($operation) {
        case '+':
            for ($i = 2; $i < sizeof($args); $i++) {
                if (!is_numeric($args[$i])) {
                    return "Все операнды должны быть числом";
                }
                $result += $args[$i];
            }
            $output = implode(" + ", array_slice($args, 1)) . " = " . $result;
            break;
        case '-':
            for ($i = 2; $i < sizeof($args); $i++) {
                if (!is_numeric($args[$i])) {
                    return "Все операнды должны быть числом";
                }
                $result -= $args[$i];
            }
            $output = implode(" - ", array_slice($args, 1)) . " = " . $result;
            break;
        case '*':
            for ($i = 2; $i < sizeof($args); $i++) {
                if (!is_numeric($args[$i])) {
                    return "Все операнды должны быть числом";
                }
                $result *= $args[$i];
            }
            $output = implode(" * ", array_slice($args, 1)) . " = " . $result;
            break;
        case '/':
            for ($i = 2; $i < sizeof($args); $i++) {
                if (!is_numeric($args[$i])) {
                    return "Все операнды должны быть числом";
                }
                if ($args[$i] == 0) {
                    return "Делить на ноль нельзя";
                }
                $result /= $args[$i];
            }
            $output = implode(" / ", array_slice($args, 1)) . " = " . $result;
            break;
        default:
            echo "Неизвестный оператор";
    }

    return $output;
}

/* Задание #3 (Использование рекурсии не обязательно)
 * 1. Функция должна принимать два параметра – целые числа.
 * 2. Если в функцию передали 2 целых числа, то функция должна отобразить
 * таблицу умножения размером со значения параметров, переданных в функцию.
 * (Например если передано 8 и 8, то нарисовать от 1х1 до 8х8).
 * Таблица должна быть выполнена с использованием тега <table>
 * 3. В остальных случаях выдавать корректную ошибку. */
function multiplicationTable ($numRow, $numCol)
{
    if (!is_int($numRow) || !is_int($numCol)) {
        echo "Параметры должны быть целыми числами";
        return;
    }

    echo "<table>";

    for ($i = 1; $i <= $numRow; $i++) {
        echo "<tr>";

        for ($y = 1; $y <= $numCol; $y++) {
            echo "<td style='width: 30px; text-align: center; border: 1px black solid;'>" . $i*$y . "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
    return;
}

/* Задание #6
* 1. Создайте файл test.txt средствами PHP. Поместите в него текст - “Hello again!”.
* 2. Напишите функцию, которая будет принимать имя файла, открывать файл и выводить содержимое на экран. */

function openMyFile ($fileName) {
    if (file_exists($fileName)) {
        $data = file_get_contents($fileName);
        echo '</br>' . $data;
    } else {
        echo "Файл $fileName не существует";
    }
}


