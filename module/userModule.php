<?php
require_once "Module.php";

class UserModule extends Module {
    public function __construct() {
        parent::__construct("users");
    }

    public function login($email, $password) {
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
    public function register($name, $email, $password) {
        try {
            
            $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return "Email đã tồn tại!";
            }
    
           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
          
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);
    
            return "Đăng ký thành công!";
        } catch (PDOException $e) {
            die("Register error: " . $e->getMessage());
        }
    }
    public function createUser($name, $email,$password,$phone) {
        return $this->insert(["name" => $name, "email" => $email,"password"=>$password,"phone"=>$phone]);
    }
}
?>
