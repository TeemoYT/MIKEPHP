<?php
require_once "Module.php";

class UserModule extends Module
{
    public function __construct()
    {
        parent::__construct("users");
    }

    public function login($email, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Login error: " . $e->getMessage());
        }
    }

    public function createUser($name, $email, $password, $phone)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return "Email đã tồn tại!";
        }

    
        return $this->insert([
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "phone" => $phone
        ]);
    }
}
