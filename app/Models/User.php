<?php
require_once __DIR__ . '/../../config/Database.php';
// require_once __DIR__ . '../../Controllers/UserController.php';

class User {
    private $conn;

    public function __construct() {
        $db = new Database("crud_1");
        $this->conn = $db->conn;
    }

    public function create($username, $password) {
        $encryptedPassword= base64_encode($password);
        $stmt = $this->conn->prepare("INSERT INTO crud_1 (UserName, Password) VALUES (?, ?)");
        // $stmt->bind_param("ss", $username, $password);
        $stmt->bind_param("ss", $username, $encryptedPassword);
        return $stmt->execute();
    }

    public function update($id, $UserName, $Password) {
        // echo 'Hello';
        // exit;
        $encryptedPassword = base64_encode($Password);
        $stmt = $this->conn->prepare("UPDATE crud_1 SET UserName = ?, Password = ? WHERE ID = ?");
        // $stmt->bind_param("ssi", $UserName, $Password, $id);
        $stmt->bind_param("ssi", $UserName, $encryptedPassword, $id);
        return $stmt->execute();
    }


    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM crud_1 WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    public function readAll() {
        $result = $this->conn->query("SELECT * FROM crud_1");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM crud_1 WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        // if ($user) {
        //     $user['Password'] = base64_decode($user['Password']);
        // }
        return $user;
    }
}
?>
