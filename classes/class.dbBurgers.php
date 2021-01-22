<?php

class DBBurgers
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM `users` WHERE `email`=:email";
        return $this->db->fetchOne($query, [':email' => $email]);
    }

    public function createUser(array $data)
    {
        $query = "INSERT INTO `users`(`email`, `name`, `phone`) VALUES (:email, :name, :phone)";
        $result = $this->db->exec($query, [
            ':email' => $data['email'],
            ':name' => $data['name'],
            ':phone' => $data['phone']
        ]);

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function incOrdersCount($userId)
    {
        $query = "UPDATE `users` SET `orders_count`=`orders_count`+1 WHERE `id`=:user_id";
        return $this->db->exec($query, ['user_id' => $userId]);
    }

    public function createOrder($userId, array $data)
    {
        $query = "INSERT INTO `orders` (`user_id`, `ordertime`, `street`, `address`, `comment`, 
                      `change_money`, `payment_method`, `callback`)
              VALUES (:userId, :ordertime, :street, :address, :comment, :change_money, :payment, :callback)";

        $result = $this->db->exec($query, [
                ':userId' => $userId,
                ':ordertime' => date('Y-m-d H:i:s'),
                ':street' => $data['street'],
                ':address' => $data['address'],
                ':comment' => $data['comment'],
                ':change_money' => $data['change_money'],
                ':payment' => $data['payment'],
                ':callback' => $data['callback']
            ]
        );

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

}