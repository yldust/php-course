<?php

namespace App\Controller;

use Base\AbstractController;
use App\Model\User as UserModel;
use Base\Validation;

class Login extends AbstractController
{
    public function indexAction()
    {
        if (!$this->isUserAuthorized()) {
            if (!empty($_POST['email'] && !empty($_POST['password']))) {
                $password = UserModel::getPasswordHash($_POST['password']);
                $user = UserModel::getUserByPassword(strtolower($_POST['email']), $password);

                if (!$user) {
                    $this->view->assign('error', 'Неверный логин и пароль');
                } else {
                    $this->session->authUser($user->getId());
                    $this->redirect('/');
                }
            }
        }

        $this->view->assign('isAuth', $this->isUserAuthorized());
        return $this->view->render('Login/index.phtml');
    }

    public function registerAction()
    {
        $errors = [];

        if (!empty($_POST)) {

            if (!Validation::isEqualPasswords($_POST['password'], $_POST['password_repeat'])) {
                $errors[] = Validation::ERROR_DIFFERENT_PASSWORDS;
            }

            if (!Validation::isValidEmail($_POST['email'])) {
                $errors[] = Validation::ERROR_EMAIL;
            }

            if (!Validation::isValidName($_POST['name'])) {
                $errors[] = Validation::ERROR_NAME;
            }

            if (!Validation::isValidPassword($_POST['password'])) {
                $errors[] = Validation::ERROR_PASSWORD;
            }

            $user = UserModel::getByEmail($_POST['email']);

            if ($user) {
                $errors[] = Validation::ERROR_USER_EXIST;
            }

            if (empty($errors)) {
                $user = (new UserModel())
                    ->setName($_POST['name'])
                    ->setEmail(strtolower($_POST['email']))
                    ->setPassword(UserModel::getPasswordHash($_POST['password']));

                $userId = $user->save();

                if ($userId) {
                    $this->session->authUser($user->getId());
                    $this->redirect('/');
                }
            }
        }

        $this->view->assign('errors', $errors);
        //$this->view->assign('isAuth', $this->isUserAuthorized());
        return $this->view->render('Login/register.phtml');
    }

    public function logoutAction()
    {
        session_destroy();
        $this->redirect('/login');
    }
}
