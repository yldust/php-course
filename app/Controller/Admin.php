<?php
namespace App\Controller;

use App\Model\Message;
use Base\AbstractController;
use App\Model\User as UserModel;

class Admin extends AbstractController
{
    public function deleteMessageAction()
    {
        $user = $this->getUser();

        if ($user->isAdmin()) {
            $messageId = (int)$_GET['id'];
            Message::deleteMessage($messageId);
        }

        $this->redirect('/blog');
    }
}