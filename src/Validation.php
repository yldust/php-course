<?php
namespace Base;

class Validation
{
    const ERROR_NAME = 'Имя должно содержать только буквы (A-z, А-я)';
    const ERROR_EMAIL = 'E-mail адрес указан неверно';
    const ERROR_PASSWORD = 'Пароль слишком короткий';
    const ERROR_USER_EXIST = 'Пользователь с таким именем уже существует';
    const ERROR_DIFFERENT_PASSWORDS = 'Пароли не совпадают';
    const ERROR_EMPTY_MESSAGE = 'Сообщение не может быть пустым';
    const ERROR_SOMETHING_WRONG = 'Что-то пошло не так... Попробуйте еще раз.';

    /**
     * @param string $name
     * @return bool
     */
    public static function isValidName(string $name): bool
    {
        $pattern = '/^.{1,255}$/';
        if (!preg_match($pattern, $name)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function isValidEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $password
     * @return bool
     */
    public static function isValidPassword(string $password): bool
    {
        $pattern = '/^.{5,50}$/';
        if (!preg_match($pattern, $password)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $password1
     * @param string $password2
     * @return bool
     */
    public static function isEqualPasswords(string $password1, string $password2): bool
    {
        if ($password1 != $password2) {
            return false;
        }

        return true;
    }

}