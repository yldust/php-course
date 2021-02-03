<?php
namespace App\Controller;

use App\Model\Message;
use Base\AbstractController;

class Api extends AbstractController
{
    public function getUserMessages(int $userId): string
    {
        if (!$userId) {
            return $this->response(['error' => 'no_user_id']);
        }

        $messages = Message::getMessagesByUserId($userId, 20);

        if (!$messages) {
            return $this->response(['error' => 'no_messages']);
        }

        $data = array_map(function (Message $message) {
            return $message->getArray();
        }, $messages);

        return $this->response(['messages' => $data]);
    }

    public function response(array $data)
    {
        header('Content-type: application/json');
        return json_encode($data);
    }
}
