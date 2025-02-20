<?php
require_once "Module.php";

class UserModule extends Module {
    public function __construct() {
        parent::__construct("users");
    }

    public function createUser($name, $email,$password,$phone) {
        return $this->insert(["name" => $name, "email" => $email,"password"=>$password,"phone"=>$phone]);
    }
}
?>
