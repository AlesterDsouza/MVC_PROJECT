<?php

require_once __DIR__ . '/../Models/User.php';

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'create') {
    $controller->createUser($_POST);
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $controller->deleteUser($_GET['id']);
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {
 
    $controller->updateUser($_GET['id'],$_POST);
    
   
}

// class UserController {
//     private $userModel;

//     public function __construct() {
//         $this->userModel = new User();
//         if (session_status() == PHP_SESSION_NONE) {
//             session_start();
//         }
//     }

//     public function listUsers() {
//         $users = $this->userModel->readAll();
//         require_once '../app/Views/user_list.php';
//     }

//     public function createUser($userData) {
//         $this->userModel->create($userData['UserName'], $userData['Password']);
//         header('Location: ../app/Views/user_list.php'); // Updated path
//         exit();
//     }

//     public function editUser($id) {
//         $user = $this->userModel->find($id);
//         require_once '../app/Views/edit.php'; // Updated path
//     }

//     public function updateUser($id, $userData) {
//         $this->userModel->update($id, $userData['UserName'], $userData['Password']);
//         header('Location: ../app/Views/user_list.php'); // Updated path
//     }

//     public function deleteUser($id) {
//         $this->userModel->delete($id);
//         header('Location: ../app/Views/user_list.php'); // Updated path
//         exit;
//     }
// }






class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function listUsers() {
        $users = $this->userModel->readAll();
        require_once '../app/Views/user_list.php';
    }

    public function createUser($userData) {
        // echo 'Hello';
        // exit;
        $this->userModel->create($userData['UserName'], $userData['Password']);
        echo "User created successfully";
        header('Location: ../Views/user_list.php');
        // header('Location: /var/www/html/MVC_PROJECTPRACTICE/app/Views/create.php');
        exit();
    }

    public function editUser($id) {

        $user = $this->userModel->find($id);
        // require_once '../app/Views/edit.php';
        require_once '../Views/edit.php';
    }

    public function updateUser($id, $userData) {
        $this->userModel->update($id, $userData['UserName'], $userData['Password']);
        header('Location: ../Views/user_list.php');
    }

    public function deleteUser($id) {
        // echo 'Hello';
        // exit;
        $this->userModel->delete($id);
        header('Location: ../Views/user_list.php');
        exit;
    }
}





//Sample delete function

// public function deleteData($table, $fildes, $delid): void
// {
//     // SQL to delete a record by ID
//     $sql = "DELETE FROM $table WHERE $fildes ='$delid';";

//     $result = $this->conn->query($sql);

//     // Check for success and redirect
//     if ($result) {
//         header('location:../view/display.php?msg=del'); // Redirect on success
//     } else {
//         echo "Error" . $sql . "<br>" . $this->conn->error;
//     }
// }