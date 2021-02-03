<?php


namespace App\Model;

use Base\AbstractModel;
use Base\Db;

class Message extends AbstractModel
{
    private $id;
    private $userId;
    private $author;
    private $text;
    private $createdAt;

    public function __construct(array $data = [])
    {
        if ($data) {
            $this->id = $data['id'];
            $this->userId = $data['user_id'];
            $this->text = $data['text'];
            $this->createdAt = $data['created_at'];

            if (isset($data['author'])) {
                $this->author = $data['author'];
            }
        }
    }

    public function save(): int
    {
        $db = Db::getInstance();

        $insert = "INSERT INTO `messages` (`user_id`, `text`) VALUES (
            :user_id, :text
        )";

        $db->exec($insert, __METHOD__, [
            ':user_id' => $this->userId,
            ':text' => $this->text,
        ]);

        $id = $db->lastInsertId();
        $this->id = $id;

        return $id;
    }

    public function getList(int $limit = 20): array
    {
        $db = Db::getInstance();
        $query = "SELECT t1.*, t2.name as author from `messages` as t1, `users` as t2 
            where t1.user_id = t2.id ORDER BY created_at DESC LIMIT $limit
        ";
        $data = $db->fetchAll($query, __METHOD__);

        if (!$data) {
            return [];
        }

        $messages = [];
        foreach ($data as $elem) {
            $message = new self($elem);
            $messages[] = $message;
        }

        return $messages;
    }

    public static function getMessagesByUserId(int $userId, int $limit): array
    {
        $db = Db::getInstance();
        $data = $db->fetchAll(
            "SELECT * fROM `messages` WHERE user_id = $userId LIMIT $limit",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $messages = [];
        foreach ($data as $elem) {
            $message = new self($elem);
            $messages[] = $message;
        }

        return $messages;
    }

    public static function deleteMessage(int $messageId)
    {
        $db = Db::getInstance();
        $query = "DELETE FROM messages WHERE id = $messageId";
        return $db->exec($query, __METHOD__);
    }

    public function getArray()
    {
        return [
            'id' => $this->id,
            'author_id' => $this->authorId,
            'text' => $this->text,
            'created_at' => $this->createdAt,
            'image' => $this->image
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    protected function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
