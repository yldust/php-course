<?php

namespace App\Controller;

use Base\AbstractController;
use App\Model\Message;
use Base\Validation;

class Blog extends AbstractController
{
    public function indexAction()
    {
        $errors = [];
        $messages = [];

        if ($this->isUserAuthorized()) {
            $messages = Message::getList();

            if (!$messages) {
                $errors[] = Validation::ERROR_SOMETHING_WRONG;
            } else {
                usort($messages, function ($elm1, $elm2) {
                    return strtotime($elm1->getCreatedAt()) > strtotime($elm2->getCreatedAt());
                });
            }
        }

        return $this->view->render('Blog/index.phtml', [
                'isAuth' => $this->isUserAuthorized(),
                'user' => $this->getUser(),
                'messages' => $messages,
                'errors' => $errors
            ]
        );
    }

    public function addMessageAction()
    {
        $errors = [];

        if ($this->isUserAuthorized() && isset($_POST['text'])) {

            $text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);

            if (!$text) {
                $errors[] = Validation::ERROR_EMPTY_MESSAGE;
                return Validation::ERROR_EMPTY_MESSAGE;
            }

            if (empty($errors)) {
                $message = new Message([
                    'text' => $text,
                    'user_id' => $this->getUserId(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if (!$message->save()) {
                    //$errors[] = Validation::ERROR_SOMETHING_WRONG;
                    return Validation::ERROR_SOMETHING_WRONG;
                }
            }
        }

        $this->redirect('/blog');

        /*$this->view->assign('errors', $errors);
        return $this->view->render('Blog/index.phtml', [
            'isAuth' => $this->isUserAuthorized(),
            'errors' => $errors
        ]);*/
    }

    public function testTwigAction()
    {
        return $this->view->renderTwig('Blog/testTwig.twig', [
            'name' => 'Василий',
            'firstName' => 'Пупкин'
            ]
        );
    }
}
