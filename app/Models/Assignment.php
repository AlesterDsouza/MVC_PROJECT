<?php

// require_once 'config/Database1.php';
require_once __DIR__ . '/../../config/Database.php';

class Assignment {
    private $conn;

    public function __construct() {
        $db = new Database("MVCStudent");
        $this->conn = $db->conn;
    }

    public function createAssignment($rollNo, $title, $description, $dueDate) {
        $stmt = $this->conn->prepare("INSERT INTO assignments (roll_no, title, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $rollNo, $title, $description, $dueDate);
        return $stmt->execute();
    }

    public function deleteAssignment($id) {
        $stmt = $this->conn->prepare("DELETE FROM assignments WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function readAllAssignments() {
        $result = $this->conn->query("SELECT * FROM assignments");
        return $result->fetch_all(MYSQLI_ASSOC); // returns an array
    }

    public function countAssignments($search = '') {
        $search = "%" . $this->conn->real_escape_string($search) . "%"; // Sanitize search input
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM assignments WHERE title LIKE ? OR description LIKE ?");
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count; // returns the total number of assignments
    }



    public function fetchAssignments($search = '', $limit = 5, $offset = 0, $rollNo = null) {
        $search = "%" . $this->conn->real_escape_string($search) . "%"; // Sanitize search input
        if ($rollNo) {
            $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE (title LIKE ? OR description LIKE ?) AND roll_no = ? LIMIT ? OFFSET ?");
            $stmt->bind_param("ssiii", $search, $search, $rollNo, $limit, $offset);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE title LIKE ? OR description LIKE ? LIMIT ? OFFSET ?");
            $stmt->bind_param("ssii", $search, $search, $limit, $offset);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // returns an array of assignments
    }
    

    public function updateAssignment($id, $title, $description, $dueDate) {
        $stmt = $this->conn->prepare("UPDATE assignments SET title = ?, description = ?, due_date = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $dueDate, $id);
        return $stmt->execute();
    }

    public function findAssignmentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // returns a single assignment
    }

    public function getAssignmentsByRollNo($rollNo) {
        $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE roll_no = ?");
        $stmt->bind_param("i", $rollNo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // returns an array of assignments for the specific roll number
    }
}




//Sample 2:-

// require_once __DIR__ . '/../config/Database1.php';
// require_once '/var/www/html/MVC_PROJECTPRACTICE/config/Database1.php';
// require_once __DIR__ . '/../../config/Database1.php';

// class Assignment {
//     private $conn;

//     public function __construct() {
//         $db = new Database("MVCStudent");
//         $this->conn = $db->getConnection();
//     }

//     public function getAssignmentsByRollNo($rollNo) {
//         $sql = "SELECT * FROM assignments WHERE roll_no = $rollNo";
//         return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
//     }

//     public function createAssignment($rollNo, $title, $description, $dueDate) {
//         $sql = "INSERT INTO assignments (roll_no, title, description, due_date) VALUES ('$rollNo', '$title', '$description', '$dueDate')";
//         $this->conn->query($sql);
//     }

//     public function updateAssignment($id, $title, $description, $dueDate) {
//         $sql = "UPDATE assignments SET title='$title', description='$description', due_date='$dueDate' WHERE id=$id";
//         $this->conn->query($sql);
//     }

//     public function deleteAssignment($id) {
//         $sql = "DELETE FROM assignments WHERE id=$id";
//         $this->conn->query($sql);
//     }

//     public function findAssignmentById($id) {
//         $sql = "SELECT * FROM assignments WHERE id = $id";
//         return $this->conn->query($sql)->fetch_assoc();
//     }
// }




// require_once 'Database.php';


// class Assignment {
//     private $db;

//     public function __construct() {
//         $this->db = new Database();
//     }

//     public function getAssignmentsByRollNo($rollNo) {
//         $query = "SELECT * FROM assignments WHERE roll_no = ?";
//         return $this->db->query($query, [$rollNo]);
//     }

//     public function createAssignment($rollNo, $title, $description, $dueDate) {
//         $query = "INSERT INTO assignments (roll_no, title, description, due_date) VALUES (?, ?, ?, ?)";
//         return $this->db->query($query, [$rollNo, $title, $description, $dueDate]);
//     }

//     public function findAssignmentById($id) {
//         $query = "SELECT * FROM assignments WHERE id = ?";
//         return $this->db->query($query, [$id])->fetch();
//     }

//     public function updateAssignment($id, $title, $description, $dueDate) {
//         $query = "UPDATE assignments SET title = ?, description = ?, due_date = ? WHERE id = ?";
//         return $this->db->query($query, [$title, $description, $dueDate, $id]);
//     }

//     public function deleteAssignment($id) {
//         $query = "DELETE FROM assignments WHERE id = ?";
//         return $this->db->query($query, [$id]);
//     }
// }


//Sample 2:

// require_once __DIR__ . '/../../config/Database.php';

// class Assignment {
//     private $conn;

//     public function __construct() {
//         $db = new Database("MVCStudent");
//         $this->conn = $db->conn;
//     }

//     public function getAssignmentsByRollNo($rollNo) {
//         $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE roll_no = ?");
//         $stmt->bind_param("i", $rollNo);
//         $stmt->execute();
//         return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//     }

//     public function createAssignment($rollNo, $title, $description, $dueDate) {
//         $stmt = $this->conn->prepare("INSERT INTO assignments (roll_no, title, description, due_date) VALUES (?, ?, ?, ?)");
//         $stmt->bind_param("isss", $rollNo, $title, $description, $dueDate);
//         return $stmt->execute();
//     }

//     public function updateAssignment($id, $title, $description, $dueDate) {
//         $stmt = $this->conn->prepare("UPDATE assignments SET title = ?, description = ?, due_date = ? WHERE id = ?");
//         $stmt->bind_param("sssi", $title, $description, $dueDate, $id);
//         return $stmt->execute();
//     }

//     public function deleteAssignment($id) {
//         $stmt = $this->conn->prepare("DELETE FROM assignments WHERE id = ?");
//         $stmt->bind_param("i", $id);
//         return $stmt->execute();
//     }

//     public function findAssignmentById($id) {
//         $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE id = ?");
//         $stmt->bind_param("i", $id);
//         $stmt->execute();
//         return $stmt->get_result()->fetch_assoc();
//     }
// }

?>




















