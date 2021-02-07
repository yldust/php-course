<?php
namespace App\Model;

use Base\AbstractModel;
use Base\Db;

class User extends AbstractModel
{
    private $id;
    private $email;
    private $name;
    private $password;
    private $createdAt;
    private $role;

    public function __construct(array $data = [])
    {
        if ($data) {
            $this->id = $data['id'];
            $this->email = $data['email'];
            $this->name = $data['name'];
            $this->password = $data['password'];
            $this->createdAt = $data['created_at'];
        }
    }

    /**
     * @return int
     */
    public function save(): int
    {
        $db = Db::getInstance();
        $insert = "INSERT INTO users (`name`, `email`, `password`) VALUES (
            :name, :email, :password
        )";

        $db->exec($insert, __METHOD__, [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password
        ]);

        $id = $db->lastInsertId();
        $this->id = $id;

        return $id;
    }

    /**
     * @param string $email
     * @param string $password
     * @return static|null
     */
    public static function getUserByPassword(string $email, string $password): ?self
    {
        $db = Db::getInstance();

        $select = "SELECT * FROM `users` WHERE `email` = :email AND `password` = :password";
        $data = $db->fetchOne($select, __METHOD__, [
            ':email' => $email,
            ':password' => $password
        ]);

        if (!$data) {
            return null;
        }

        return new self($data);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE id = $id";
        $data = $db->fetchOne($select, __METHOD__);

        if (!$data) {
            return null;
        }

        return new self($data);
    }

    public static function getUserRole (int $id): string
    {
        $db = Db::getInstance();
        $select = "SELECT `role` FROM `users` WHERE `id` = $id";
        $data = $db->fetchOne($select, __METHOD__);

        if (!$data) {
            return '';
        }

        return $data['role'];
    }

    /**
     * @param string $email
     * @return static|null
     */
    public static function getByEmail(string $email): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE `email` = :email";
        $data = $db->fetchOne($select, __METHOD__, [
            ':email' => $email
        ]);

        if (!$data) {
            return null;
        }

        return new self($data);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $password
     * @return string
     */
    public static function getPasswordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ['salt'=>PASSWORD_SALT]);
    }

    public function isAdmin(): bool
    {
        $role = self::getUserRole($this->getId());
        return ($role == ADMIN_ROLE);
    }
}
