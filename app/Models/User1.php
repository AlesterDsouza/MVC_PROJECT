<?php
// require_once 'config/Database1.php';
require_once __DIR__ . '/../../config/Database.php';

class User1 {
    private $conn;

    public function __construct() {
        $db = new Database("MVCStudent");
        $this->conn = $db->conn;
    }

    public function create1($firstName, $lastName, $rollNo) {
        $stmt = $this->conn->prepare("INSERT INTO Student (FirstName, LastName, RollNo) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $firstName, $lastName, $rollNo);
        return $stmt->execute();
    }




    public function delete1($id) {
        $stmt = $this->conn->prepare("DELETE FROM Student WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Updated this method to return an array of users
    public function readAll1() {
        $result = $this->conn->query("SELECT * FROM Student");
        return $result->fetch_all(MYSQLI_ASSOC); // returns an array
    }

    // Add countUsers method for pagination
    public function countUsers($search = '') {
        $search = "%" . $this->conn->real_escape_string($search) . "%"; // Sanitize search input
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM Student WHERE FirstName LIKE ? OR LastName LIKE ?");
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count; // returns the total number of users
    }

    // Add fetchUsers method for pagination with search
    public function fetchUsers($search = '', $limit = 5, $offset = 0) {
        $search = "%" . $this->conn->real_escape_string($search) . "%"; // Sanitize search input
        $stmt = $this->conn->prepare("SELECT * FROM Student WHERE FirstName LIKE ? OR LastName LIKE ? LIMIT ? OFFSET ?");
        $stmt->bind_param("ssii", $search, $search, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // returns an array of users
    }

    public function update1($id, $firstName, $lastName, $rollNo) {
        $stmt = $this->conn->prepare("UPDATE Student SET FirstName = ?, LastName = ?, RollNo = ? WHERE ID = ?");
        $stmt->bind_param("ssii", $firstName, $lastName, $rollNo, $id);
        return $stmt->execute();
    }

    public function find1($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Student WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        return $user;
    }



    public function rollNoExists($rollNo) {
        $stmt = $this->conn->prepare("SELECT * FROM Student WHERE RollNo = ?");
        $stmt->bind_param('i', $rollNo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}



// class User1 {
//     private $conn;

//     public function __construct() {
//         $db = new Database("MVCStudent");
//         $this->conn = $db->conn;
//     }

//     public function create1($firstName, $lastName, $rollNo) {
//         $stmt = $this->conn->prepare("INSERT INTO Student (FirstName, LastName, RollNo) VALUES (?, ?, ?)");
//         $stmt->bind_param("ssi", $firstName, $lastName, $rollNo);
//         return $stmt->execute();
//     }

//     public function delete1($id) {
//         $stmt = $this->conn->prepare("DELETE FROM Student WHERE ID = ?");
//         $stmt->bind_param("i", $id);
//         return $stmt->execute();
//     }

//     public function readAll1() {
//         $result = $this->conn->query("SELECT * FROM Student");
//         return $result->fetch_all(MYSQLI_ASSOC);
//     }

//     public function update1($id, $UserName, $Password) {
//         // echo 'Hello';
//         // exit;
//         // $encryptedPassword = base64_encode($Password);
//         $stmt = $this->conn->prepare("UPDATE Student SET FirstName = ?, LastName = ? ,RollNo = ? WHERE ID = ?");
//         $stmt->bind_param("ssi", $firstName, $lastName, $rollNo, $id);
//         return $stmt->execute();
//     }

//     public function find1($id) {
//         $stmt = $this->conn->prepare("SELECT * FROM Student WHERE ID = ?");
//         $stmt->bind_param("i", $id);
//         $stmt->execute();
//         $user = $stmt->get_result()->fetch_assoc();
//         // if ($user) {
//         //     $user['Password'] = base64_decode($user['Password']);
//         // }
//         return $user;
//     }

//     public function fetchUsers($search = '', $limit = 5, $offset = 0) {
//         $query = "SELECT * FROM Student WHERE FirstName LIKE ? OR LastName LIKE ? OR RollNo LIKE ? LIMIT ? OFFSET ?";
//         $stmt = $this->conn->prepare($query);
//         $likeSearch = "%$search%";
//         $stmt->bind_param('ssiii', $likeSearch, $likeSearch, $likeSearch, $limit, $offset);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $users = [];
//         while ($row = $result->fetch_assoc()) {
//             $users[] = $row;
//         }
//         return $users;
//     }

//     // Method to count total users for pagination purposes
//     public function countUsers($search = '') {
//         $query = "SELECT COUNT(*) as total FROM Student WHERE FirstName LIKE ? OR LastName LIKE ? OR RollNo LIKE ?";
//         $stmt = $this->conn->prepare($query);
//         $likeSearch = "%$search%";
//         $stmt->bind_param('sssss', $likeSearch, $likeSearch, $likeSearch);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         return $result->fetch_assoc()['total'];
//     }

// }
?>
