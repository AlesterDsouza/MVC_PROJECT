<?php
require_once __DIR__ . '/../Models/User1.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    $userObj = new User1();
    $delete_ids = $_POST['delete_ids'];

    // Delete each selected user
    foreach ($delete_ids as $id) {
        $userObj->delete1($id);
    }

    // Redirect back to the user list page
    header('Location: ../Views/user_list1.php');
    exit();
} else {
    // Redirect if no user is selected
    header('Location: ../Views/user_list1.php');
    exit();
}
